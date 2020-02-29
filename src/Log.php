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

/**
 * سیستم لوگ با کارایی بالا
 *
 * تولید لوگ در سیستم در حالی که کارایی سیستم پایین نیاد کار خیلی سختی
 * هست.
 * این کار زمانی که بخوای محل تولید لوگ رو تعیین کنی خیلی سخت‌تر هم می‌شه
 * مثلا خط و فایلی که این لوگ رو تولید کرده.
 * استاندارد php یه سری کد برای assert معرفی کرده که خیلی این کار رو با
 * کارایی خوب انجام می ده.
 *
 * نکته: اینجوری نیست که لوگ فقط یک رشته باشه بلکه بعضی مواقع نیاز هست
 * که یک موجودیت رو توی لوگ بیاریم. اینکه این لوگ دقیقا چطور توی خروجی
 * نوشته می شه به نویسنده لوگ بستگی داره. برای نمونه ممکن هست این لوگ‌ها به
 * صورت json نوشته بشن.
 *
 * The removal of constraints on the log message simplify the log
 * system as you can push into it categories or extra informations.
 *
 * In the log stack, each log message is microtimed together with the
 * log level as integer. You can convert the integer to string at
 * write time.
 */
class Log
{

    /**
     * The log stack.
     *
     * A logger function is just pushing the data in the log stack,
     * the writers are then called to write the data later.
     */
    public static $stack = array();

    /**
     * A simple storage to track stats.
     *
     * A good example is to store stats and at the end of the request,
     * push the info back in the log. You can for example store the
     * total time doing SQL or other things like that.
     */
    public static $store = array();

    /**
     * Different log levels.
     */
    const ALL = 1;

    const DEBUG = 3;

    const INFO = 4;

    const PERF = 5;

    const EVENT = 6;

    const WARN = 7;

    const ERROR = 8;

    const FATAL = 9;

    const OFF = 10;

    /**
     * Used to reverse the log level to the string.
     */
    public static $reverse = array(
        1 => 'ALL',
        3 => 'DEBUG',
        4 => 'INFO',
        5 => 'PERF',
        6 => 'EVENT',
        7 => 'WARN',
        8 => 'ERROR',
        9 => 'FATAL'
    );

    /**
     * Current log level.
     *
     * By default, logging is not enabled.
     */
    public static $level = null;

    /**
     * Current message in the assert log.
     */
    public static $assert_mess = null;

    /**
     * Current level of the message in the assert log.
     */
    public static $assert_level = 10;

    /**
     * اطلاعات را به پشته لوگ اضافه می کند
     *
     * در صورتی که نیاز باشد تمام اطلاعات جمع شده را در خروجی می‌نویسد.
     *
     * @param string $level
     *            سطی
     *            که می‌خواهیم لوگ در آن قرار گیرد
     * @param string $message
     *            پیام
     *            لوگ
     */
    private static function _log($level, $message)
    {
        if (! isset(self::$level)) {
            self::$level = Bootstrap::f('log_level', 10);
        }
        if (self::$level <= $level and self::$level != 10) {
            self::$stack[] = array(
                microtime(true),
                $level,
                $message
            );
            if (! Bootstrap::f('log_delayed', false)) {
                self::flush();
            }
        }
    }

    /**
     * Base assert logger.
     *
     * The assert logging is a two step process as one need to go
     * through the assertion callback.
     *
     * @param string $level
     *            Level
     *            to log
     * @param string $message
     *            Message
     *            to log
     * @return bool false
     */
    private static function _alog($level, $message)
    {
        self::$assert_level = $level;
        self::$assert_mess = $message;
        return false; // This will trigger the assert handler.
    }

    /**
     * Log at the ALL level.
     *
     * @param string $message
     *            Message
     *            to log
     */
    public static function log($message)
    {
        return self::_log(self::ALL, $message);
    }

    /**
     * Log at the DEBUG level.
     *
     * @param string $message
     *            Message
     *            to log
     */
    public static function debug($message)
    {
        self::_log(self::DEBUG, $message);
    }

