<?php

/**
 * class Widgetarian\Widgetfy\Site\LiveLeak
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

class LiveLeak implements Common {

    private static $regex = '/^\/view$/';

    /**
     * Implements Widgetarian\Widgetfy\Site\Common::translate
     *
     * determine if the URL is translatable
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @return boolean whether the url is translatable
     */
    public static function translatable($url_parsed) {
    	return preg_match(self::$regex, $url_parsed['path']) == 1;
    }

    /**
     * Implements Widgetarian\Widgetfy\Site\Common::translate
     *
     * translate the provided URL into
     * HTML embed code of it
     * @param string[] $url_parsed result of parse_url($url)
     * @return mixed either embed string or NULL if not applicable
     */
    public static function translate($url_parsed) {

        parse_str($url_parsed['query'], $args);
    	$width = 640; $height = 360;

        // Note: LiveLeak supports HTTP only. No HTTPS.
		return array(
            'html' => '<iframe width="'.$width.'" height="'.$height.'" '.
                'src="http://www.liveleak.com/ll_embed?f='.$args['i'].'" '.
                'frameborder="0" allowfullscreen></iframe>',
            'width' => $width,
	        'height' => $height,
	    );
	}
}