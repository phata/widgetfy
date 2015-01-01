<?php

/**
 * Unit test for Phata\Widgetfy\Site\Youtube
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
 * - Phata\Widgetfy\Site\Youtube
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\Youtube as Youtube;

class YoutubeTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideoRoot() {
        $url = 'https://youtube.com/watch?v=PBLuP2JZcEg';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Youtube::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = Youtube::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<iframe width="640" height="360" '.
            'src="//www.youtube.com/embed/PBLuP2JZcEg" frameborder="0" allowfullscreen></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['factor'], 0.5625);
    }

    public function testTranslateVideo() {
        $url = 'https://www.youtube.com/watch?v=PBLuP2JZcEg';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Youtube::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = Youtube::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<iframe width="640" height="360" '.
            'src="//www.youtube.com/embed/PBLuP2JZcEg" frameborder="0" allowfullscreen></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['factor'], 0.5625);
    }

    public function testTranslatePlayList() {
        $url = 'https://www.youtube.com/playlist?list=PLJicmE8fK0EiEzttYMD1zYkT-SmNf323z';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Youtube::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = Youtube::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<iframe width="640" height="360" '.
            'src="https://www.youtube.com/embed/videoseries?list=PLJicmE8fK0EiEzttYMD1zYkT-SmNf323z" '.
            'frameborder="0" allowfullscreen></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['factor'], 0.5625);
    }

}
