<?php

/**
 * class Phata\Widgetfy\Utils\URL
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
 * This file defines Phata\Widgetfy\Utils\URL
 * which is an utility class to help the Widgetfy
 * library to function.
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy\Utils;

class URL{

    /**
     * build a URL from the result assoc array of parse_url()
     * @param string[] $url_parsed result of parse_url()
     * @return string url string
     */
    public static function build($url_parsed) {

        // add default values to prevent empty
        $url_parsed = (array) $url_parsed + array(
            'scheme' => '',
            'host' => '',
            'port' => '',
            'user' => '',
            'pass' => '',
            'path' => '',
            'query' => '',
            'fragment' => '',
        );

        $url = '';

        // add components that depends on host
        if (!empty($url_parsed['host'])){

            // scheme
            $url = empty($url_parsed['scheme']) ?
                '//' : $url_parsed['scheme'].'://';

            // components that depends on user
            if (!empty($url_parsed['user'])) {
                $url .= empty($url_parsed['pass']) ?
                    $url_parsed['user'] :
                    $url_parsed['user'] . ':' . $url_parsed['pass'] ;
                $url .= '@';
            }

            // host
            $url .= $url_parsed['host'];

            // port
            $url .= empty($url_parsed['port']) ?
                '' : ':' . ((int) $url_parsed['port']);

        }

        // path
        $url .= empty($url_parsed['path']) ?
            '' : $url_parsed['path'];

        // query
        $url .= empty($url_parsed['query']) ?
            '' : '?' . $url_parsed['query'];

        // fragment
        $url .= empty($url_parsed['fragment']) ? 
            '' : '#' . $url_parsed['fragment'];

        return $url;

    }

}
