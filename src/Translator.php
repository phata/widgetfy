<?php

/**
 * class Widgetarian\Widgetfy\Translator
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
 * This file defines Widgetarian\Widgetfy\Translator
 * which is the main interface to translate url into
 * widget embed code.
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Widgetarian/Widgetfy
 */

namespace Widgetarian\Widgetfy;

class Translator {

    public static $sites = array(
        '/^[\w]+\.youtube\.com$/' => 'Youtube',
        '/^www\.ted\.com$/' => 'TED',
        '/^myspace\.com$/' => 'MySpace',
        '/^[\w]+\.liveleak\.com$/' => 'LiveLeak',
        '/^www\.dailymotion\.com$/' => 'Dailymotion',
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