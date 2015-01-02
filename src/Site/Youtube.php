<?php

/**
 * class Phata\Widgetfy\Site\Youtube
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

use Phata\Widgetfy\Utils\Cache as Cache;
use Phata\Widgetfy\Utils\Calc as Calc;

class Youtube implements Common {

    /**
     * Implements Phata\Widgetfy\Site\Common::translate
     *
     * preprocess the URL
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @return mixed array of preprocess result; boolean FALSE if not translatable
     */
    public static function preprocess($url_parsed) {
        if (preg_match('/^\/watch$/', $url_parsed['path'])) {
            $params = self::parseParams($url_parsed);
            if ($params == FALSE) return FALSE;
            if (!isset($params['vid']) || ($params['vid'] == FALSE)) return FALSE;
            return array(
                'path_type' => 'video',
                'params' => &$params,
            );
        } elseif ((preg_match('/^\/view_play_list$/', $url_parsed['path'])) ||
            (preg_match('/^\/playlist$/', $url_parsed['path']))) {
            parse_str($url_parsed["query"], $query);
            $location = preg_replace('/([a-z]+?)\.youtube\.com/', '$1', strtolower($url_parsed["host"]));
            return array(
                'path' => $url_parsed['path'],
                'path_type' => 'playlist',
                'query' => &$query,
                'location' => $location,
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

        $width = isset($options['width']) ? $options['width'] : 640;
        $factor = 0.5625; // 16:9
        $height = Calc::rectHeight($width, $factor);

        if ($info['path_type'] == 'video') {

            $params       = &$info['params'];
            $query_params = array();
            $query_str    = '';

            // calculating start time with "t" parameter
            if (!empty($params["t"])) {
                $start = self::calStartTime($params['t']);
                if ($start != 0) $query_params['start'] = $start;
            }

            // build query string
            if (!empty($query_params)) {
                $query_str = '?' . http_build_query($query_params);
            }

            // if vid exists in the link, and
            // the video can be embeded
            if (self::canEmbed($params['vid'])) {
                return array(
                    'type' => 'iframe',
                    'html' => '<iframe width="'.$width.'" height="'.$height.'" '.
                        'src="//www.youtube.com/embed/'.
                        $params['vid'].$query_str.'" '.
                        'frameborder="0" allowfullscreen></iframe>',
                    'width' => $width,
                    'height' => $height,
                    'factor' => $factor,
                );
            } else {
                // size of default thumbnail is 480x320
                // aspect ratio is 4:3, different from video (16:9)
                $width = isset($options['width']) ? $options['width'] : 480;
                $factor = 0.75;
                $height = Calc::rectHeight($width, $factor);
                return array(
                    'type' => 'link_image',
                    'html' => '<a target="_blank" '.
                        'href="http://www.youtube.com/watch?v='.$params['vid'].'">'.
                        '<img src="//img.youtube.com/vi/'.$params['vid'].'/0.jpg" '.
                        'style="width: '.$width.'px"/></a>',
                    'width' => $width,
                    'height' => $height,
                    'factor' => $factor,
                );
            }

        } elseif ($info['path_type'] == 'playlist') {
            $args = &$info['query'];
            $location = $info['location'];

            if (isset($args['p'])) {
                $lid = $args['p'];
                $string = '//'.$location.'.youtube.com'.$info['path'].'?p='.$lid;
            } elseif (isset($args['list']) and preg_match('/^PL/', $args['list'])) {
                $lid = $args['list'];
                $string = '//'.$location.'.youtube.com'.$info['path'].'?list='.$args['list'];
            }

            return array(
                'type' => 'iframe',
                'html' => '<iframe width="'.$width.'" height="'.$height.'" '.
                    'src="https://www.youtube.com/embed/videoseries?list='.$lid.'" '.
                    'frameborder="0" allowfullscreen></iframe>',
                'width' => $width,
                'height' => $height,
                'factor' => $factor,
            );

        }
        return NULL;
    }

    /**
     * Helper funciton. Use youtube api to check if a video can be embeded or not
     * @param string $vid video id of the youtube video
     */
    public static function canEmbed($vid) {
        Cache::init();
        $cache_group = 'youtubeapi';
        if (!Cache::exists($cache_group, $vid)) {
            try {
                $resp_json = file_get_contents(sprintf(
                    'https://gdata.youtube.com/feeds/api/videos/%s?v=2&alt=json',
                    $vid)
                );
                $response = json_decode($resp_json, TRUE); // decode to asso array

                $acs = $response['entry']['yt$accessControl'];
                $can_embed = FALSE;
                foreach ($acs as $ac) {
                    if ($ac['action'] == 'embed') {
                        $can_embed = ($ac['permission'] == "allowed");
                        break;
                    }
                }

                Cache::set($cache_group, $vid, array('can_embed'=>$can_embed));

            } catch (Exception $e) {
                $can_embed = TRUE; // assume to be embedable
            }

        } else {
            $cache = Cache::get($cache_group, $vid);
            $can_embed = $cache["value"]["can_embed"];
        }

        return $can_embed;
    }

    /**
     * helper function
     * extract t parameter and generate start time (second)
     * @param string $t the t parameter in youtube url
     */
    public static function calStartTime($t) {
        preg_match_all('/(\d+)(h|m|s|)/', $t, $t_matches);
        $start = 0;
        foreach (array_keys($t_matches[0]) as $i) {
            if ($t_matches[2][$i] == 'h') {
                $start += $t_matches[1][$i] * 60 * 60;
            } elseif ($t_matches[2][$i] == 'm') {
                $start += $t_matches[1][$i] * 60;
            } elseif ($t_matches[2][$i] == 's') {
                $start += $t_matches[1][$i];
            } elseif ($t_matches[2][$i] == '') {
                $start += $t_matches[1][$i];
            }
        }
        return $start;
    }

    /**
     * helper function
     * extract video id and other parameters from url
     * @param string[] $url_parsed result of parse_url($url)
     */
    public static function parseParams($url_parsed) {

        $vid = FALSE; $url_seperator = FALSE;

        if (preg_match('/^\/watch$/', $url_parsed['path'])) {
            // new Youtube utilizes fragment part instead of query
            $fragment_regex = '/^\!v\=([a-zA-Z0-9]+).*$/';

            if (isset($url_parsed['fragment']) && preg_match($fragment_regex, $url_parsed['fragment'])) {

                $vid = preg_replace($fragment_regex, '$1', $url_parsed['fragment']);
                $url_seperator = '#!';

            } else {

                // parse fragment parameters into query string
                if (!empty($url_parsed['fragment'])) {
                    if (!empty($url_parsed['query'])) {
                        $url_parsed['query'] = $url_parsed['query'].'&'.$url_parsed['fragment'];
                    } else {
                        $url_parsed['query'] = $url_parsed['fragment'];
                    }
                }

                // backward compatibility
                parse_str($url_parsed['query'], $args);
                if (isset($args['v'])) {
                    $vid = $args['v'];
                    $t = isset($args['t']) ? $args['t'] : '';
                    $t_fragment = !empty($t) ? '&t='.$t : '';
                    $url_seperator = '?';
                }

            }

            $location = preg_replace('/([a-z]+?)\.youtube\.com/', '$1', strtolower($url_parsed['host']));
            $string = 'http://'.$location.'.youtube.com/watch'.$url_seperator.'v='.$vid.$t_fragment;
        } elseif (preg_match('/^\/user\/[a-zA-Z0-9_\-]+$/',  $url_parsed['path'])){
            $fragment_regex = '/^p\/u\/[0-9]+\/([a-zA-Z0-9]+)/';
            if (preg_match($fragment_regex, $url_parsed['fragment'])) {
                $vid = preg_replace($fragment_regex, '$1', $url_parsed['fragment']);
            }

            $location = preg_replace('/([a-z]+?)\.youtube\.com/', '$1', strtolower($url_parsed['host']));
            $string = 'http://'.$url_parsed['host'].'/'.$url_parsed["path"].'#'.$url_parsed['fragment'];
        }


        return ($vid === FALSE) ? FALSE : array(
            'vid'           => $vid,
            'url_seperator' => $url_seperator,
            'location'      => $location,
            'string'        => $string,
            't'             => $t,
        );
    }

}