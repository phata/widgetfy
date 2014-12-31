<?php

/**
 * Unit test for Phata\Widgetfy\Site\CollegeHumor
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
 * - Phata\Widgetfy\Site\CollegeHumor
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\CollegeHumor as CollegeHumor;

class CollegeHumorTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo1a() {
        $url = 'http://www.collegehumor.com/video:1817806';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = CollegeHumor::preprocess($url_parsed, ''));

        // test returning embed code
        $embed = CollegeHumor::translate($info);
        $this->assertEquals($embed['html'],
            '<object type="application/x-shockwave-flash" '.
            'data="http://www.collegehumor.com/moogaloop/'.
            'moogaloop.swf?clip_id=1817806&fullscreen=1" '.
            'width="610" height="343" >'.
            '<param name="allowfullscreen" value="true" />'.
            '<param name="movie" quality="best" value="http://www.collegehumor.com/'.
            'moogaloop/moogaloop.swf?clip_id='.$info['vid'].'&fullscreen=1" /></object>'
        );
    }

    public function testTranslateVideo1b() {
        $url = 'http://www.collegehumor.com/video:1817806';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = CollegeHumor::preprocess($url_parsed));

        // test returning embed code
        $embed = CollegeHumor::translate($info);
        $this->assertEquals($embed['html'],
            '<object type="application/x-shockwave-flash" '.
            'data="http://www.collegehumor.com/moogaloop/'.
            'moogaloop.swf?clip_id=1817806&fullscreen=1" '.
            'width="610" height="343" >'.
            '<param name="allowfullscreen" value="true" />'.
            '<param name="movie" quality="best" value="http://www.collegehumor.com/'.
            'moogaloop/moogaloop.swf?clip_id='.$info['vid'].'&fullscreen=1" /></object>'
        );
    }

    public function testTranslateVideo2() {
        $url = 'http://www.collegehumor.com/video/6926235/batman-and-superman-team-up';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = CollegeHumor::preprocess($url_parsed));

        // test returning embed code
        $embed = CollegeHumor::translate($info);
        $this->assertEquals($embed['html'],
            '<iframe src="http://www.collegehumor.com/e/6926235'.
            '" width="610" height="343" '.
            'frameborder="0" webkitAllowFullScreen allowFullScreen></iframe>'
        );
    }

}