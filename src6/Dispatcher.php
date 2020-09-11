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
use Pluf\HTTP\URL;
use Pluf;
use Pluf_Graphql;
use Pluf_Paginator;
use Pluf_Signal;

/**
 * Dispather of pluf
 *
 * در این کلاس تقاضای کاربر پردازش شده و بر اساس تنظیم‌ها به یکی از فراخوانی‌های
 * لایه
 * نمایش نگاشت داده می‌شود.
 *
 * @author maso
 *        
 */
class Dispatcher
{

    /**
     * نتیجه فراخوانی کاربر را تعیین می‌کند.
     *
     * با ورود یک درخواست این فراخوانی تعیین می‌کند که کدام لایه نمایش باید
     * فراخوانی
     * شود.
     *
     * @param
     *            string Query string ('')
     */
    public static function dispatch($query = '', $controllers = NULL)
    {
        $response = null;
        try {
            /*
             * # Create q request
             *
             * TODO: maso, 2020: remove from dispatcher
             * - It limits tests
             * - It bind the dispatcher to a specific environment
             */
            $query = preg_replace('#^(/)+#', '/', '/' . $query);
            $req = new Pluf\HTTP\Request($query);
            Pluf\HTTP\Request::setCurrent($req);

            /*
             * # Load and run middlewares
             *
             * Load all middlewares based on configuration and then run them on
             * request. and response
             */
            $middleware = array();
            foreach (Pluf::f('middleware_classes', array()) as $mw) {
                $middleware[] = new $mw();
            }

            /*
             * # Main dispatching process
             *
             * 1- Process request with middlewares
             * 2- Find and run a view
             * 3- Process (request,response) with middlewares
             */
            // 1- middleware process request
            $skip = false;
            foreach ($middleware as $mw) {
                if (method_exists($mw, 'process_request')) {
                    $response = $mw->process_request($req);
                    if ($response !== false) {
                        self::handleResponse($req, $response);
                        $skip = true;
                        break;
                    }
                }
            }

            // 2- Call view
            if ($skip === false) {
                if (isset($controllers)) {
                    self::loadControllers($controllers);
                }
                $response = self::match($req);
                $response = self::toResponse($response, $req);
                if (! empty($req->response_vary_on)) {
                    $response->headers['Vary'] = $req->response_vary_on;
                }
                // 3- call middleware to
                $middleware = array_reverse($middleware);
                foreach ($middleware as $mw) {
                    if (method_exists($mw, 'process_response')) {
                        $response = $mw->process_response($req, $response);
                    }
                }
                self::handleResponse($req, $response);
            }
        } catch (Exception $e) {
            if (defined('IN_UNIT_TESTS')) {
                throw $e;
            }
            $response = new Response\ServerError($e);
            self::handleResponse($req, $response);
            self::logError($req, $e);
        }
        /**
         * [signal]
         *
         * Pluf_Dispatcher::postDispatch
         *
         * [sender]
         *
         * Pluf_Dispatcher
         *
         * [description]
         *
         * This signal is sent after the rendering of a request. This
         * means you cannot affect the response but you can use this
         * hook to do some cleaning.
         *
         * [parameters]
         *
         * array('request' => $request,
         * 'response' => $response)
         */
        $params = array(
            'request' => $req,
            'response' => $response
        );
        Pluf_Signal::send('Pluf_Dispatcher::postDispatch', 'Pluf_Dispatcher', $params);
        return array(
            $req,
            $response
        );
    }

    /**
     * تقاضا را با لایه نمایش انطباق می‌دهد
     *
     * زمانی که تمام میان افزارها روی تقاضا اجرا شد در این فراخوانی رابطه میان
     * تقاضا و لایه نمایش تعیین شده و لایه نمایش مناسب اجرا می‌شود. نتیجه این
     * فراخوانی داده‌ای است که باید برای کاربران ارسال شود.
     *
     *
     * @param
     *            Request Request object
     * @return Response Response object
     */
    public static function match($req, $firstpass = true)
    {
        // Search for appropriate controller
        $views = $GLOBALS['_PX_views'];
        $to_match = $req->query;
        $n = count($views);
        $i = 0;
        // بررسی کنترلرها و پیدا کردن کنترلر مناسب بر اساس انتطباق با مسیر
        while ($i < $n) {
            $ctl = $views[$i];
            // maso, 1394: بررسی متد لایه کنترل
            if (isset($ctl['http-method'])) {
                // hadi, 1397: Check if http method is supported
                $methods = $ctl['http-method'];
                if ((! is_array($methods) && $ctl['http-method'] !== $req->method) || (is_array($methods) && ! in_array($req->method, $methods))) {
                    $i ++;
                    continue;
                }
            }
            $match = [];
            if (preg_match($ctl['regex'], $to_match, $match)) {
                if (! isset($ctl['sub'])) {
                    return self::send($req, $ctl, $match);
                }
                // Go in the subtree
                $views = $ctl['sub'];
                $i = 0;
                $n = count($views);
                $to_match = substr($to_match, strlen($match[0]));
                continue;
            }
            $i ++;
        }

        // XXX: maso, 1395: این قسمت از کد رو نمی‌دونم چی کار داره می‌کنه
        if ($firstpass and substr($req->query, - 1) != '/') {
            $req->query .= '/';
            $res = self::match($req, false);
            if ($res->status_code != 404) {
                $name = (isset($req->view[0]['name'])) ? $req->view[0]['name'] : $req->view[0]['model'] . '::' . $req->view[0]['method'];
                $url = URL::urlForView($name, array_slice($req->view[1], 1));
                return new Response\Redirect($url, 301);
            }
        }
        // نمایش مناسبی یافت نشده است
        throw new Pluf\HTTP\Error404($req->query);
    }

