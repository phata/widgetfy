<?php

/**
 * interface Phata\Widgetfy\Utils\Cache\Common
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
 * This file defines Phata\Widgetfy\Utils\Cache\Common
 * which is the common cache definition.
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy\Utils\Cache;

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