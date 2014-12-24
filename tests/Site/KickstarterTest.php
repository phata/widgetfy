<?php

/**
 * Unit test for Widgetarian\Widgetfy\Site\Kickstarter
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
 * - Widgetarian\Widgetfy\Site\Kickstarter
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Widgetarian/Widgetfy
 */

use Widgetarian\Widgetfy\Site\Kickstarter as Kickstarter;

class KickstarterTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $name = 'trammel/the-official-settlers-of-catan-gaming-board';
        $url = parse_url('http://www.kickstarter.com/projects/'.$name);
        $this->assertNotFalse($extra = Kickstarter::translatable($url));
        $this->assertEquals(Kickstarter::translate($url, $extra), array(
            'html' => '<iframe width="640" height="480" '.
                'src="//www.kickstarter.com/projects/'.$name.'/widget/video.html" '.
                'frameborder="0" scrolling="no"> </iframe> '.
                '<iframe width="220" height="480" '.
                'src="//www.kickstarter.com/projects/'.$name.'/widget/card.html" '.
                'frameborder="0" scrolling="no"> </iframe>',
            'width' => 860 + 6,
            'height' => 480 + 2,
        ));
    }

}