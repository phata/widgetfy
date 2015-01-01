<?php

/**
 * Unit test for Phata\Widgetfy\Site\Ku6
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
 * - Phata\Widgetfy\Site\Ku6
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\Ku6 as Ku6;

class Ku6Test extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $url = 'http://v.ku6.com/show/PbIRDjlz7Q18Iikf.html';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Ku6::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = Ku6::translate($info, $options=array());
        $this->assertEquals($embed['html'],
            '<embed src="//player.ku6.com/refer/PbIRDjlz7Q18Iikf/v.swf" '.
            'width="640" height="534" allowscriptaccess="always" allowfullscreen="true" '.
            'type="application/x-shockwave-flash" flashvars="from=ku6"></embed>'
        );
        $this->assertEquals($embed['type'], 'flash_embed');
        $this->assertEquals($embed['factor'], 0.8332);
    }

}