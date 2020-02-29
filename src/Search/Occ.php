<?php
/*
 * This file is part of Pluf Framework, a simple PHP Application Framework.
 * Copyright (C) 2010-2020 Phoinex Scholars Co. http://dpq.co.ir
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
namespace Pluf\Search;

use Pluf\Model;

/**
 * Storage of the occurence of the words.
 */
class Occ extends Model
{

    function init()
    {
        $this->_a['verbose'] = 'occurence';
        $this->_a['table'] = 'pluf_search_occs';
        $this->_a['cols'] = array(
            // It is mandatory to have an "id" column.
            'id' => array(
                'type' => '\Pluf\DB\Field\Sequence',
                // It is automatically added.
                'blank' => true
            ),
            'word' => array(
                'type' => '\Pluf\DB\Field\Foreignkey',
                'model' => 'Pluf_Search_Word',
                'blank' => false,
                'verbose' => 'word'
            ),
            'model_class' => array(
                'type' => '\Pluf\DB\Field\Varchar',
                'blank' => false,
                'size' => 150,
                'verbose' => 'model class'
            ),
            'model_id' => array(
                'type' => '\Pluf\DB\Field\Integer',
                'blank' => false,
                'verbose' => 'model id'
            ),
            'occ' => array(
                'type' => '\Pluf\DB\Field\Integer',
                'blank' => false,
                'verbose' => 'occurences'
            ),
            'pondocc' => array(
                'type' => '\Pluf\DB\Field\FloatPoint',
                'blank' => false,
                'verbose' => 'weighted occurence'
            )
        );
        $this->_a['idx'] = array(
            'model_class_id_combo_word_idx' => array(
                'type' => 'unique',
                'col' => 'model_class, model_id, word'
            )
        );
    }

    function __toString()
    {
        return $this->word;
    }
}
