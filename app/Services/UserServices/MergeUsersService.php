<?php

namespace App\Services\UserServices;

use App\Models\SystemUser;
use App\Providers\AppServiceProvider;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class MergeUsersService
{
    /**
     * Columns on system_users that are never copied from source to target,
     * regardless of whether the target's value is null. These are identity,
     * security, audit, and lifecycle fields that must stay tied to the target.
     */
    private const SYSTEM_USERS_FILL_SKIP_COLUMNS = [
        'id',
        'username',
        'passwordNew',
        'uniquePIN',
        'active',
        'canLogon',
        'dateDeactivated',
        'deactivatedBy',
        'lastPasswordChange',
        'passwordChangedBy',
        'lastLoginDate',
        'created',
        'createdby',
        'modified',
        'modifiedby',
    ];

    /**
     * Cached set of (table, column) pairs that have a single-column unique index.
     *
     * @var array<string, true>|null
     */
    private ?array $uniqueColumnIndex = null;

    private static function truncateValue(mixed $value): string
    {
        if ($value === null) {
            return '∅';
        }
        $string = is_scalar($value) ? (string) $value : json_encode($value);
        $string ??= '';

        return strlen($string) > 80 ? substr($string, 0, 79) . '…' : $string;
    }

    /**
     * Render an HTML table inside a TextEntry. One header row, one row per item.
     *
     * @param  list<string>  $columns
     * @param  list<list<string>>  $rows
     */
    private static function tableEntry(string $key, array $columns, array $rows): TextEntry
    {
        $html = view('filament.admin.data-table', [
            'columns' => $columns,
            'rows' => $rows,
        ])->render();

        return TextEntry::make($key)
            ->hiddenLabel()
            ->state($html)
            ->formatStateUsing(fn (string $state): HtmlString => new HtmlString($state));
    }

    /**
     * Build a preview of what a merge would change.
     *
     * @return array{
     *     mergeable: list<array{table: string, columns: list<string>, count: int, polymorphic: bool}>,
     *     conflicts: list<array{table: string, column: string, source_count: int, target_count: int}>,
     *     columns_to_fill: array<string, mixed>,
     *     unmerged_columns: list<array{column: string, source_value: mixed, target_value: mixed, reason: string}>,
     *     totals: array{rows_to_merge: int, rows_to_skip: int, tables_to_touch: int, tables_with_conflicts: int, columns_to_fill: int, unmerged_columns: int}
     * }
     */
    public function preview(int $sourceUserId, int $targetUserId): array
    {
        $this->guardDifferentUsers($sourceUserId, $targetUserId);

        $connection = $this->connection();
        $uniqueColumns = $this->loadUniqueColumns($connection);

        $mergeable = [];
        $conflicts = [];
        $rowsToMerge = 0;
        $rowsToSkip = 0;

        foreach (UserDataAuditService::tables() as $table => $columns) {
            $effectiveColumns = [];
            foreach ($columns as $column) {
                $key = $this->indexKey($table, $column);
                if (isset($uniqueColumns[$key])) {
                    $sourceCount = $this->countWhere($connection, $table, $column, $sourceUserId);
                    $targetCount = $this->countWhere($connection, $table, $column, $targetUserId);

                    if ($sourceCount > 0 && $targetCount > 0) {
                        $conflicts[] = [
                            'table' => $table,
                            'column' => $column,
                            'source_count' => $sourceCount,
                            'target_count' => $targetCount,
                        ];
                        $rowsToSkip += $sourceCount;

                        continue;
                    }
                }

                $effectiveColumns[] = $column;
            }

            if ($effectiveColumns === []) {
                continue;
            }

            $count = $this->countMatchingRows($connection, $table, $effectiveColumns, $sourceUserId);
            if ($count === 0) {
                continue;
            }

            $mergeable[] = [
                'table' => $table,
                'columns' => $effectiveColumns,
                'count' => $count,
                'polymorphic' => false,
            ];
            $rowsToMerge += $count;
        }

        foreach (UserDataAuditService::polymorphicTables() as $table => $pairs) {
            $count = 0;
            $columns = [];
            foreach ($pairs as $pair) {
                $count += $this->countPolymorphicRows($connection, $table, $pair['type'], $pair['id'], $sourceUserId);
                $columns[] = $pair['type'];
                $columns[] = $pair['id'];
            }
            if ($count === 0) {
                continue;
            }

            $mergeable[] = [
                'table' => $table,
                'columns' => $columns,
                'count' => $count,
                'polymorphic' => true,
            ];
            $rowsToMerge += $count;
        }

        $columnsToFill = $this->computeSystemUserGaps($connection, $sourceUserId, $targetUserId);
        $unmergedColumns = $this->computeUnmergedSystemUserFields($connection, $sourceUserId, $targetUserId);

        return [
            'mergeable' => $mergeable,
            'conflicts' => $conflicts,
            'columns_to_fill' => $columnsToFill,
            'unmerged_columns' => $unmergedColumns,
            'totals' => [
                'rows_to_merge' => $rowsToMerge,
                'rows_to_skip' => $rowsToSkip,
                'tables_to_touch' => count($mergeable),
                'tables_with_conflicts' => count($conflicts),
                'columns_to_fill' => count($columnsToFill),
                'unmerged_columns' => count($unmergedColumns),
            ],
        ];
    }

    /**
     * Build a Filament Schema (array of components) for the merge preview UI.
     * Use this from Filament UI; for non-UI callers use preview() directly.
     *
     * @return list<Component>
     */
    public function getMergePreviewAsFilamentInfoList(int $sourceUserId, int $targetUserId, SystemUser $source, SystemUser $target): array
    {
        $preview = $this->preview($sourceUserId, $targetUserId);
        $totals = $preview['totals'];

        $components = [
            Grid::make(2)->schema([
                TextEntry::make('source_user')
                    ->label('From (will be DELETED)')
                    ->state(sprintf('%s (#%d) — %s', $source->name, $source->id, $source->username))
                    ->color('danger'),
                TextEntry::make('target_user')
                    ->label('Into (will receive data)')
                    ->state(sprintf('%s (#%d) — %s', $target->name, $target->id, $target->username))
                    ->color('success'),
            ]),
            TextEntry::make('summary')
                ->hiddenLabel()
                ->state(sprintf(
                    '%d %s across %d %s will be moved.%s',
                    $totals['rows_to_merge'],
                    Str::plural('row', $totals['rows_to_merge']),
                    $totals['tables_to_touch'],
                    Str::plural('table', $totals['tables_to_touch']),
                    $totals['rows_to_skip'] > 0
                        ? sprintf(
                            ' %d %s in %d %s will be skipped due to unique-constraint conflicts.',
                            $totals['rows_to_skip'],
                            Str::plural('row', $totals['rows_to_skip']),
                            $totals['tables_with_conflicts'],
                            Str::plural('table', $totals['tables_with_conflicts']),
                        )
                        : '',
                )),
        ];

        if (count($preview['columns_to_fill']) > 0) {
            $fillRows = [];
            foreach ($preview['columns_to_fill'] as $column => $value) {
                $fillRows[] = [$column, self::truncateValue($value)];
            }

            $components[] = Section::make('Target user fields to fill')
                ->description("These columns are null/empty on the target user and will be filled from the source user's row.")
                ->collapsible()
                ->schema([
                    self::tableEntry('columns_to_fill_table', ['Column', 'Value'], $fillRows),
                ]);
        }

        if (count($preview['unmerged_columns']) > 0) {
            $unmergedRows = array_map(fn (array $u): array => [
                $u['column'],
                self::truncateValue($u['source_value']),
                self::truncateValue($u['target_value']),
                $u['reason'],
            ], $preview['unmerged_columns']);

            $components[] = Section::make('Source fields that will be lost')
                ->description("These source-user columns hold a value that won't make it onto the target. Either the target already has its own value (kept), or the column is never copied for safety.")
                ->collapsible()
                ->collapsed()
                ->schema([
                    self::tableEntry('unmerged_columns_table', ['Column', 'Source value', 'Target value', 'Reason'], $unmergedRows),
                ]);
        }

        if (count($preview['conflicts']) > 0) {
            $conflictRows = array_map(fn (array $c): array => [
                $c['table'],
                $c['column'],
                sprintf('source: %d / target: %d', $c['source_count'], $c['target_count']),
            ], $preview['conflicts']);

            $components[] = Section::make('Will NOT be merged')
                ->description('Both users have rows in these tables and the column has a unique constraint. Source rows stay attached to the deactivated source user.')
                ->schema([
                    self::tableEntry('conflicts_table', ['Table', 'Column', 'Source / target'], $conflictRows),
                ]);
        }

        if (count($preview['mergeable']) > 0) {
            $mergeableRows = array_map(fn (array $m): array => [
                $m['table'] . ($m['polymorphic'] ? ' (poly)' : ''),
                implode(', ', $m['columns']),
                sprintf('%d %s', $m['count'], Str::plural('row', $m['count'])),
            ], $preview['mergeable']);

            $components[] = Section::make('Will be merged')
                ->description(sprintf(
                    '%d %s · %d %s',
                    $totals['tables_to_touch'],
                    Str::plural('table', $totals['tables_to_touch']),
                    $totals['rows_to_merge'],
                    Str::plural('row', $totals['rows_to_merge']),
                ))
                ->collapsible()
                ->schema([
                    self::tableEntry('mergeable_table', ['Table', 'Columns', 'Count'], $mergeableRows),
                ]);
        } elseif (count($preview['conflicts']) === 0) {
            $components[] = TextEntry::make('no_data')
                ->hiddenLabel()
                ->state('No rows reference the source user. The source user record will still be deleted on confirm.')
                ->color('gray');
        }

        return $components;
    }

    /**
     * Execute the merge in a transaction. Rolls back fully on any error.
     * Captures a snapshot of all source-related data to disk before merging.
     *
     * Also fills any null/empty columns on the target user's system_users row
     * with the source user's value (audit/security fields excluded).
     *
     * After re-pointing references, the source user's row is DELETED from
     * system_users. The pre-merge snapshot is the only recovery path.
     *
     * Per-(table, column) UPDATE failures (e.g. dirty legacy data triggering
     * MySQL strict-mode coercion errors) are caught, logged, and reported in
     * the `failed_updates` array. The merge continues so one bad column
     * doesn't block the whole operation.
     *
     * @return array{
     *     rows_merged: int,
     *     rows_skipped: int,
     *     tables_touched: array<string, int>,
     *     conflicts: list<array{table: string, column: string, source_count: int, target_count: int}>,
     *     columns_filled: array<string, mixed>,
     *     failed_updates: list<array{table: string, column: string, error: string}>,
     *     demoted_role_ids: list<int>,
     *     snapshot_path: string
     * }
     *
     * @throws RuntimeException on failure (transaction is rolled back)
     */
    public function merge(int $sourceUserId, int $targetUserId, ?int $performedBy = null): array
    {
        $this->guardDifferentUsers($sourceUserId, $targetUserId);

        $connection = $this->connection();
        $preview = $this->preview($sourceUserId, $targetUserId);
        $conflictKeys = [];
        foreach ($preview['conflicts'] as $conflict) {
            $conflictKeys[$this->indexKey($conflict['table'], $conflict['column'])] = true;
        }

        $snapshotPath = $this->writeSnapshot(
            $this->captureSnapshot($connection, $sourceUserId, $targetUserId, $preview, $performedBy),
            $sourceUserId,
            $targetUserId,
        );

        try {
            return $connection->transaction(function () use ($connection, $sourceUserId, $targetUserId, $performedBy, $conflictKeys, $preview, $snapshotPath): array {
                $tablesTouched = [];
                $rowsMerged = 0;
                $failedUpdates = [];

                $sourceRow = $connection->table('system_users')->where('id', $sourceUserId)->first();
                $sourceLabel = trim(($sourceRow->first_name ?? '') . ' ' . ($sourceRow->surname ?? ''));
                $sourceUsername = $sourceRow->username ?? '';

                $columnsFilled = $this->fillTargetGaps($connection, $sourceUserId, $targetUserId);

                foreach (UserDataAuditService::tables() as $table => $columns) {
                    foreach ($columns as $column) {
                        if (isset($conflictKeys[$this->indexKey($table, $column)])) {
                            continue;
                        }

                        try {
                            $affected = $connection
                                ->table($table)
                                ->where($column, $sourceUserId)
                                ->update([$column => $targetUserId]);
                        } catch (Throwable $exception) {
                            $failedUpdates[] = [
                                'table' => $table,
                                'column' => $column,
                                'error' => $exception->getMessage(),
                            ];
                            Log::warning('user_merge.update_failed', [
                                'source_user_id' => $sourceUserId,
                                'target_user_id' => $targetUserId,
                                'table' => $table,
                                'column' => $column,
                                'error' => $exception->getMessage(),
                            ]);

                            continue;
                        }

                        if ($affected > 0) {
                            $tablesTouched[$table] = ($tablesTouched[$table] ?? 0) + $affected;
                            $rowsMerged += $affected;
                        }
                    }
                }

                foreach (UserDataAuditService::polymorphicTables() as $table => $pairs) {
                    foreach ($pairs as $pair) {
                        try {
                            $affected = $connection
                                ->table($table)
                                ->whereIn($pair['type'], UserDataAuditService::USER_MORPH_TYPES)
                                ->where($pair['id'], $sourceUserId)
                                ->update([$pair['id'] => $targetUserId]);
                        } catch (Throwable $exception) {
                            $failedUpdates[] = [
                                'table' => $table,
                                'column' => $pair['id'],
                                'error' => $exception->getMessage(),
                            ];
                            Log::warning('user_merge.update_failed', [
                                'source_user_id' => $sourceUserId,
                                'target_user_id' => $targetUserId,
                                'table' => $table,
                                'column' => $pair['id'],
                                'error' => $exception->getMessage(),
                            ]);

                            continue;
                        }

                        if ($affected > 0) {
                            $tablesTouched[$table] = ($tablesTouched[$table] ?? 0) + $affected;
                            $rowsMerged += $affected;
                        }
                    }
                }

                $demotedRoleIds = $this->enforceSinglePrimaryRole($connection, $targetUserId);

                $this->appendMergeNoteToTarget($connection, $targetUserId, $sourceUserId, $sourceLabel, $sourceUsername, $performedBy);

                $this->writeMergeAudit(
                    connection: $connection,
                    targetUserId: $targetUserId,
                    sourceUserId: $sourceUserId,
                    sourceLabel: $sourceLabel,
                    sourceUsername: $sourceUsername,
                    performedBy: $performedBy,
                    rowsMerged: $rowsMerged,
                    tablesTouched: $tablesTouched,
                    columnsFilled: $columnsFilled,
                    snapshotPath: $snapshotPath,
                );

                $connection
                    ->table('system_users')
                    ->where('id', $sourceUserId)
                    ->delete();

                Log::info('user_merge.completed', [
                    'source_user_id' => $sourceUserId,
                    'target_user_id' => $targetUserId,
                    'performed_by' => $performedBy,
                    'rows_merged' => $rowsMerged,
                    'tables_touched' => count($tablesTouched),
                    'rows_skipped' => $preview['totals']['rows_to_skip'],
                    'columns_filled' => array_keys($columnsFilled),
                    'failed_updates' => count($failedUpdates),
                    'demoted_role_ids' => $demotedRoleIds,
                    'snapshot_path' => $snapshotPath,
                ]);

                return [
                    'rows_merged' => $rowsMerged,
                    'rows_skipped' => $preview['totals']['rows_to_skip'],
                    'tables_touched' => $tablesTouched,
                    'conflicts' => $preview['conflicts'],
                    'columns_filled' => $columnsFilled,
                    'failed_updates' => $failedUpdates,
                    'demoted_role_ids' => $demotedRoleIds,
                    'snapshot_path' => $snapshotPath,
                ];
            });
        } catch (Throwable $exception) {
            Log::error('user_merge.failed', [
                'source_user_id' => $sourceUserId,
                'target_user_id' => $targetUserId,
                'performed_by' => $performedBy,
                'snapshot_path' => $snapshotPath,
                'message' => $exception->getMessage(),
            ]);

            throw new RuntimeException(
                "Merge failed and was rolled back: {$exception->getMessage()} (snapshot: {$snapshotPath})",
                previous: $exception,
            );
        }
    }

    /**
     * Capture a structured snapshot of every row that references the source user,
     * plus both users' row data and the preview output. Used as a recovery aid.
     *
     * @return array<string, mixed>
     */
    /**
     * Compute which columns on system_users would be filled from source to target.
     * A column is fillable when:
     *   - it isn't on the never-fill skip list,
     *   - the source has a non-null, non-empty value,
     *   - the target's value is null or empty string.
     *
     * @return array<string, mixed>
     */
    private function computeSystemUserGaps(ConnectionInterface $connection, int $sourceUserId, int $targetUserId): array
    {
        $source = $connection->table('system_users')->where('id', $sourceUserId)->first();
        $target = $connection->table('system_users')->where('id', $targetUserId)->first();

        if ($source === null || $target === null) {
            return [];
        }

        $sourceArray = (array) $source;
        $targetArray = (array) $target;
        $skip = array_flip(self::SYSTEM_USERS_FILL_SKIP_COLUMNS);
        $fills = [];

        foreach ($sourceArray as $column => $sourceValue) {
            if (isset($skip[$column])) {
                continue;
            }
            if ($sourceValue === null || $sourceValue === '') {
                continue;
            }
            $targetValue = $targetArray[$column] ?? null;
            if ($targetValue !== null && $targetValue !== '') {
                continue;
            }
            $fills[$column] = $sourceValue;
        }

        return $fills;
    }

    /**
     * Compute which source columns will NOT make it onto the target.
     * Two reasons:
     *   - target already has a non-empty value (target's value wins),
     *   - the column is on the never-fill skip list (identity/security/lifecycle).
     *
     * Internal audit fields (id, created/modified timestamps and their *by ids)
     * are excluded from this report — they're not meaningful "data loss" to flag.
     *
     * @return list<array{column: string, source_value: mixed, target_value: mixed, reason: string}>
     */
    private function computeUnmergedSystemUserFields(ConnectionInterface $connection, int $sourceUserId, int $targetUserId): array
    {
        $source = $connection->table('system_users')->where('id', $sourceUserId)->first();
        $target = $connection->table('system_users')->where('id', $targetUserId)->first();

        if ($source === null || $target === null) {
            return [];
        }

        $sourceArray = (array) $source;
        $targetArray = (array) $target;
        $skip = array_flip(self::SYSTEM_USERS_FILL_SKIP_COLUMNS);
        $internalNoise = array_flip(['id', 'created', 'createdby', 'modified', 'modifiedby', 'passwordNew', 'uniquePIN']);
        $redactedColumns = array_flip(['100CharID', 'remember_token']);
        $unmerged = [];

        foreach ($sourceArray as $column => $sourceValue) {
            if ($sourceValue === null || $sourceValue === '') {
                continue;
            }
            if (isset($internalNoise[$column])) {
                continue;
            }

            $targetValue = $targetArray[$column] ?? null;

            if ($targetValue !== null && trim((string) $sourceValue) === trim((string) $targetValue)) {
                continue;
            }

            $isRedacted = isset($redactedColumns[$column]);
            $sourceDisplay = $isRedacted ? '«redacted»' : $sourceValue;
            $targetDisplay = $isRedacted ? '«redacted»' : $targetValue;

            if (isset($skip[$column])) {
                $unmerged[] = [
                    'column' => $column,
                    'source_value' => $sourceDisplay,
                    'target_value' => $targetDisplay,
                    'reason' => 'never copied (identity / security / lifecycle field)',
                ];
            } elseif ($targetValue !== null && $targetValue !== '') {
                $unmerged[] = [
                    'column' => $column,
                    'source_value' => $sourceDisplay,
                    'target_value' => $targetDisplay,
                    'reason' => "target's value kept",
                ];
            }
        }

        return $unmerged;
    }

    /**
     * Append a note line to the target user's `generalNotes` field describing the merge.
     */
    private function appendMergeNoteToTarget(
        ConnectionInterface $connection,
        int $targetUserId,
        int $sourceUserId,
        string $sourceLabel,
        string $sourceUsername,
        ?int $performedBy,
    ): void {
        $line = sprintf(
            'Merged in user #%d (%s, %s) on %s by admin #%s',
            $sourceUserId,
            $sourceLabel !== '' ? $sourceLabel : 'unknown name',
            $sourceUsername !== '' ? $sourceUsername : 'no username',
            now()->format('Y-m-d H:i:s'),
            $performedBy !== null ? (string) $performedBy : 'unknown',
        );

        $existing = $connection->table('system_users')->where('id', $targetUserId)->value('generalNotes') ?? '';
        $combined = trim($existing) === '' ? $line : trim($existing) . "\n" . $line;

        $connection->table('system_users')->where('id', $targetUserId)->update([
            'generalNotes' => $combined,
        ]);
    }

    /**
     * Write a single audit row recording the merge against the target user.
     *
     * @param  array<string, int>  $tablesTouched
     * @param  array<string, mixed>  $columnsFilled
     */
    private function writeMergeAudit(
        ConnectionInterface $connection,
        int $targetUserId,
        int $sourceUserId,
        string $sourceLabel,
        string $sourceUsername,
        ?int $performedBy,
        int $rowsMerged,
        array $tablesTouched,
        array $columnsFilled,
        string $snapshotPath,
    ): void {
        $request = function_exists('request') ? request() : null;
        $now = now();

        $connection->table('ssalute_audits')->insert([
            'user_type' => SystemUser::class,
            'user_id' => $performedBy,
            'event' => 'merged',
            'auditable_type' => SystemUser::class,
            'auditable_id' => $targetUserId,
            'old_values' => json_encode([], JSON_THROW_ON_ERROR),
            'new_values' => json_encode([
                'merged_from_user_id' => $sourceUserId,
                'merged_from_name' => $sourceLabel,
                'merged_from_username' => $sourceUsername,
                'rows_merged' => $rowsMerged,
                'tables_touched' => array_keys($tablesTouched),
                'columns_filled' => array_keys($columnsFilled),
                'snapshot_path' => $snapshotPath,
            ], JSON_INVALID_UTF8_SUBSTITUTE),
            'url' => $request?->fullUrl() ?? 'cli',
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
            'tags' => null,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    /**
     * After the merge, the target user can end up with multiple role rows where
     * `defaultRole = 1`. This keeps the most recently created primary
     * (highest `created`, then highest id as tiebreaker) and demotes the rest
     * by setting their `defaultRole` to 0.
     *
     * @return list<int> The role-row ids that were demoted.
     */
    private function enforceSinglePrimaryRole(ConnectionInterface $connection, int $targetUserId): array
    {
        $primaryRoleIds = $connection
            ->table('system_users_other_roles')
            ->where('userID', $targetUserId)
            ->where('defaultRole', 1)
            ->orderByDesc('created')
            ->orderByDesc('id')
            ->pluck('id')
            ->map(fn ($id): int => (int) $id)
            ->all();

        if (count($primaryRoleIds) <= 1) {
            return [];
        }

        $toDemote = array_slice($primaryRoleIds, 1);

        $connection
            ->table('system_users_other_roles')
            ->whereIn('id', $toDemote)
            ->update(['defaultRole' => 0]);

        return $toDemote;
    }

    /**
     * Apply the gap-fill update to the target user's row. Returns the columns written.
     *
     * @return array<string, mixed>
     */
    private function fillTargetGaps(ConnectionInterface $connection, int $sourceUserId, int $targetUserId): array
    {
        $fills = $this->computeSystemUserGaps($connection, $sourceUserId, $targetUserId);

        if ($fills === []) {
            return [];
        }

        $connection->table('system_users')->where('id', $targetUserId)->update($fills);

        return $fills;
    }

    private function captureSnapshot(ConnectionInterface $connection, int $sourceUserId, int $targetUserId, array $preview, ?int $performedBy): array
    {
        $snapshot = [
            'taken_at' => now()->toIso8601String(),
            'source_user_id' => $sourceUserId,
            'target_user_id' => $targetUserId,
            'performed_by' => $performedBy,
            'preview' => $preview,
            'source_user' => $this->fetchRow($connection, 'system_users', ['id' => $sourceUserId]),
            'target_user' => $this->fetchRow($connection, 'system_users', ['id' => $targetUserId]),
            'data' => [],
        ];

        foreach (UserDataAuditService::tables() as $table => $columns) {
            $rows = $this->fetchSourceRows($connection, $table, $columns, $sourceUserId);
            if ($rows !== []) {
                $snapshot['data'][$table] = $rows;
            }
        }

        foreach (UserDataAuditService::polymorphicTables() as $table => $pairs) {
            $rows = $this->fetchPolymorphicSourceRows($connection, $table, $pairs, $sourceUserId);
            if ($rows !== []) {
                $snapshot['data'][$table] = $rows;
            }
        }

        return $snapshot;
    }

    /**
     * @param  array<string, mixed>  $where
     * @return ?array<string, mixed>
     */
    private function fetchRow(ConnectionInterface $connection, string $table, array $where): ?array
    {
        try {
            $row = $connection->table($table)->where($where)->first();

            return $row ? (array) $row : null;
        } catch (Throwable) {
            return null;
        }
    }

    /**
     * @param  list<string>  $columns
     * @return list<array<string, mixed>>
     */
    private function fetchSourceRows(ConnectionInterface $connection, string $table, array $columns, int $sourceUserId): array
    {
        $whereParts = [];
        $bindings = [];
        foreach ($columns as $column) {
            $whereParts[] = "`{$column}` = ?";
            $bindings[] = $sourceUserId;
        }

        try {
            return $connection->table($table)
                ->whereRaw(implode(' OR ', $whereParts), $bindings)
                ->get()
                ->map(fn ($row) => (array) $row)
                ->all();
        } catch (Throwable) {
            return [];
        }
    }

    /**
     * @param  list<array{type: string, id: string}>  $pairs
     * @return list<array<string, mixed>>
     */
    private function fetchPolymorphicSourceRows(ConnectionInterface $connection, string $table, array $pairs, int $sourceUserId): array
    {
        $typePlaceholders = implode(',', array_fill(0, count(UserDataAuditService::USER_MORPH_TYPES), '?'));
        $whereParts = [];
        $bindings = [];
        foreach ($pairs as $pair) {
            $whereParts[] = "(`{$pair['type']}` IN ({$typePlaceholders}) AND `{$pair['id']}` = ?)";
            foreach (UserDataAuditService::USER_MORPH_TYPES as $morphType) {
                $bindings[] = $morphType;
            }
            $bindings[] = $sourceUserId;
        }

        try {
            return $connection->table($table)
                ->whereRaw(implode(' OR ', $whereParts), $bindings)
                ->get()
                ->map(fn ($row) => (array) $row)
                ->all();
        } catch (Throwable) {
            return [];
        }
    }

    /**
     * Write the snapshot to local storage. Throws if the file cannot be written.
     *
     * @param  array<string, mixed>  $snapshot
     */
    private function writeSnapshot(array $snapshot, int $sourceUserId, int $targetUserId): string
    {
        $timestamp = now()->format('Ymd-His');
        $path = "user-merges/{$sourceUserId}-into-{$targetUserId}-{$timestamp}.json";

        $payload = json_encode(
            $snapshot,
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE,
        );
        if ($payload === false) {
            throw new RuntimeException('Could not encode merge snapshot to JSON: ' . json_last_error_msg());
        }

        if (! Storage::disk('local')->put($path, $payload)) {
            throw new RuntimeException("Could not write merge snapshot to {$path}.");
        }

        return $path;
    }

    private function connection(): ConnectionInterface
    {
        return DB::connection(AppServiceProvider::DB_SD_CORE);
    }

    private function guardDifferentUsers(int $sourceUserId, int $targetUserId): void
    {
        if ($sourceUserId === $targetUserId) {
            throw new InvalidArgumentException('Source and target users must be different.');
        }
    }

    private function indexKey(string $table, string $column): string
    {
        return strtolower($table . '.' . $column);
    }

    /**
     * @return array<string, true>
     */
    private function loadUniqueColumns(ConnectionInterface $connection): array
    {
        if ($this->uniqueColumnIndex !== null) {
            return $this->uniqueColumnIndex;
        }

        $tableNames = array_merge(
            array_keys(UserDataAuditService::tables()),
            array_keys(UserDataAuditService::polymorphicTables()),
        );

        $rows = $connection->select(
            'SELECT TABLE_NAME, INDEX_NAME, COLUMN_NAME
             FROM INFORMATION_SCHEMA.STATISTICS
             WHERE TABLE_SCHEMA = DATABASE()
               AND NON_UNIQUE = 0
               AND TABLE_NAME IN (' . implode(',', array_fill(0, count($tableNames), '?')) . ')',
            $tableNames,
        );

        $byIndex = [];
        foreach ($rows as $row) {
            $key = $row->TABLE_NAME . '|' . $row->INDEX_NAME;
            $byIndex[$key][] = ['table' => $row->TABLE_NAME, 'column' => $row->COLUMN_NAME];
        }

        $singleColumnUniques = [];
        foreach ($byIndex as $columns) {
            if (count($columns) !== 1) {
                continue;
            }
            $entry = $columns[0];
            $singleColumnUniques[$this->indexKey($entry['table'], $entry['column'])] = true;
        }

        return $this->uniqueColumnIndex = $singleColumnUniques;
    }

    private function countWhere(ConnectionInterface $connection, string $table, string $column, int $userId): int
    {
        return $connection->table($table)->where($column, $userId)->count();
    }

    /**
     * @param  list<string>  $columns
     */
    private function countMatchingRows(ConnectionInterface $connection, string $table, array $columns, int $userId): int
    {
        $whereParts = [];
        $bindings = [];
        foreach ($columns as $column) {
            $whereParts[] = "`{$column}` = ?";
            $bindings[] = $userId;
        }

        return $connection
            ->table($table)
            ->whereRaw(implode(' OR ', $whereParts), $bindings)
            ->count();
    }

    private function countPolymorphicRows(ConnectionInterface $connection, string $table, string $typeColumn, string $idColumn, int $userId): int
    {
        return $connection
            ->table($table)
            ->whereIn($typeColumn, UserDataAuditService::USER_MORPH_TYPES)
            ->where($idColumn, $userId)
            ->count();
    }
}
