<?php

/**
 * class Phata\Widgetfy\Site\CollegeHumor
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

class CollegeHumor implements Common {

    /**
     * Implements Phata\Widgetfy\Site\Common::translate
     *
     * preprocess the URL
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @return mixed array of preprocess result; boolean FALSE if not translatable
     */
    public static function preprocess($url_parsed) {

        // new links
        if (preg_match('/^\/video\/(\d+)\/([^\/]+)$/', $url_parsed['path'], $matches) == 1) {
            return array(
                'version' => 2,
                'vid' => $matches[1],
                'name' => $matches[2],
            );
        }

        // old links
        if (preg_match('/^\/video\:(\d+)$/', $url_parsed['path'], $matches) == 1) {
            return array(
                'version' => 1,
                'vid' => $matches[1],
            );
        }
        if (preg_match('/^\/moogaloop\/moogaloop\.swf$/', $url_parsed['path'], $matches) == 1) {
            parse_str($url_parsed["query"], $args);
            return array(
                'version' => 1,
                'vid' => $args['clip_id'],
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
     * @param mixed[] $options array of options
     * @return mixed[] array of embed information or NULL if not applicable
     */
    public static function translate($info, $options=array()) {

        // default dimension is 610 x 343
        $width = isset($options['width']) ? $options['width'] : 610;
        $factor = 0.5622; // approx. 16:9
        $height = Calc::rectHeight($width, $factor);

        // Note: CollegeHumor supports HTTP only. No HTTPS.
        switch ($info['version']) {
            case 1:
                return array(
                    'type' => 'flash_object',
                    'html' => '<object type="application/x-shockwave-flash" '.
                        'data="http://www.collegehumor.com/moogaloop/'.
                        'moogaloop.swf?clip_id='.$info['vid'].'&fullscreen=1" '.
                        'width="'.$width.'" height="'.$height.'" >'.
                        '<param name="allowfullscreen" value="true" />'.
                        '<param name="movie" quality="best" value="http://www.collegehumor.com/'.
                        'moogaloop/moogaloop.swf?clip_id='.$info['vid'].'&fullscreen=1" /></object>',
                    'width' => $width,
                    'height' => $height,
                    'factor' => $factor,
                );
            case 2:
                return array(
                    'type' => 'iframe',
                    'html' => '<iframe src="http://www.collegehumor.com/e/'.$info['vid'].
                        '" width="'.$width.'" height="'.$height.'" '.
                        'frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>',
                    'width' => $width,
                    'height' => $height,
                    'factor' => $factor,
                );
        }
    }
}
