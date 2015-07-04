<?php

/**
 * Unit test for Phata\Widgetfy\Site\Facebook
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
 * This file is a unit test for
 * - Phata\Widgetfy\Site\Facebook
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\Facebook as Facebook;

class FacebookTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo1() {
        $url = 'https://www.facebook.com/video.php?v=10152802584496147';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Facebook::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = Facebook::translate($info, $options);
        $this->assertEquals($info['data-href'], 'https://www.facebook.com/video.php?v=10152802584496147&type=1');
        $this->assertEquals($embed['html'],
            '<div id="fb-root"></div>'.
            '<script>'.
            '(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];'.
            'if (d.getElementById(id)) return;js = d.createElement(s); '.
            'js.id = id;js.src = "//connect.facebook.net/zh_HK/sdk.js#xfbml=1&version=v2.3";'.
            'fjs.parentNode.insertBefore(js, fjs);}'.
            '(document, \'script\', \'facebook-jssdk\'));'.
            '</script>'.
            '<div class="fb-video" data-allowfullscreen="1" '.
            'data-href="'.$info['data-href'].'" data-width="640">'.
            '</div>'
        );
        $this->assertEquals($embed['type'], 'javascript');
        $this->assertEquals($embed['dimension']->width, 640);
        $this->assertFalse($embed['dimension']->factor);
    }

    public function testTranslateVideo2() {
        $url = 'https://www.facebook.com/#!/video.php?v=10152802584496147';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Facebook::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = Facebook::translate($info, $options);
        $this->assertEquals($info['data-href'], 'https://www.facebook.com/video.php?v=10152802584496147&type=1');
        $this->assertEquals($embed['html'],
            '<div id="fb-root"></div>'.
            '<script>'.
            '(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];'.
            'if (d.getElementById(id)) return;js = d.createElement(s); '.
            'js.id = id;js.src = "//connect.facebook.net/zh_HK/sdk.js#xfbml=1&version=v2.3";'.
            'fjs.parentNode.insertBefore(js, fjs);}'.
            '(document, \'script\', \'facebook-jssdk\'));'.
            '</script>'.
            '<div class="fb-video" data-allowfullscreen="1" '.
            'data-href="'.$info['data-href'].'" data-width="640">'.
            '</div>'
        );
        $this->assertEquals($embed['type'], 'javascript');
        $this->assertEquals($embed['dimension']->width, 640);
        $this->assertFalse($embed['dimension']->factor);
    }

    public function testTranslateVideo3() {
        $url = 'https://www.facebook.com/RedBullBike/videos/vb.572719819512238/781424595308425/?type=2&theater';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Facebook::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = Facebook::translate($info, $options);
        $this->assertEquals($info['data-href'], '/RedBullBike/videos/vb.572719819512238/781424595308425/?type=1');
        $this->assertEquals($embed['html'],
            '<div id="fb-root"></div>'.
            '<script>'.
            '(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];'.
            'if (d.getElementById(id)) return;js = d.createElement(s); '.
            'js.id = id;js.src = "//connect.facebook.net/zh_HK/sdk.js#xfbml=1&version=v2.3";'.
            'fjs.parentNode.insertBefore(js, fjs);}'.
            '(document, \'script\', \'facebook-jssdk\'));'.
            '</script>'.
            '<div class="fb-video" data-allowfullscreen="1" '.
            'data-href="'.$info['data-href'].'" data-width="640">'.
            '</div>'
        );
        $this->assertEquals($embed['type'], 'javascript');
        $this->assertEquals($embed['dimension']->width, 640);
        $this->assertFalse($embed['dimension']->factor);
    }

    public function testTranslateVideo4() {
        $url = 'https://www.facebook.com/Usavich/videos/919568248066129/';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Facebook::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = Facebook::translate($info, $options);
        $this->assertEquals($info['data-href'], '/Usavich/videos/919568248066129/?type=1');
        $this->assertEquals($embed['html'],
            '<div id="fb-root"></div>'.
            '<script>'.
            '(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];'.
            'if (d.getElementById(id)) return;js = d.createElement(s); '.
            'js.id = id;js.src = "//connect.facebook.net/zh_HK/sdk.js#xfbml=1&version=v2.3";'.
            'fjs.parentNode.insertBefore(js, fjs);}'.
            '(document, \'script\', \'facebook-jssdk\'));'.
            '</script>'.
            '<div class="fb-video" data-allowfullscreen="1" '.
            'data-href="'.$info['data-href'].'" data-width="640">'.
            '</div>'
        );
        $this->assertEquals($embed['type'], 'javascript');
        $this->assertEquals($embed['dimension']->width, 640);
        $this->assertFalse($embed['dimension']->factor);
    }



}
