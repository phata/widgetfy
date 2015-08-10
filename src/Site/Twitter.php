<?php

/**
 * class Phata\Widgetfy\Site\Twitter
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

define('VIDEO_REGEX', '/^\/([^\/]+)\/status\/(\d+)\/video\/(\d+)$/');

class Twitter implements Common {

    /**
     * Implements Phata\Widgetfy\Site\Common::translate
     *
     * preprocess the URL
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @return mixed array of preprocess result; boolean FALSE if not translatable
     */
    public static function preprocess($url_parsed) {
        if (preg_match(VIDEO_REGEX, $url_parsed['path'], $matches)) {
            return array(
                'username' => $matches[1],
                'post_id' => $matches[2],
                'video_num' => $matches[3],
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
        // default width is 600
        $d = Dimension::fromOptions($options, array(
            'scale_model' => 'no-scale',
            'default_width' => 560,
            'default_height' => 560,
        ));
 
        // build embed code with data-href
        if (isset($info['post_id'])) {
           return array(
                'type' => 'javascript',
                'javascript' => 'div',
                'html' => 
                  '<blockquote class="twitter-video" lang="zh-tw"><a href="https://twitter.com/'.
                  $info['username'].'/status/'.$info['post_id'].'"></a></blockquote>'.
                  '<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>',
                'dimension' => $d,
            );
        }
    }
}
