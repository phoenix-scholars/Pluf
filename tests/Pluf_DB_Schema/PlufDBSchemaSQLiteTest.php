<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. (http://dpq.co.ir)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */
use PHPUnit\Framework\TestCase;
use Pluf\Db\SQLiteSchema;
require_once 'Pluf.php';

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/../apps');

/**
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class PlufDBSchemaSQLiteTest extends TestCase
{

    /**
     *
     * @beforeClass
     */
    public static function initTest()
    {
        Pluf::start(dirname(__FILE__) . '/../conf/config.php');
        if (Pluf::db()->engine != 'SQLite') {
            self::markTestSkipped('Only to be run with the SQLite DB engine');
        }
    }

    /**
     *
     * @test
     */
    public function testGenerateSchema3()
    {
        $model = new Test_Model();
        $schema = new SQLiteSchema(Pluf::db());

        $sql = $schema->createTableQueries($model);

        // CREATE TABLE pluf_unit_tests_testmodel (
        // id integer primary key autoincrement,
        // title varchar(100) default '',
        // description text not null default ''
        // );

        $tablename = $schema->getTableName($model);
        $this->assertEquals(true, strpos($sql[$tablename], 'CREATE TABLE') !== false);
        $this->assertEquals(true, strpos($sql[$tablename], 'integer') !== false);
        $this->assertEquals(true, strpos($sql[$tablename], 'varchar(100)') !== false);
        $this->assertEquals(true, strpos($sql[$tablename], 'text') !== false);
        $this->assertEquals(true, strpos($sql[$tablename], 'test_model') !== false);
    }

    /**
     *
     * @test
     */
    public function testDeleteSchemaTestModel()
    {
        $model = new Test_Model();
        $schema = new SQLiteSchema(Pluf::db());

        $del = $schema->dropTableQueries($model);

        $tablename = $schema->getTableName($model);
        $this->assertEquals('DROP TABLE IF EXISTS ' . $tablename, $del[0]);
    }

    /**
     *
     * @test
     */
    public function testGenerateSchema()
    {
        $model = new Test_Model();

        $engine = Pluf::db();

        // create new schema
        $schema = new SQLiteSchema($engine, $engine->getOptions()->startsWith('schema_', true));

        Pluf_Migration::dropTables($engine, $schema, $model);
        Pluf_Migration::createTables($engine, $schema, $model);

        // $this->assertEquals(true, $schema->dropTables());
        // $sql = $gen->getSqlCreate($model);
        // foreach ($sql as $query) {
        // Pluf::db()->execute($query);
        // }
        // $sql = $gen->getSqlIndexes($model);
        // foreach ($sql as $query) {
        // Pluf::db()->execute($query);
        // }

        $model->title = 'my title';
        $model->description = 'A small desc.';
        $this->assertEquals(true, $model->create());
        $this->assertEquals(1, (int) $model->id);

        Pluf_Migration::dropTables($engine, $schema, $model);
    }

    /**
     *
     * @test
     */
    public function testGenerateSchema2()
    {
        $model = new Test_Model();
        $engine = Pluf::db();
        $schema = new SQLiteSchema($engine, $engine->getOptions()->startsWith('schema_', true));

        Pluf_Migration::dropTables($engine, $schema, $model);
        Pluf_Migration::createTables($engine, $schema, $model);

        $model->title = 'my title';
        $model->description = 'A small desc.';
        $this->assertEquals(true, $model->create());
        $this->assertEquals(1, (int) $model->id);

        Pluf_Migration::dropTables($engine, $schema, $model);
    }
}
