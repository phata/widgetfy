<?php

/**
 * class Phata\Widgetfy\Site
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
 * This file defines Phata\Widgetfy\Site
 * which is the main interface to translate url into
 * widget embed code.
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy;

class Site {

    public static $sites = array(
        '/^(\w+\.|)youtube\.com$/' => 'Youtube',
        '/^www\.ted\.com$/' => 'TED',
        '/^myspace\.com$/' => 'MySpace',
        '/^[\w]+\.liveleak\.com$/' => 'LiveLeak',
        '/^www\.dailymotion\.com$/' => 'Dailymotion',
        '/^www\.metacafe\.com$/' => 'Metacafe',
        '/^vimeo\.com$/' => 'Vimeo',
        '/^(\w+\.|)nicovideo\.jp$/' => 'NicoNico',
        '/^www\.kickstarter\.com$/' => 'Kickstarter',
        '/^\w+\.collegehumor\.com$/' => 'CollegeHumor',
        '/^vlog\.xuite\.net$/' => 'Xuite',
        '/^www\.dorkly\.com$/' => 'Dorkly',
        '/^www\.facebook\.com$/' => 'Facebook',
        '/^www\.56\.com$/' => 'V56',
        '/^store\.steampowered\.com$/' => 'SteamStore',
        '/^\w+\.ku6\.com$/' => 'Ku6',
        '/^\w+\.youku\.com$/' => 'Youku',
        '/^(\w+\.|)tudou\.com$/' => 'Tudou',
        '/^tv\.on\.cc/' => 'OnCc',
        '/^www\.ign\.com$/' => 'IGN',
    );

    public static function translate($url, $options=array()) {
        $url_parsed = parse_url($url);
        foreach (self::$sites as $regex => $class) {
            // if host matches
            if (preg_match($regex, $url_parsed['host'])) {

                // callbacks
                $cb_preprocess = array(
                    'Phata\Widgetfy\Site\\'.$class, 'preprocess');
                $cb_translate  = array(
                    'Phata\Widgetfy\Site\\'.$class, 'translate');

                // preprocess
                $info = call_user_func(
                        $cb_preprocess, $url_parsed);

                // if translatable
                if ($info !== FALSE) {
                    return call_user_func($cb_translate, $info, $options);
                }
            }
        }
    }

}
