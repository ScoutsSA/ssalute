<?php

namespace App\Filament\Admin\Clusters\Area\RelationManagers\Linked;

use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Services\Areas\AreaReferenceMap;
use Illuminate\Support\Str;

/**
 * Registry of the generated linked record relation managers, one per referencing table and column.
 *
 * Class and relationship names are derived from AreaReferenceMap, so every table that can block a
 * delete gets a tab. Pairs that already have a bespoke relation manager are skipped here.
 */
final class LinkedRelationManagers
{
    /**
     * Table/column pairs served by a hand written relation manager on the resource.
     *
     * @var array<class-string, array<string, list<string>>>
     */
    public const BESPOKE = [
        Region::class => [
            'districts' => ['regionID'],
            'groups' => ['assoc_to_region'],
            'system_users_other_roles' => ['regionID'],
        ],
        District::class => [
            'groups' => ['assoc_to_district'],
            'system_users_other_roles' => ['districtID'],
        ],
        Group::class => [
            'group_committee' => ['assocToGroup'],
            'group_cub_packs' => ['assocToGroup'],
            'group_meerkat_dens' => ['assocToGroup'],
            'group_rover_crews' => ['assocToGroup'],
            'group_scout_troops' => ['assocToGroup'],
            'system_users_other_roles' => ['groupID'],
        ],
    ];

    /**
     * Generated relation manager classes for the given area model, sorted by table name.
     *
     * @return list<class-string<LinkedRecordsRelationManager>>
     */
    public static function for(string $modelClass): array
    {
        $classes = [];

        foreach (self::pairsFor($modelClass) as [$table, $column, $isExtra]) {
            $classes[] = self::className($table, $isExtra ? $column : null);
        }

        return $classes;
    }

    /**
     * Every table/column pair the given area model needs a generated manager for.
     *
     * @return list<array{string, string, bool}> [table, column, isExtra]
     */
    public static function pairsFor(string $modelClass): array
    {
        $pairs = [];

        foreach (AreaReferenceMap::canonicalFor($modelClass) as $table => $columns) {
            foreach ($columns as $column) {
                if (self::isBespoke($modelClass, $table, $column) || AreaReferenceMap::modelFor($table) === null) {
                    continue;
                }

                $pairs[] = [$table, $column, false];
            }
        }

        foreach (AreaReferenceMap::extraFor($modelClass) as $table => $columns) {
            foreach ($columns as $column) {
                if (self::isBespoke($modelClass, $table, $column) || AreaReferenceMap::modelFor($table) === null) {
                    continue;
                }

                $pairs[] = [$table, $column, true];
            }
        }

        usort($pairs, fn (array $a, array $b): int => [$a[0], $a[1]] <=> [$b[0], $b[1]]);

        return $pairs;
    }

    public static function isBespoke(string $modelClass, string $table, string $column): bool
    {
        return in_array($column, self::BESPOKE[$modelClass][$table] ?? [], true);
    }

    /**
     * @return class-string<LinkedRecordsRelationManager>
     */
    public static function className(string $table, ?string $column = null): string
    {
        return __NAMESPACE__ . '\\Linked' . Str::studly($table) . ($column ? Str::studly($column) : '') . 'RelationManager';
    }

    public static function relationshipName(string $table, ?string $column = null): string
    {
        return 'linked' . Str::studly($table) . ($column ? Str::studly($column) : '');
    }

    public static function title(string $table, ?string $column = null): string
    {
        $label = AreaReferenceMap::label($table);

        if ($column === null) {
            return $label;
        }

        $label = preg_replace('/\s*\(.*\)$/', '', $label);
        $suffix = strtolower(Str::headline(preg_replace('/ID$/', '', $column)));

        return "{$label} ({$suffix})";
    }
}
