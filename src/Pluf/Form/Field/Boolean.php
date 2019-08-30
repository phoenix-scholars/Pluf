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

/**
 * Boolean field
 *
 * Manage and deserial boolean fields from input form
 *
 * @author maso
 *
 */
class Pluf_Form_Field_Boolean extends Pluf_Form_Field
{
    public $widget = 'Pluf_Form_Widget_CheckboxInput';

    public function clean($value)
    {
        //parent::clean($value);
        if(is_bool($value)){
            return $value;
        }
        if (in_array($value, array('on', 'y', '1', 1, 'true'))) {
            return true;
        }
        return false;
    }
}
