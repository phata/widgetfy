<?php

/**
 * class Widgetarian\Widgetfy\Site\Youtube
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

use Widgetarian\Widgetfy\Cache as Cache;

class Youtube implements Common {

    /**
     * Implements Widgetarian\Widgetfy\Site\Common::translate
     *
     * determine if the URL is translatable
     * by this site adapter
     * @param string[] $url_parsed result of parse_url($url)
     * @return boolean whether the url is translatable
     */
    public static function translatable($url_parsed) {
        if (preg_match('/^\/watch$/', $url_parsed['path'])) return TRUE;
        if (preg_match('/^\/view_play_list$/', $url_parsed['path'])) return TRUE;
        if (preg_match('/^\/playlist$/', $url_parsed['path'])) return TRUE;
        return FALSE;
    }

    /**
     * Implements Widgetarian\Widgetfy\Site\Common::translate
     *
     * translate the provided URL into
     * HTML embed code of it
     * @param string[] $url_parsed result of parse_url($url)
     * @param mixed[] $extra array of extra url information
     * @return mixed either embed string or NULL if not applicable
     */
    public static function translate($url_parsed, $extra) {

        if (preg_match('/^\/watch$/', $url_parsed['path'])) {

            $width = 576; $height = 354; // temp default

            if (($params = self::parseParams($url_parsed)) != FALSE) {
                $vid           = $params['vid'];
                $url_seperator = $params['url_seperator'];
                $location      = $params['location'];
                $string        = $params['string'];
                $query_params  = array();
            }

            // calculating start time with "t" parameter
            if (!empty($params["t"])) {
                $start = self::calStartTime($params['t']);
                if ($start != 0) $query_params['start'] = $start;
            }

            // if vid exists in the link, and
            // the video can be embeded
            if (($vid !== FALSE) && self::canEmbed($vid)) {

                // default query string and video dimension
                $query_str = http_build_query($query_params);
                if (!empty($query_str)) $query_str = '?'.$query_str;


                return array(
                    'html' => '<iframe width="'.$width.'" height="'.$height.'" '.
                        'src="//www.youtube.com/embed/'.$vid.$query_str.'" '.
                        'frameborder="0" allowfullscreen></iframe>',
                    'width' => $width,
                    'height' => $height,
                );

            } else {

                $width = 576; $height = 432; // temp default

                return array(
                    'html' => '<a target="_blank" '.
                        'href="http://www.youtube.com/watch?v='.$vid.'">'.
                        '<img src="//img.youtube.com/vi/'.$vid.'/0.jpg" '.
                        'style="width: '.$width.'px"/></a>',
                    'width' => $width,
                    'height' => $height,
                );
            }

        } elseif ((preg_match('/^\/view_play_list$/', $url_parsed["path"])) or
                (preg_match('/^\/playlist$/', $url_parsed["path"]))) {

            parse_str($url_parsed["query"], $args);
            $width = 640; $height = 360; // temp default
            $query_str="&version=3&fs=1";

            if (isset($args["loop"])) $query_str.=sprintf("&loop=%d", $args["loop"]);
            $location = preg_replace('/([a-z]+?)\.youtube\.com/', '$1', strtolower($url_parsed["host"]));

            if (isset($args['p'])) {
                $lid = $args['p'];
                $string = '//'.$location.'.youtube.com'.$url_parsed['path'].'?p='.$lid;
            } elseif (isset($args['list']) and preg_match('/^PL/', $args['list'])) {
                $lid = $args['list'];
                $string = '//'.$location.'.youtube.com'.$url_parsed['path'].'?list='.$args['list'];
            }

            return array(
                    'html' => '<iframe width="'.$width.'" height="'.$height.'" '.
                        'src="https://www.youtube.com/embed/videoseries?list='.$lid.'" '.
                        'frameborder="0" allowfullscreen></iframe>',
                    'width' => $width,
                    'height' => $height,
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