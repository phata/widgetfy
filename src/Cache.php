<?php

namespace Widgetarian\Widgetfy;

// use FileCache as default
use Widgetarian\Widgetfy\Cache\FileCache as DefaultCache;

class Cache {

    public static $handler = FALSE;

    public static function init() {
        if (self::$handler == FALSE) {
            self::$handler = new DefaultCache;
        }
    }

    /**
     * @param object $handler cache hander that implements Widgetarian\Widgetify\Cache\Common
     */
    public static function setHandler($handler) {
        if (!is_subclass_of(self::$handler, 'Widgetarian\Widgetify\Cache\Common')) {
            throw new Exception('Cache handler must implement the Widgetarian\Widgetify\Cache\Common interface');
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
        return call_user_func(array(self::$handler, 'exists'), $group, $key);
    }

    /**
     * @param string $group cache group name
     * @param string $key cache key
     * @param mixed $value cache value
     * @return boolean the cache set successfully
     */
    public static function set($group, $key, $value) {
        return call_user_func(array(self::$handler, 'exists'), $group, $key);
    }

}