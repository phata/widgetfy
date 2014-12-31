<?php

/**
 * Unit test for Phata\Widgetfy\MediaFile\HTML5Video
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
 * - Phata\Widgetfy\MediaFile\HTML5Video
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\MediaFile\HTML5Video as HTML5Video;

class HTML5VideoTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideoOgg() {
        $url = 'http://foobar.com/video.ogg';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($extra = HTML5Video::translatable($url_parsed));
        $this->assertEquals(HTML5Video::translate($extra), array(
            'html' => '<video width="640" controls="true" preload="metadata">'.
                '<source src="http://foobar.com/video.ogg" type="video/ogg" />'.
                'Sorry, your browser has the following problem(s):
<ul><li>It does not support playing <a href="http://www.theora.org/" target="_blank">OGG Theora</a>; or</li>
<li>It does not support the HTML5 &lt;video&gt; element.</li></ul> Please upgrade to a browser such as <a
href="http://www.getfirefox.com" target="_blank">Firefox</a>.'.
                '</video>',
            'width' => 640,
            'height' => FALSE,
        ));
    }

    public function testTranslateVideoMp4() {
        $url = 'http://foobar.com/video.mp4';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($extra = HTML5Video::translatable($url_parsed));
        $this->assertEquals(HTML5Video::translate($extra), array(
            'html' => '<video width="640" controls="true" preload="metadata">'.
                '<source src="http://foobar.com/video.mp4" type="video/mp4" />'.
                'Sorry, your browser has the following problem(s):
<ul><li>It does not support playing <strong>MP4 Video</strong>; or</li>
<li>It does not supportthe HTML5 &lt;video&gt; element.</li></ul> Please upgrade to a browser such as <a
href="http://www.google.com/chrome" target="_blank">Google Chrome</a>.'.
                '</video>',
            'width' => 640,
            'height' => FALSE,
        ));
    }

    public function testTranslateVideoWebM() {
        $url = 'http://foobar.com/video.webm';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($extra = HTML5Video::translatable($url_parsed));
        $this->assertEquals(HTML5Video::translate($extra), array(
            'html' => '<video width="640" controls="true" preload="metadata">'.
                '<source src="http://foobar.com/video.webm" type="video/webm" />'.
                'Sorry, your browser has the following problem(s):
<ul><li>It does not support playing <a href="http://www.webmproject.org/" target="_blank">WebM Video</a>; or</li>
<li>It does not supportthe HTML5 &lt;video&gt; element.</li></ul> Please upgrade to a browser such as <a
href="http://www.google.com/chrome" target="_blank">Google Chrome</a>.'.
                '</video>',
            'width' => 640,
            'height' => FALSE,
        ));
    }

}