<?php

/**
 * class Phata\Widgetfy\Site\Tudou
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

class Tudou implements Common {

    /**
     * Implements Phata\Widgetfy\Site\Common::translate
     *
     * determine if the URL is translatable
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @param string $url full url
     * @return boolean whether the url is translatable
     */
    public static function translatable($url_parsed, $url) {
        if (preg_match('/^\/programs\/view\/(.+?)\/$/',
                $url_parsed['path'], $matches) == 1) {
            return array(
                'tudou_type' => 0,
                'lcode' => '',
                'code' => $matches[1],
            );
        }
        if (preg_match('/^\/albumplay\/(\w+)\/(\w+)\.html$/',
                $url_parsed['path'], $matches) == 1) {
            return array(
                'tudou_type' => 2,
                'lcode' => $matches[1],
                'code'  => $matches[2],
            );
        }
        return FALSE;
    }

    /**
     * Implements Phata\Widgetfy\Site\Common::translate
     *
     * translate the provided URL into
     * HTML embed code of it
     * @param string[] $url_parsed result of parse_url($url)
     * @param mixed[] $extra array of extra url information
     * @return mixed either embed string or NULL if not applicable
     */
    public static function translate($url_parsed, $extra) {
        $width = 480; $height = 400;

        // parse the CSS output
        $width_css = is_numeric($width) ? $width.'px' : $width;
        $height_css = is_numeric($height) ? $height.'px' : $height;

        // build http query
        $http_query = http_build_query(array(
            'type' => $extra['tudou_type'],
            'code' => $extra['code'],
            'lcode' => $extra['lcode'],
            'resourceId' => '0_06_05_99',
        ));

        return array(
            'html' => '<iframe src="http://www.tudou.com/programs/view/html5embed.action?'.
                $http_query.'" '.
                'allowtransparency="true" allowfullscreen="true" '.
                'scrolling="no" border="0" frameborder="0" '.
                'style="width:'.$width_css.';height:'.$height_css.';"></iframe>',
            'width' => $width,
            'height' => $height,
        );
    }
}