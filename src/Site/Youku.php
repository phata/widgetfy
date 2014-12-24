<?php

/**
 * class Widgetarian\Widgetfy\Site\Youku
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
 * This file defines Widgetarian\Widgetfy\Site\Youtube
 * which is a site definition that implements
 * Widgetarian\Widgetfy\Site\Common
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Widgetarian/Widgetfy
 */

namespace Widgetarian\Widgetfy\Site;

class Youku implements Common {

    /**
     * Implements Widgetarian\Widgetfy\Site\Common::translate
     *
     * determine if the URL is translatable
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @return boolean whether the url is translatable
     */
    public static function translatable($url_parsed) {

        // different path for different domain
        if (strtolower($url_parsed['host'])=='player.youku.com') {
            $regex = '/^\/player\.php\/sid\/([a-zA-Z0-9]+)(\=\/v\.swf|\/v\.swf)$/';
        } elseif (strtolower($url_parsed['host'])=='v.youku.com') {
            $regex = '/^\/v_show\/id_(.+?)(\=|)\.html/';
        }

        // match sid from path
        if (preg_match($regex, $url_parsed['path'], $matches) == 1) {
            return array(
                'sid' => $matches[1],
            );
        }

        return FALSE;
    }

    /**
     * Implements Widgetarian\Widgetfy\Site\Common::translate
     *
     * translate the provided URL into
     * HTML embed code of it
     * @param string[] $url_parsed result of parse_url($url)
     * @param mixed[] $extra array of extra url information
     * @return mixed either embed string or NULL if not applicable
     */
    public static function translate($url_parsed, $extra) {
        $width = 510; $height = 498;
        return array(
            'html' => '<iframe width="'.$width.'" height="'.$height.'" '.
                'src="http://player.youku.com/embed/'.$extra['sid'].'=" '.
                'frameborder="0" allowfullscreen></iframe>',
            'width' => $width,
            'height' => $height,
        );
    }
}