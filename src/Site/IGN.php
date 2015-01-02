<?php

/**
 * class Phata\Widgetfy\Site\IGN
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

use Phata\Widgetfy\Utils\Calc as Calc;

class IGN implements Common {

    /**
     * Implements Phata\Widgetfy\Site\Common::translate
     *
     * preprocess the URL
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @param mixed[] $options array of options
     * @return mixed array of preprocess result; boolean FALSE if not translatable
     */
    public static function preprocess($url_parsed) {
        if (preg_match('/^\/videos\/(\d\d\d\d\/\d\d\/\d\d)\/(.+?)$/',
                $url_parsed['path'], $matches) == 1){
            return array(
                'date' => $matches[1],
                'slug' => $matches[2],
            );
        }
        return FALSE;
    }

    /**
     * Implements Phata\Widgetfy\Site\Common::translate
     *
     * translate the provided URL into
     * HTML embed code of it
     * @param mixed[] $info array of preprocessed url information
     * @return mixed[] array of embed information or NULL if not applicable
     */
    public static function translate($info, $options=array()) {
        // default dimension is 480 x 270
        $width = isset($options['width']) ? $options['width'] : 480;
        $factor = 0.5625; // 16:9
        $height = Calc::rectHeight($width, $factor);
        return array(
            'type' => 'iframe',
            'html' => '<iframe src="http://widgets.ign.com/video/embed/content.html?'.
                'slug='.$info['slug'].'" '.
                'scrolling="no" allowfullscreen="" frameborder="0" '.
                'width="'.$width.'" height="'.$height.'"></iframe>',
            'width' => $width,
            'height' => $height,
            'factor' => $factor,
            'special' => array(
                'wrapper_padding_bottom' => 8,
            ),
        );
    }
}