    /**
     * Call Ctrl
     *
     * فراخوانی لایه نمایش ممکن است که با بروز استثنا روبرو شود که در اینجا این
     * نکته
     * مورد توجه قرار گرفته است. از این رو نیازی نیست که در لایه نمایش مدیریت
     * خطا انجام
     * شود.
     *
     * @param
     *            Request Current request
     * @param
     *            array The url definition matching the request
     * @param
     *            array The match found by preg_match
     * @return Response Response object
     */
    public static function send($req, $ctl, $match)
    {
        $req->view = array(
            $ctl,
            $match,
            'ctrl' => $ctl,
            'match' => $match
        );
        /*
         * Here we have preconditions to respects. If the "answer"
         * is true, then ok go ahead, if not then it a response so
         * return it or an exception so let it go.
         */
        if (isset($ctl['precond']) && ! Pluf::f('dispatcher.precond.disable', false)) {
            $preconds = $ctl['precond'];
            if (! is_array($preconds)) {
                $preconds = array(
                    $preconds
                );
            }
            foreach ($preconds as $precond) {
                if (! is_array($precond)) {
                    $res = call_user_func_array(explode('::', $precond), array(
                        &$req
                    ));
                } else {
                    $res = call_user_func_array(explode('::', $precond[0]), array_merge(array(
                        &$req
                    ), array_slice($precond, 1)));
                }
                if ($res !== true) {
                    return $res;
                }
            }
        }
        // Call controller method (PHP 4, 5, 7)
        $model = new $ctl['model']();
        $method = $ctl['method'];
        $params = array();
        if (isset($ctl['params'])) {
            $params = $ctl['params'];
        }
        return $model->$method($req, $match, $params);
    }

    /**
     * Loads Ctrl layer
     *
     * @param
     *            string File including the views.
     * @return bool Success.
     */
    public static function loadControllers($file)
    {
        if (is_array($file)) {
            $GLOBALS['_PX_views'] = $file;
            return true;
        }
        if (file_exists($file)) {
            $GLOBALS['_PX_views'] = include $file;
            return true;
        }
        return false;
    }

    public static function toResponse($response, $request)
    {
        // Check old result
        if ($response instanceof Response) {
            return $response;
        }
        // apply graphql
        if (array_key_exists('graphql', $request->REQUEST)) {
            $gl = new Pluf_Graphql();
            $response = $gl->render($response, $request->REQUEST['graphql']);
        }

        // convert to response
        $http = new \Pluf\HTTP2();
        $contentType = array(
            'application/json',
            'text/plain'
        );
        $mime = $http->negotiateMimeType($contentType, $contentType[0]);
        if ($mime === false) {
            throw new \Pluf\Exception("You don't want any of the content types I have to offer\n");
        }
        if ($response instanceof Pluf_Paginator) {
            $response = $response->render_object();
        }
        switch ($mime) {
            case 'application/json':
                $response = new Response\Json($response);
                break;
            case 'text/plain':
                $response = new Response\PlainText($response);
                break;
        }
        return $response;
    }

    /**
     *
     * @param Request $req
     * @param Response $response
     */
    private static function handleResponse($req, $response)
    {
        // $response is a response
        if (Pluf::f('pluf_runtime_header', false)) {
            $response->headers['X-Perf-Runtime'] = sprintf('%.5f', (microtime(true) - $GLOBALS['_PX_starttime']));
        }
        $response->render($req->method != 'HEAD' and ! defined('IN_UNIT_TESTS'));
    }

    /**
     *
     * @param Request $req
     * @param Exception $exception
     */
    private static function logError(Request $req, $exception)
    {
        // return if is not internal error
        // XXX: maso, 2020: handle view error
        // if ($exception instanceof \Pluf\Exception) {
        // // if ($exception->getStatus() !== 500) {
        // // return;
        // // }
        // }
        try {
            // 1- Add to log
            Logger::fatal('Fail to handle the request', array(
                'query' => $req->query,
                'error' => $exception
            ));
        } catch (Exception $ex) {}
    }
}
