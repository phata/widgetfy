<?php

namespace Widgetarian\Widgetfy\Site;

interface Common {

    /**
     * determine if the URL is translatable
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @return boolean whether the url is translatable
     */
    public static function translatable($url_parsed);

    /**
     * translate the provided URL into
     * HTML embed code of it
     * @param string[] $url_parsed result of parse_url($url)
     * @return mixed either embed string or NULL if not applicable
     */
    public static function translate($url_parsed);

}
