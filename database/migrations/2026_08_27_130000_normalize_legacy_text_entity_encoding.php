<?php

use App\Services\LegacyHtmlService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Companion to 2026_08_27_120000_normalize_legacy_html_entity_encoding for
 * the plain text columns the legacy editors also entity encoded: FAQ
 * questions, article titles and roadmap areas (for example &#039; instead
 * of an apostrophe). Same rules: LegacyHtmlService::normalize() decodes to
 * what the legacy display pipeline renders and skips anything the legacy
 * pages would render differently once decoded. Idempotent: normalising an
 * already normalised value is a no-op.
 */
return new class extends Migration
{
    private const array TABLES = [
        'system_faq' => ['q'],
        'sd_articles' => ['title'],
        'system_roadmap_little' => ['area'],
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
