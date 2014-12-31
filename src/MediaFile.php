<?php

/**
 * class Phata\Widgetfy\MediaFile
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
 * This file defines Phata\Widgetfy\MediaFile
 * which is an interface to translate url, base on
 * its file extension, into widget HTML code.
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy;

class MediaFile {

    public static $filetypes = array(
        '/\.(ogg|mp4|webm)$/i' => 'HTML5Video',
        '/\.(wmv|avi|asx|mpg|mpeg)$/i' => 'ClassicVideo',
        '/\.(rm|rmvb)$/i' => 'RealMediaVideo',
    );

    public static function translate($url) {
        $url_parsed = parse_url($url);
        foreach (self::$filetypes as $regex => $class) {
            // if host matches
            if (preg_match($regex, $url_parsed['path'])) {
                if (($info = call_user_func(
                        array('Phata\Widgetfy\MediaFile\\'.$class, 'preprocess'),
                        $url_parsed
                        )) !== FALSE) {
                    // if preprocess
                    return call_user_func(
                        array('Phata\Widgetfy\MediaFile\\'.$class, 'translate'),
                        $info
                    );
                }
            }
        }
    }

}