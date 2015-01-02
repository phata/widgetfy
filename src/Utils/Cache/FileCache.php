<?php

/**
 * class Phata\Widgetfy\Utils\Cache\FileCache
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
 * This file defines Phata\Widgetfy\Utils\Cache\FileCache
 * which is the default implementation of
 * Phata\Widgetfy\Utils\Cache\Common
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy\Utils\Cache;

class FileCache implements Common {

    public $base_dir = '';

    public function __construct($base_dir=FALSE) {
        if (($base_dir == FALSE)) {
            $base_dir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'widgetfy';
        }
        if (!is_dir($base_dir)) {
            // create the directory recursively
            if (!mkdir($base_dir, 0777, TRUE)) {
                throw new Exception('Failed to locate or create base directory for FileCache');
            }
        }
        $this->base_dir = $base_dir;
    }

    public function filename($group, $key) {
        return str_replace(array('/', '\\'), '_', $group.'_'.md5($key));
    }

    public function fullpath($filename) {
        return $this->base_dir.DIRECTORY_SEPARATOR.$filename;
    }

    public function exists($group, $key) {
        $cache_filename = $this->filename($group, $key);
        return file_exists($this->fullpath($cache_filename));
    }

    public function get($group, $key) {
        if ($this->exists($group, $key)) {
            $cache_filename = $this->filename($group, $key);
            return unserialize(file_get_contents($this->fullpath($cache_filename)));
        }
        return NULL;
    }

    public function set($group, $key, $value) {
        $result = FALSE;
        $cache_filename = $this->filename($group, $key);
        $fh = fopen($this->fullpath($cache_filename), 'w+');
        if ($fh !== FALSE) $result = fwrite($fh, serialize($value));
        fclose($fh);
        chmod($this->fullpath($cache_filename), 0600);
        return $result;
    }

}