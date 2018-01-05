<?php

/**
 * Unit test for Phata\Widgetfy\Site\Kickstarter
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
 * - Phata\Widgetfy\Site\Kickstarter
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\Kickstarter as Kickstarter;
use PHPUnit\Framework\TestCase;

class KickstarterTest extends TestCase {

    public function testTranslateVideo() {
        $name = 'trammel/the-official-settlers-of-catan-gaming-board';
        $url = 'http://www.kickstarter.com/projects/'.$name;
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Kickstarter::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = Kickstarter::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<iframe width="640" height="480" '.
            'src="//www.kickstarter.com/projects/'.$name.'/widget/video.html" '.
            'frameborder="0" scrolling="no"></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['dimension']->factor, 0.75);
    }

}