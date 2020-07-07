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
namespace Pluf\Test\Migration;

use PHPUnit\Framework\TestCase;
use Pluf\NoteBook\Book;
use Pluf;

/**
 * Single tenant test
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class InitTest extends TestCase
{

    /**
     *
     * @beforeClass
     */
    public static function createDataBase()
    {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';
        $_SERVER['REMOTE_ADDR'] = '/';

        $GLOBALS['_PX_uniqid'] = '1234';
    }

    /**
     *
     * @test
     */
    public function shouldInstallEmptyApp()
    {
        $conf = include __DIR__ . '/../conf/config.php';
        $conf['installed_apps'] = array(
            'Smallest'
        );
        $conf['db_table_prefix'] = 'pluf_unit_tests_' . rand() . '_';
        Pluf::start($conf);
        $m = new \Pluf\Migration(array(
            'NoteBook'
        ));
        $this->assertTrue($m->install());
        $this->assertTrue($m->uninstall());
    }

    /**
     *
     * @test
     */
    public function shouldInitEmptyFromConfig()
    {
        $conf = include __DIR__ . '/../conf/config.php';
        $conf['installed_apps'] = array(
            'Smallest'
        );
        $conf['db_table_prefix'] = 'pluf_unit_tests_' . rand() . '_';
        Pluf::start($conf);
        $m = new \Pluf\Migration(array(
            'Smallest'
        ));
        $this->assertTrue($m->install());

        $this->assertTrue($m->init());
        $this->assertTrue($m->uninstall());
    }

    /**
     *
     * @test
     */
    public function shouldInstallNoteApp()
    {
        $conf = include __DIR__ . '/../conf/config.php';
        $conf['installed_apps'] = array(
            'NoteBook'
        );
        $conf['db_table_prefix'] = 'pluf_unit_tests_' . rand() . '_';
        Pluf::start($conf);
        $m = new \Pluf\Migration(array(
            'NoteBook'
        ));
        $this->assertTrue($m->install());
        $this->assertTrue($m->uninstall());
    }

    /**
     *
     * @test
     */
    public function shouldInitNoteFromConfig()
    {
        $conf = include __DIR__ . '/../conf/config.php';
        $conf['installed_apps'] = array(
            'NoteBook'
        );
        Pluf::start($conf);
        $m = new \Pluf\Migration(array(
            'NoteBook'
        ));
        $this->assertTrue($m->install());

        $this->assertTrue($m->init());

        $note = new Book();
        $this->assertTrue(sizeof($note->getList()) > 0, 'Notes are not created');

        $this->assertTrue($m->unInstall());
    }
}


