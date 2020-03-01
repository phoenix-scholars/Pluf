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
namespace Pluf\Test;


class ModelRecurse extends \Pluf\Model
{

    function init()
    {
        $this->_a['table'] = 'testmodelrecurse';
        $this->_a['cols'] = array(
            'id' => array(
                'type' => '\Pluf\DB\Field\Sequence',
                'blank' => true
            ), // It is automatically added.
            'title' => array(
                'type' => '\Pluf\DB\Field\Varchar',
                'blank' => false,
                'size' => 100
            ),
            // name in db
            'parent_id' => array(
                'type' => '\Pluf\DB\Field\Foreignkey',
                'blank' => true,
                'model' => '\Pluf\Test\ModelRecurse',
                // name in parent
                'relate_name' => 'children',
                // name in this class
                'name' => 'parent',
                // name in graphql
                'graphql_name' => 'parent'
            )
        );
        $this->_a['idx'] = array();
        $this->_a['views'] = array();
    }
}
