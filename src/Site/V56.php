<?php

/**
 * class Phata\Widgetfy\Site\V56
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

class V56 implements Common {

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
        if (preg_match('/^\/u(\d+)\/v_(\w+)\.html$/',
                $url_parsed['path'], $matches) == 1) {
            return array(
                'vid' => $matches[2],
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
        $width = 560; $height = 470;
        return array(
            'html' => '<iframe src="http://www.56.com/iframe/'.$extra['vid'].'" '.
                'width="'.$width.'" height="'.$height.'" '.
                'frameborder="0" allowfullscreen scrolling="no"></iframe>',
            'width' => $width,
            'height' => FALSE,
        );
    }
}