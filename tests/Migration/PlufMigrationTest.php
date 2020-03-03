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
namespace Pluf\PlufTest\Migration;

use PHPUnit\Framework\TestCase;
use Pluf\Bootstrap;
use Pluf\Migration;

class PlufMigrationTest extends TestCase
{

    /**
     *
     * @before
     */
    protected function setUpTest()
    {
        $conf = include __DIR__ . '/../conf/config.php';
        Bootstrap::start($conf);
    }

    public function testMigrate()
    {
        $m = new Migration();
        $m->dry_run = false;
        $m->migrate();
        $m->migrate(0);
    }

    public function testMigrateDown()
    {
        $m = new Migration();
        $m->dry_run = true;
        $m->migrate(0);
    }

    public function testMigrateUp()
    {
        $m = new Migration();
        $m->dry_run = true;
        $m->migrate(5);
    }
}
