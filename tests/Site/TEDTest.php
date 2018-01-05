<?php

/**
 * Unit test for Phata\Widgetfy\Site\TED
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
 * - Phata\Widgetfy\Site\TED
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\TED as TED;
use PHPUnit\Framework\TestCase;

class TEDTest extends TestCase {

    public function testTranslateVideoOld() {
        $url = 'http://www.ted.com/talks/pattie_maes_demos_the_sixth_sense.html';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = TED::preprocess($url_parsed));

        // test returning embed code
        $embed = TED::translate($info);
        $this->assertEquals($embed['html'],
            '<iframe width="640" height="360" '.
            'src="//embed.ted.com/talks/pattie_maes_demos_the_sixth_sense.html" '.
            'frameborder="0" scrolling="no" '.
            'webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['dimension']->factor, 0.5625);
    }

    public function testTranslateVideoOld2() {
        $url = 'http://www.ted.com/talks/lang/eng/pattie_maes_demos_the_sixth_sense.html';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = TED::preprocess($url_parsed));

        // test returning embed code
        $embed = TED::translate($info);
        $this->assertEquals($embed['html'],
            '<iframe width="640" height="360" '.
            'src="//embed.ted.com/talks/pattie_maes_demos_the_sixth_sense.html" '.
            'frameborder="0" scrolling="no" '.
            'webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['dimension']->factor, 0.5625);
    }


    public function testTranslateVideo() {
        $url = 'http://www.ted.com/talks/pattie_maes_demos_the_sixth_sense';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = TED::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = TED::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<iframe width="640" height="360" '.
            'src="//embed.ted.com/talks/pattie_maes_demos_the_sixth_sense.html" '.
            'frameborder="0" scrolling="no" '.
            'webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['dimension']->factor, 0.5625);
    }

}
