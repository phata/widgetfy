<?php

/**
 * Unit test for Phata\Widgetfy\MediaFile\ClassicVideo
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
 * - Phata\Widgetfy\MediaFile\ClassicVideo
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\MediaFile\ClassicVideo as ClassicVideo;

class ClassicVideoTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideoMpg() {
        $url = 'http://foobar.com/video.mpg';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = ClassicVideo::preprocess($url_parsed));

        $options = array('width' => 640);
        $embed = ClassicVideo::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<object id="mediaplayer" width="640" '.
            'classid="clsid:22d6f312-b0f6-11d0-94ab-0080c74c7e95" '.
            'standby="loading windows media player components..." '.
            'type="application/x-oleobject">'.
            '<param name="FileName" value="video.mpg" />'.
            '<param name="autostart" value="false" />'.
            '<param name="ShowControls" value="true" />'.
            '<param name="ShowStatusBar" value="false" />'.
            '<param name="ShowDisplay" value="false" />'.
            '<embed type="application/x-mplayer2" '.
            'src="http://foobar.com/video.mpg" '.
            'name="mediaplayer" width="640" '.
            'ShowControls="1" ShowStatusBar="1" ShowDisplay="0" '.
            'autostart="0"></embed></object>');
        $this->assertEquals($embed['dimension']->width, 640);
        $this->assertEquals($embed['dimension']->height, FALSE);
    }

}