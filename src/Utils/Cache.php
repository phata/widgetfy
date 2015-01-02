<?php

/**
 * class Phata\Widgetfy\Utils\Cache
 * 
 * Licence:
 *
 * This file is part of Widgetfy.
 *
 * Widgetfy is free software: you can redistribute
 * it and/or modify it under the terms of the GNU
 * Lesser General Public License as published by the
 * Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * Widgetfy is distributed in the hope that it will
 * be useful, but WITHOUT ANY WARRANTY; without even
 * the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU Lesser
 * General Public Licensefor more details.
 *
 * You should have received a copy of the GNU Lesser
 * General Public License along with Widgetfy.  If
 * not, see <http://www.gnu.org/licenses/lgpl.html>.
 *
 * Description:
 *
 * This file defines Phata\Widgetfy\Utils\Cache
 * which is a Proxy to Cache implementation
 *
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy\Utils;

// use FileCache as default
use Phata\Widgetfy\Utils\Cache\FileCache as DefaultCache;
use Exception as Exception;

class Cache {

    private static $handler = FALSE;

    /**
     * initialize the cache interface
     */
    public static function init() {
        if (self::$handler == FALSE) {
            self::setHandler(new DefaultCache);
        }
    }

    /**
     * @param object $handler cache hander that implements Phata\Widgetfy\Utils\Cache\Common
     */
    public static function setHandler($handler) {
        if (!is_subclass_of($handler, 'Phata\Widgetfy\Utils\Cache\Common')) {
            throw new Exception('Cache handler must implement the Phata\Widgetfy\Utils\Cache\Common interface');
        }
        self::$handler = $handler;
    }

    /**
     * @param string $group cache group name
     * @param string $key cache key
     * @return boolean the cache exists for the cache key
     */
    public static function exists($group, $key) {
        return call_user_func(array(self::$handler, 'exists'), $group, $key);
    }

    /**
     * @param string $group cache group name
     * @param string $key cache key
     * @return the cached item
     */
    public static function get($group, $key) {
        return call_user_func(array(self::$handler, 'get'), $group, $key);
    }

    /**
     * @param string $group cache group name
     * @param string $key cache key
     * @param mixed $value cache value
     * @return boolean the cache set successfully
     */
    public static function set($group, $key, $value) {
        return call_user_func(array(self::$handler, 'set'), $group, $key, array(
            'created' => time(),
            'value' => $value,
        ));
    }

}