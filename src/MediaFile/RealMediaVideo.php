<?php

/**
 * class Phata\Widgetfy\MediaFile\RealMediaVideo
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
 * This file defines Phata\Widgetfy\MediaFile\RealMediaVideo
 * which is a site definition that implements
 * Phata\Widgetfy\MediaFile\Common
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy\MediaFile;

use Phata\Widgetfy\Utils\URL as URL;
use Phata\Widgetfy\Utils\Dimension as Dimension;


class RealMediaVideo implements Common {

    /**
     * Implements Phata\Widgetfy\MediaFile\Common::translate
     *
     * preprocess the URL
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @return mixed array of preprocess result; boolean FALSE if not translatable
     */
    public static function preprocess($url_parsed) {
        if (preg_match('/\/([^\/]+)\.(rm|rmvb)$/i', $url_parsed['path'], $matches) == 1) {
            $filename = htmlspecialchars($matches[1] . '.' . $matches[2]);
            $extension = strtolower($matches[2]);
            return array(
                'filetype' => $extension,
                'url' => URL::build($url_parsed),
            );
        }
        return FALSE;
    }

    /**
     * Implements Phata\Widgetfy\MediaFile\Common::translate
     *
     * translate the provided URL into
     * HTML embed code of it
     * @param string[] $url_parsed result of parse_url($url)
     * @param mixed[] $options array of options
     * @return mixed[] array of embed information or NULL if not applicable
     */
    public static function translate($info, $options=array()) {

        // hardcorded controls height
        $height_ctrl = 26;
        $d = Dimension::fromOptions($options, array(
            'scale_model' => 'scale-width',
            'default_width' => 400,
        ), 'scale-width');

        return array(
            'html' => '<embed type="audio/x-pn-realaudio-plugin" '.
                'src="'.$info['url'].'" '.
                $d->toAttr().' autostart="false" '.
                'controls="imagewindow" nojava="true" '.
                'console="video" '.
                'pluginspage="https://www.real.com/"></embed><br>'.
                '<embed type="audio/x-pn-realaudio-plugin" '.
                'src="'.$info['url'].'" '.
                'width="'.$d->width.'" height="'.$height_ctrl.'" autostart="false" '.
                'nojava="true" controls="ControlPanel" '.
                'console="video"></embed>',
            'dimension' => $d,
        );
	}

}