    public static function info($message)
    {
        self::_log(self::INFO, $message);
    }

    public static function perf($message)
    {
        self::_log(self::PERF, $message);
    }

    public static function event($message)
    {
        self::_log(self::EVENT, $message);
    }

    public static function warn($message)
    {
        self::_log(self::WARN, $message);
    }

    public static function error($message)
    {
        self::_log(self::ERROR, $message);
    }

    public static function fatal($message)
    {
        self::_log(self::FATAL, $message);
    }

    /**
     * Assert log at the ALL level.
     *
     * @param string $message
     *            Message
     *            to log
     */
    public static function alog($message)
    {
        return self::_alog(self::ALL, $message);
    }

    /**
     * Assert log at the DEBUG level.
     *
     * @param string $message
     *            Message
     *            to log
     */
    public static function adebug($message)
    {
        self::_alog(self::DEBUG, $message);
    }

    public static function ainfo($message)
    {
        self::_alog(self::INFO, $message);
    }

    public static function aperf($message)
    {
        self::_alog(self::PERF, $message);
    }

    public static function aevent($message)
    {
        self::_alog(self::EVENT, $message);
    }

    public static function awarn($message)
    {
        self::_alog(self::WARN, $message);
    }

    public static function aerror($message)
    {
        self::_alog(self::ERROR, $message);
    }

    public static function afatal($message)
    {
        self::_alog(self::FATAL, $message);
    }

    /**
     * Flush the data to the writer.
     *
     * This reset the stack.
     */
    public static function flush()
    {
        if (count(self::$stack) == 0) {
            return;
        }
        $writer = Bootstrap::f('log_handler', 'Pluf_Log_File');
        call_user_func(array(
            $writer,
            'write'
        ), self::$stack);
        self::$stack = array();
    }

    /**
     * Signal handler to flush the log.
     *
     * The name of the signal and the parameters are not used.
     *
     * @param string $signal
     *            Name
     *            of the signal
     * @param
     *            &$params Parameters
     */
    public static function flushHandler($signal, &$params)
    {
        self::flush();
    }

    /**
     * Activation of the low impact logging.
     *
     * When called, it enabled the assertions for debugging.
     */
    public static function activeAssert()
    {
        assert_options(ASSERT_ACTIVE, 1);
        assert_options(ASSERT_WARNING, 0);
        assert_options(ASSERT_QUIET_EVAL, 1);
        assert_options(ASSERT_CALLBACK, '\Pluf\Log\assert');
    }

    /**
     * Increment a key in the store.
     *
     * It automatically creates the key as needed.
     *
     * @param string $key
     *            Key
     *            to increment
     * @param string $amount
     *            Amount
     *            to increase (1)
     */
    public static function inc($key, $amount = 1)
    {
        if (! isset(self::$store[$key])) {
            self::$store[$key] = 0;
        }
        self::$store[$key] += $amount;
    }

    /**
     * Set a key in the store.
     *
     * @param string $key
     *            Key
     *            to set
     * @param string $value
     *            Value
     *            to set
     */
    public static function set($key, $value)
    {
        self::$store[$key] = $value;
    }

    /**
     * Get a key from the store.
     *
     * @param string $key
     *            Key to set
     * @param string $value
     *            Default value (null)
     */
    public static function get($key, $value = null)
    {
        return (isset(self::$store[$key])) ? self::$store[$key] : $value;
    }

    /**
     * Start the time to track.
     *
     * @param string $key
     *            Tracker
     */
    public static function stime($key)
    {
        self::$store['time_tracker_' . $key] = microtime(true);
    }

    /**
     * End the time to track.
     *
     * @param string $key
     *            Tracker
     * @param string $total
     *            Tracker
     *            to store the total (null)
     * @return float Time for this track
     */
    public static function etime($key, $total = null)
    {
        $t = microtime(true) - self::$store['time_tracker_' . $key];
        if ($total) {
            self::inc('time_tracker_' . $total, $t);
        }
        return $t;
    }
}