<?php

namespace Widgetarian\Widgetfy\Cache;

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