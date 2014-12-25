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

class RealMediaVideo implements Common {

    /**
     * Implements Phata\Widgetfy\MediaFile\Common::translate
     *
     * determine if the URL is translatable
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @param string $url full url
     * @return boolean whether the url is translatable
     */
    public static function translatable($url_parsed, $url) {
        if (preg_match('/\/([^\/]+)\.(rm|rmvb)$/i', $url_parsed['path'], $matches) == 1) {
            $filename = htmlspecialchars($matches[1] . '.' . $matches[2]);
            $extension = strtolower($matches[2]);
            return array(
                'filetype' => $extension,
                'url' => $url,
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
     * @param mixed[] $extra array of extra url information
     * @return mixed either embed string or NULL if not applicable
     */
    public static function translate($url_parsed, $extra) {
    	$width = 400; $height = 300; $height_ctrl = 26;
        return array(
            'html' => '<embed type="audio/x-pn-realaudio-plugin" '.
                'src="'.$extra['url'].'" '.
                'width="'.$width.'" height="'.$height.'" autostart="false" '.
                'controls="imagewindow" nojava="true" '.
                'console="video" '.
                'pluginspage="https://www.real.com/"></embed><br>'.
                '<embed type="audio/x-pn-realaudio-plugin" '.
                'src="%s" '.
                'width="'.$width.'" height="'.$height_ctrl.'" autostart="false" '.
                'nojava="true" controls="ControlPanel" '.
                'console="video"></embed>',
            'width' => $width,
            'height' => $height,
        );
	}

}