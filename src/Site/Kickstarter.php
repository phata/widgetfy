<?php

/**
 * class Phata\Widgetfy\Site\Kickstarter
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

use Phata\Widgetfy\Utils\Dimension as Dimension;

class Kickstarter implements Common {

    /**
     * Implements Phata\Widgetfy\Site\Common::translate
     *
     * preprocess the URL
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @return mixed array of preprocess result; boolean FALSE if not translatable
     */
    public static function preprocess($url_parsed) {
        if (preg_match('/^\/projects\/(.+?)$/', $url_parsed['path'], $matches) == 1) {
            return array(
                'id' => $matches[1],
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

        // default dimension (medium) is 640 x 480
        $d = Dimension::fromOptions($options, array(
            'factor' => 0.75, // 4:3
            'default_width'=> 640,
        ));

        // default dimension of widget is 420 x 220
        $d2 = Dimension::fromOptions($options, array(
            'default_width' => 220,
            'default_height' => ($d->height > 420) ?
                $d->height : 420,
        ), 'fixed-width-height');

        // Note: Kickstarter supports HTTP only. No HTTPS.
        return array(
            'type' => 'iframe',
            'html' =>
                '<iframe '.$d->toAttr().' '.
                'src="//www.kickstarter.com/projects/'.$info['id'].'/widget/video.html" '.
                'frameborder="0" scrolling="no"></iframe>',
            'dimension' => $d,

            // don't know if this will be useful
            // keep it for now
            'other' => array(
                'type' => 'iframe',
                'html' => '<iframe '.$d2->toAttr().' '.
                    'src="https://www.kickstarter.com/projects/'.$info['id'].'/widget/card.html?v=2" '.
                    'frameborder="0" scrolling="no"></iframe>',
                'dimension' => $d2,
            ),
        );
    }
}