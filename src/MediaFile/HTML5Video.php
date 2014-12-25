<?php

/**
 * class Phata\Widgetfy\MediaFile\HTML5Video
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
 * This file defines Phata\Widgetfy\MediaFile\HTML5Video
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

class HTML5Video implements Common {

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
        if (preg_match('/\.(\w+)$/i', $url_parsed['path'], $matches) == 1) {
            $extension = strtolower($matches[1]);
            if ($extension == 'ogv') $extension = 'ogg';
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

        // determine fallback message by filetype
        $message = '';
        switch($extra['filetype']) {
            case 'ogg':
                $message = 'Sorry, your browser has the following problem(s):
<ul><li>It does not support playing <a href="http://www.theora.org/" target="_blank">OGG Theora</a>; or</li>
<li>It does not support the HTML5 &lt;video&gt; element.</li></ul> Please upgrade to a browser such as <a
href="http://www.getfirefox.com" target="_blank">Firefox</a>.';
                break;
            case 'mp4':
                $message = 'Sorry, your browser has the following problem(s):
<ul><li>It does not support playing <strong>MP4 Video</strong>; or</li>
<li>It does not supportthe HTML5 &lt;video&gt; element.</li></ul> Please upgrade to a browser such as <a
href="http://www.google.com/chrome" target="_blank">Google Chrome</a>.';
                break;
            case 'webm':
                $message = 'Sorry, your browser has the following problem(s):
<ul><li>It does not support playing <a href="http://www.webmproject.org/" target="_blank">WebM Video</a>; or</li>
<li>It does not supportthe HTML5 &lt;video&gt; element.</li></ul> Please upgrade to a browser such as <a
href="http://www.google.com/chrome" target="_blank">Google Chrome</a>.';
                break;
        }

        // render output
    	$width = 640; $height = FALSE;
        return array(
            'html' => '<video width="'.$width.'" controls="true" preload="metadata">'.
                '<source src="'.$extra['url'].'" type="video/'.$extra['filetype'].'" />'.
                $message.
                '</video>',
            'width' => $width,
            'height' => $height,
        );
	}
}