<?php

/**
 * Unit test for Phata\Widgetfy\Site\Dailymotion
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
 * - Phata\Widgetfy\Site\Dailymotion
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\Dailymotion as Dailymotion;
use PHPUnit\Framework\TestCase;

class DailymotionTest extends TestCase {

    public function testTranslateVideo() {
        $url = 'http://www.dailymotion.com/video/x4rj9p_tron_creation';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Dailymotion::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = Dailymotion::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<iframe frameborder="0" width="640" height="360" '.
            'src="//www.dailymotion.com/embed/video/x4rj9p" allowfullscreen></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['dimension']->factor, 0.5625);
    }

}