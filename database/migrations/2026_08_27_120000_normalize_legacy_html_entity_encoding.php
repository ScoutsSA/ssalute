<?php

use App\Services\LegacyHtmlService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * The legacy editors re-encoded HTML entities on every save, leaving FAQ
 * answers, articles and roadmap items stored as double and triple encoded
 * entity soup. This decodes each value to the HTML the legacy display
 * pipeline effectively renders, but ONLY where LegacyHtmlService::normalize()
 * proves the legacy pages render the decoded value identically, so nothing
 * members see changes. Rows that fail that check (links and other
 * non-whitelisted tags, tag-like plain text, backslash content) stay encoded
 * until the legacy whitelist is widened; re-running this migration's logic
 * later, or a data fixer, can pick those up (see ticket 006). Idempotent:
 * normalising an already normalised value is a no-op.
 */
return new class extends Migration
{
    private const array TABLES = [
        'system_faq' => ['a'],
        'sd_articles' => ['intro', 'article'],
        'system_roadmap_little' => ['text'],
    ];

    public function up(): void
    {
        foreach (self::TABLES as $table => $columns) {
            DB::table($table)->select(array_merge(['id'], $columns))->orderBy('id')->chunkById(100, function ($rows) use ($table, $columns): void {
                foreach ($rows as $row) {
                    $updates = [];

                    foreach ($columns as $column) {
                        $normalized = LegacyHtmlService::normalize($row->{$column});

                        if ($normalized === null || $normalized === $row->{$column}) {
                            continue;
                        }

                        $updates[$column] = $normalized;
                    }

                    if ($updates !== []) {
                        DB::table($table)->where('id', $row->id)->update($updates);
                    }
                }
            });
        }
    }

    public function down(): void
    {
        /**
         * Data normalisation; the encoded originals are not restorable.
         */
    }
};
