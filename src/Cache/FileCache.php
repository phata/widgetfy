<?php

/**
 * class Phata\Widgetfy\Cache\FileCache
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
 * This file defines Phata\Widgetfy\Cache\FileCache
 * which is the default implementation of
 * Phata\Widgetfy\Cache\Common
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy\Cache;

class FileCache implements Common {

    public $base_dir = '/tmp';

    private function filename($group, $key) {
        return 'widgetfy__'.str_replace('/', '', $group.'_'.md5($key));
    }

    private function fullpath($filename) {
        return $this->base_dir.'/'.$filename;
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