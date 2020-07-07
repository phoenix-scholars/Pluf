<?php
/*
 * This file is part of bootstrap Framework, a simple PHP Application Framework.
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
namespace Pluf\Test\Template\Tenant;

use PHPUnit\Framework\TestCase;
use Pluf\Template;
use Pluf\Pluf\Tenant;
use Pluf;

/**
 *
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class PlufTenantTemplateTest extends TestCase
{

    /**
     *
     * @before
     * @return void
     */
    protected function setUpTest()
    {
        Pluf::start(array(
            'test' => false,
            'timezone' => 'Europe/Berlin',
            'debug' => true,
            'installed_apps' => array(
                'Pluf'
            ),
            'tmp_folder' => '/tmp',
            'templates_folder' => array(
                dirname(__FILE__) . '/../templates'
            ),

            'template_tags' => array(
                'tenant' => '\\Pluf\\Template\\Tag\\TenantTag'
            ),
            'pluf_use_rowpermission' => true,
            'mimetype' => 'text/html',
            'db_login' => 'testpluf',
            'db_password' => 'testpluf',
            'db_server' => 'localhost',
            'db_database' => '/tmp/tmp.sqlite.db',
            'app_base' => '/testapp',
            'url_format' => 'simple',
            'db_table_prefix' => 'pluf_unit_tests_' . rand() . '_',
            'db_version' => '5.0',
            'db_engine' => 'SQLite',
            'bank_debug' => true
        ));
    }

    public function testId()
    {
        $folders = array(
            dirname(__FILE__)
        );
        $tmpl = new Template('tpl-id.html', $folders);
        $this->assertEquals("1", $tmpl->render());
    }

    public function testTitle()
    {
        $tenant = Tenant::current();
        $folders = array(
            dirname(__FILE__)
        );
        $tmpl = new Template('tpl-title.html', $folders);
        $this->assertEquals($tenant->title, $tmpl->render());
    }

    public function testDomain()
    {
        $tenant = Tenant::current();
        $folders = array(
            dirname(__FILE__)
        );
        $tmpl = new Template('tpl-domain.html', $folders);
        $this->assertEquals($tenant->domain, $tmpl->render());
    }
}
