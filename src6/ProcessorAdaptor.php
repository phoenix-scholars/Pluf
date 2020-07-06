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
namespace Pluf;

use Pluf\HTTP\Request;
use Pluf\HTTP\Response;

/**
 * Pluf general Processor
 *
 * @author maso <mostafa.barmshory@dpq.co.ir>
 *        
 */
class ProcessorAdaptor implements Processor
{

    /**
     * Process the request
     *
     * @param Request $request
     * @return boolean false if ther is no problem otherwize ther is an error
     */
    public function request(Request &$request)
    {}

    /**
     * Process the response
     *
     * @param Request $request
     * @param Response $response
     */
    public function response(Request $request, Response $response): Response
    {
        return $response;
    }
}
