<?php

/**
 * Unit test for Phata\Widgetfy\MediaFile\RealMediaVideo
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
 * - Phata\Widgetfy\MediaFile\RealMediaVideo
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\MediaFile\RealMediaVideo as RealMediaVideo;

class RealMediaVideoTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideoMpg() {
        $url = 'http://foobar.com/video.rmvb';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($extra = RealMediaVideo::translatable($url_parsed));
        $this->assertEquals(RealMediaVideo::translate($extra), array(
            'html' => '<embed type="audio/x-pn-realaudio-plugin" '.
                'src="http://foobar.com/video.rmvb" '.
                'width="400" height="300" autostart="false" '.
                'controls="imagewindow" nojava="true" '.
                'console="video" '.
                'pluginspage="https://www.real.com/"></embed><br>'.
                '<embed type="audio/x-pn-realaudio-plugin" '.
                'src="%s" '.
                'width="400" height="26" autostart="false" '.
                'nojava="true" controls="ControlPanel" '.
                'console="video"></embed>',
            'width' => 400,
            'height' => 300,
        ));
    }

}