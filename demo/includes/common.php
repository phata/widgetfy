<?php

// turn on error reporting for debug
error_reporting(E_ALL);
ini_set('display_error', 1);

// use autoloader
require_once dirname(dirname(__DIR__)) . '/autoload.php';

// load demo site information
function getDemoURLs() {
    $json_raw = file_get_contents(dirname(__DIR__) . '/misc/demo.json');
    return json_decode($json_raw, TRUE);
}

// render css style for .videoblock
function style_block($embed) {
  $d = &$embed['dimension'];
  // if scale model is no-scale, allow to "force dynamic"
  // by setting "dynamic" to TRUE
  if (!$d->dynamic && ($d->scale_model == 'no-scale')) {
    return 'width: '.$d->width.'px';
  }
  return '';
}

// render css style for .videowrapper
function style_wrapper($embed) {
  $d = &$embed['dimension'];
  if ($d->dynamic && ($d->scale_model == 'scale-width-height')) {
    return 'padding-bottom: ' . ($d->factor * 100) . '%;';
  }
  return '';
}
