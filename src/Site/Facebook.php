<?php

/**
 * class Phata\Widgetfy\Site\Facebook
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
 * This file defines Phata\Widgetfy\Site\Youtube
 * which is a site definition that implements
 * Phata\Widgetfy\Site\Common
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy\Site;

class Facebook implements Common {

    /**
     * Implements Phata\Widgetfy\Site\Common::translate
     *
     * determine if the URL is translatable
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @return boolean whether the url is translatable
     */
    public static function translatable($url_parsed) {

        // replace current path with fragment
        // that starts with '!' mark
        if (isset($url_parsed['fragment']) &&
                (substr($url_parsed['fragment'], 0, 1) == '!')) {
            $path = substr($url_parsed['fragment'], 1);
            $url = 'http://www.facebook.com'.$path;
            $url_parsed = parse_url($url);
        }

        // test if the path is translatable
        if (in_array($url_parsed['path'],
                array('/video/video.php', '/video.php', '/photo.php'))) {
            // find parameter 'v' if exists
            parse_str($url_parsed['query'], $args);
            if (isset($args['v'])) {
                return array(
                    'vid' => $args['v'],
                );
            }
        }

        return FALSE;
    }

    /**
     * Implements Phata\Widgetfy\Site\Common::translate
     *
     * translate the provided URL into
     * HTML embed code of it
     * @param mixed[] $extra array of extra url information
     * @return mixed either embed string or NULL if not applicable
     */
    public static function translate($extra) {
        $width = 600; $height = FALSE;
        return array(
            'html' => '<div id="fb-root"></div> <script>(function(d, s, id) { '.
                'var js, fjs = d.getElementsByTagName(s)[0]; '.
                'if (d.getElementById(id)) return; js = d.createElement(s); '.
                'js.id = id; js.src = "//connect.facebook.net/zh_HK/all.js#xfbml=1"; '.
                'fjs.parentNode.insertBefore(js, fjs); }'.
                '(document, \'script\', \'facebook-jssdk\'));</script>'.
                '<div class="fb-post" '.
                'data-href="https://www.facebook.com/video.php?v='.$extra['vid'].'" '.
                'data-width="'.$width.'"></div>',
            'width' => $width,
            'height' => $height,
        );
    }
}