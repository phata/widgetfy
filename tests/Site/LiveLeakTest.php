<?php

/**
 * Unit test for Phata\Widgetfy\Site\LiveLeak
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
 * - Phata\Widgetfy\Site\LiveLeak
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\LiveLeak as LiveLeak;

class LiveLeakTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $url = 'http://www.liveleak.com/view?i=8ed_1220480664';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($extra = LiveLeak::translatable($url_parsed, $url));

        // test returning embed code
        $embed = LiveLeak::translate($url_parsed, $extra);
        $this->assertEquals($embed['html'],
            '<iframe width="640" height="360" '.
            'src="http://www.liveleak.com/ll_embed?f=8ed_1220480664" '.
            'frameborder="0" allowfullscreen></iframe>'
        );
    }

}