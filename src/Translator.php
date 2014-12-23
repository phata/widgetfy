<?php

namespace Widgetarian\Widgetfy;

class Translator {

    public static $sites = array(
        '/^[\w]+\.youtube\.com$/' => 'Youtube',
    );

    public static function translate($url) {
        $url_parsed = parse_url($url);
        foreach (self::$sites as $regex => $class) {
            // if host matches
            if (preg_match($regex, $url_parsed['host'])) {
                if (call_user_func(array('Widgetarian\Widgetfy\Site\\'.$class, 'translatable'), $url_parsed)) {
                    return call_user_func(array('Widgetarian\Widgetfy\Site\\'.$class, 'translate'), $url_parsed);
                }
            }
        }
    }

}