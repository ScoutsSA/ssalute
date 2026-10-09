<?php

namespace Tests\Unit\Services;

use App\Models\District;
use App\Models\Group;
use App\Models\Region;
use App\Services\Areas\AreaReferenceMap;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * Proves AreaReferenceMap matches database/schema/sd-core-schema.sql, so the delete guard and the
 * linked record tabs cannot silently drift from the legacy schema.
 */
class AreaReferenceMapTest extends TestCase
{
    /** @var array<string, list<string>> */
    private static array $schema = [];

    protected function setUp(): void
    {
        parent::setUp();

        if (self::$schema !== []) {
            return;
        }

        $dump = file_get_contents(database_path('schema/sd-core-schema.sql'));

        preg_match_all('/CREATE TABLE `(\w+)` \((.*?)\n\)/s', $dump, $tables, PREG_SET_ORDER);

        foreach ($tables as [, $table, $body]) {
            preg_match_all('/^  `(\w+)` /m', $body, $columns);
            self::$schema[$table] = $columns[1];
        }

        $this->assertNotEmpty(self::$schema, 'Schema dump could not be parsed.');
    }

    /**
     * @return array<string, array{class-string<Model>}>
     */
    public static function levels(): array
    {
        return [
            'region' => [Region::class],
            'district' => [District::class],
            'group' => [Group::class],
        ];
    }

    #[Test]
    #[DataProvider('levels')]
    public function canonical_map_matches_the_schema_dump(string $modelClass): void
    {
        $expected = [];

        foreach (self::$schema as $table => $columns) {
            $hits = array_values(array_intersect($columns, AreaReferenceMap::columnNamesFor($modelClass)));

            if ($hits !== []) {
                $expected[$table] = $hits;
            }
        }

        ksort($expected);

        $this->assertSame($expected, AreaReferenceMap::canonicalFor($modelClass));
    }

    #[Test]
    #[DataProvider('levels')]
    public function extra_references_exist_in_the_schema_and_are_not_canonical(string $modelClass): void
    {
        $canonical = AreaReferenceMap::canonicalFor($modelClass);

        foreach (AreaReferenceMap::extraFor($modelClass) as $table => $columns) {
            $this->assertArrayHasKey($table, self::$schema, "{$table} is not in the schema dump.");

            foreach ($columns as $column) {
                $this->assertContains($column, self::$schema[$table], "{$table}.{$column} is not in the schema dump.");
                $this->assertNotContains($column, $canonical[$table] ?? [], "{$table}.{$column} is already canonical.");
            }
        }
    }

    #[Test]
    #[DataProvider('levels')]
    public function every_referencing_table_has_a_model_or_is_listed_as_modelless(string $modelClass): void
    {
        foreach (array_keys(AreaReferenceMap::for($modelClass)) as $table) {
            if (in_array($table, AreaReferenceMap::TABLES_WITHOUT_MODELS, true)) {
                $this->assertNull(AreaReferenceMap::modelFor($table), "{$table} is listed as modelless but has a model.");

                continue;
            }

            $this->assertNotNull(AreaReferenceMap::modelFor($table), "{$table} has no model entry.");
        }
    }

    #[Test]
    public function every_model_entry_resolves_to_a_model_on_that_table(): void
    {
        foreach (AreaReferenceMap::MODELS as $table => $modelClass) {
            $this->assertTrue(class_exists($modelClass), "{$modelClass} does not exist.");

            $model = new $modelClass;

            $this->assertInstanceOf(Model::class, $model);
            $this->assertSame($table, $model->getTable(), "{$modelClass} is not on {$table}.");
        }
    }

    #[Test]
    public function merged_map_combines_canonical_and_extra_columns_per_table(): void
    {
        $map = AreaReferenceMap::for(Group::class);

        $this->assertSame(['groupID', 'actionGroupID'], $map['system_users_other_roles']);
        $this->assertSame(['assoc_to_group', 'roverGroupID'], $map['system_users']);
        $this->assertSame(['fromGroup', 'toGroup'], $map['ams_adult_leader_moves']);
        $this->assertSame(['assocToRegion'], AreaReferenceMap::for(Region::class)['ams_adult_leader_moves']);
    }

    #[Test]
    public function labels_fall_back_to_a_headline_of_the_table_name(): void
    {
        $this->assertSame('Role attachments', AreaReferenceMap::label('system_users_other_roles'));
        $this->assertSame('Advancement Cubs', AreaReferenceMap::label('advancement_cubs'));
    }

    #[Test]
    #[DataProvider('levels')]
    public function non_blocking_tables_reference_the_area_but_are_left_out_of_the_blocking_map(string $modelClass): void
    {
        $all = AreaReferenceMap::for($modelClass);
        $blocking = AreaReferenceMap::blockingFor($modelClass);

        foreach (AreaReferenceMap::NON_BLOCKING_TABLES as $table) {
            $this->assertArrayHasKey($table, $all, "{$table} no longer references the area; drop it from NON_BLOCKING_TABLES.");
            $this->assertArrayNotHasKey($table, $blocking);
            $this->assertFalse(AreaReferenceMap::isBlocking($table));
        }

        $this->assertSame(count($all) - count(AreaReferenceMap::NON_BLOCKING_TABLES), count($blocking));
        $this->assertTrue(AreaReferenceMap::isBlocking('districts'));
    }
}
