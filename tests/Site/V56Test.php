<?php

/**
 * Unit test for Phata\Widgetfy\Site\V56
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
 * - Phata\Widgetfy\Site\V56
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\V56 as V56;

class V56Test extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $url = 'http://www.56.com/u74/v_MTI4MDY5MDE1.html';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = V56::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = V56::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<iframe src="http://www.56.com/iframe/MTI4MDY5MDE1" '.
            'width="640" height="538" frameborder="0" '.
            'allowfullscreen scrolling="no"></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['dimension']->factor, 0.8392);
    }

}