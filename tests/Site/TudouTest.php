<?php

/**
 * Unit test for Phata\Widgetfy\Site\Tudou
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
 * - Phata\Widgetfy\Site\Tudou
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\Tudou as Tudou;

class TudouTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo1() {
        $url = 'http://www.tudou.com/programs/view/VJlCrFBCh0s/';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($extra = Tudou::translatable($url_parsed, $url));

        // test returning embed code
        $embed = Tudou::translate($extra);
        $this->assertEquals($embed['html'],
            '<iframe src="http://www.tudou.com/programs/view/html5embed.action?'.
            'type=0&code=VJlCrFBCh0s&lcode=&resourceId=0_06_05_99" '.
            'allowtransparency="true" allowfullscreen="true" '.
            'scrolling="no" border="0" frameborder="0" '.
            'style="width:480px;height:400px;"></iframe>'
        );
    }

    public function testTranslateVideo2() {
        $url = 'http://www.tudou.com/albumplay/92J2xqpSxWY/PbNLkw0cgtI.html';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($extra = Tudou::translatable($url_parsed, $url));

        // test returning embed code
        $embed = Tudou::translate($extra);
        $this->assertEquals($embed['html'],
            '<iframe src="http://www.tudou.com/programs/view/html5embed.action?'.
            'type=2&code=PbNLkw0cgtI&lcode=92J2xqpSxWY&resourceId=0_06_05_99" '.
            'allowtransparency="true" allowfullscreen="true" '.
            'scrolling="no" border="0" frameborder="0" '.
            'style="width:480px;height:400px;"></iframe>'
        );
    }

}