<?php

namespace Widgetarian\Widgetfy\Cache;

/**
 * Common cache interface to be used
 */
interface Common {

    /**
     * @param string $group cache group name
     * @param string $key cache key
     * @return boolean the cache exists for the cache key
     */
    public function exists($group, $key);

    /**
     * @param string $group cache group name
     * @param string $key cache key
     * @return the cached item
     */
    public function get($group, $key);

    /**
     * @param string $group cache group name
     * @param string $key cache key
     * @param mixed $value cache value
     * @return boolean the cache set successfully
     */
    public function set($group, $key, $value);

}