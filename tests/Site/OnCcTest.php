<?php

/**
 * Unit test for Phata\Widgetfy\Site\OnCc
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
 * - Phata\Widgetfy\Site\OnCc
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\OnCc as OnCc;
use PHPUnit\Framework\TestCase;

class OnCcTest extends TestCase {

    public function testTranslateVideo() {
        $url = 'http://tv.on.cc/hk/index.html?s=201&i=OCM141221-13212-201M&d=1419092839';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = OnCc::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = OnCc::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<iframe src="'.$url.'" '.
            'allowtransparency="true" allowfullscreen="true" '.
            'scrolling="no" border="0" frameborder="0" '.
            'width="640" height="361" ></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['dimension']->width, 640);
        $this->assertEquals($embed['dimension']->factor, 0.5632);
    }

    public function testTranslateVideoMaxWidth() {
        $url = 'http://tv.on.cc/hk/index.html?s=201&i=OCM141221-13212-201M&d=1419092839';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = OnCc::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>970); // bigger than max width
        $embed = OnCc::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<iframe src="'.$url.'" '.
            'allowtransparency="true" allowfullscreen="true" '.
            'scrolling="no" border="0" frameborder="0" '.
            'width="960" height="541" ></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['dimension']->width, 960);
        $this->assertEquals($embed['dimension']->factor, 0.5632);
    }

}