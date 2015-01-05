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

    public static $registry = array(
        '/^(\w+\.|)youtube\.com$/'     => 'Phata\Widgetfy\Site\Youtube',
        '/^www\.ted\.com$/'            => 'Phata\Widgetfy\Site\TED',
        '/^myspace\.com$/'             => 'Phata\Widgetfy\Site\MySpace',
        '/^[\w]+\.liveleak\.com$/'     => 'Phata\Widgetfy\Site\LiveLeak',
        '/^www\.dailymotion\.com$/'    => 'Phata\Widgetfy\Site\Dailymotion',
        '/^www\.metacafe\.com$/'       => 'Phata\Widgetfy\Site\Metacafe',
        '/^vimeo\.com$/'               => 'Phata\Widgetfy\Site\Vimeo',
        '/^(\w+\.|)nicovideo\.jp$/'    => 'Phata\Widgetfy\Site\NicoNico',
        '/^www\.kickstarter\.com$/'    => 'Phata\Widgetfy\Site\Kickstarter',
        '/^\w+\.collegehumor\.com$/'   => 'Phata\Widgetfy\Site\CollegeHumor',
        '/^vlog\.xuite\.net$/'         => 'Phata\Widgetfy\Site\Xuite',
        '/^www\.dorkly\.com$/'         => 'Phata\Widgetfy\Site\Dorkly',
        '/^www\.facebook\.com$/'       => 'Phata\Widgetfy\Site\Facebook',
        '/^www\.56\.com$/'             => 'Phata\Widgetfy\Site\V56',
        '/^store\.steampowered\.com$/' => 'Phata\Widgetfy\Site\SteamStore',
        '/^\w+\.ku6\.com$/'            => 'Phata\Widgetfy\Site\Ku6',
        '/^\w+\.youku\.com$/'          => 'Phata\Widgetfy\Site\Youku',
        '/^(\w+\.|)tudou\.com$/'       => 'Phata\Widgetfy\Site\Tudou',
        '/^tv\.on\.cc/'                => 'Phata\Widgetfy\Site\OnCc',
        '/^www\.ign\.com$/'            => 'Phata\Widgetfy\Site\IGN',
    );

    public static function translate($url, $options=array()) {
        $url_parsed = parse_url($url);

        // add empty site configurations
        $options += array(
            'overrides' => array(),
        );

        foreach (self::$registry as $regex => $class) {
            // if host matches
            if (preg_match($regex, $url_parsed['host'])) {

                // local options
                $local_options = isset($options['overrides'][$class]) ?
                    $options['overrides'][$class] + (array) $options : (array) $options;

                // callbacks
                $cb_preprocess = array($class, 'preprocess');
                $cb_translate  = array($class, 'translate');

                // preprocess
                $info = call_user_func($cb_preprocess, $url_parsed);

                // if translatable
                if ($info !== FALSE) {
                    return call_user_func($cb_translate, $info, $local_options);
                }
            }
        }
    }

}
