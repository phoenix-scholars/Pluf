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
namespace Pluf\Test\Cache;

use PHPUnit\Framework\TestCase;
use Pluf\Cache;
use Pluf\Options;
use stdClass;

class FileTest extends TestCase
{

    private $_config;

    private $_arrayData = array(
        'hello' => 'world',
        'foo' => false,
        0 => array(
            'foo',
            'bar'
        )
    );

    /**
     *
     * @before
     */
    public function setUpTest()
    {
        if (! array_key_exists('_PX_config', $GLOBALS)) {
            $GLOBALS['_PX_config'] = array();
        }
        $this->_config = $GLOBALS['_PX_config']; // backup
        $GLOBALS['_PX_config']['cache_engine'] = 'Pluf_Cache_File';
        $GLOBALS['_PX_config']['cache_timeout'] = 5;
        $GLOBALS['_PX_config']['cache_file_folder'] = '/tmp/pluf_unittest_cache';
    }

    /**
     *
     * @after
     */
    public function tearDownTest()
    {
        $GLOBALS['_PX_config'] = $this->_config;
    }

    /**
     *
     * @test
     */
    public function testConstructor()
    {
        $options = new Options([
            'engine' => 'file'
        ]);
        $cache = Cache::getInstance($options);
        $this->assertNotNull($cache);
    }

    /**
     *
     * @test
     */
    public function testBasic()
    {
        $options = new Options([
            'engine' => 'file'
        ]);
        $cache = Cache::getInstance($options);
        $this->assertNotNull($cache);

        $var = 'foo1';
        $key = 'test1';

        $cache->set($key, $var);
        $this->assertEquals($var, $cache->get($key));
    }

    /**
     *
     * @test
     */
    public function testGetUnknownKey()
    {
        $options = new Options([
            'engine' => 'file'
        ]);
        $cache = Cache::getInstance($options);
        $this->assertNotNull($cache);

        $this->assertNull($cache->get('unknown'));
    }

    /**
     *
     * @test
     */
    public function testGetDefault()
    {
        $options = new Options([
            'engine' => 'file'
        ]);
        $cache = Cache::getInstance($options);
        $this->assertNotNull($cache);

        $this->assertEquals('default', $cache->get('unknown', 'default'));
    }

    /**
     *
     * @test
     */
    public function testSerialized()
    {
        $options = new Options([
            'engine' => 'file'
        ]);
        $cache = Cache::getInstance($options);
        $this->assertNotNull($cache);

        $success = $cache->set('array', $this->_arrayData);
        $this->assertTrue($success);
        $this->assertEquals($this->_arrayData, $cache->get('array'));

        $obj = new stdClass();
        $obj->foo = 'bar';
        $obj->hello = 'world';
        $success = $cache->set('object', $obj);
        $this->assertTrue($success);
        $this->assertEquals($obj, $cache->get('object'));

        unset($obj);
        $this->assertInstanceOf(stdClass::class, $cache->get('object'));
        $this->assertEquals('world', $cache->get('object')->hello);
    }
}
