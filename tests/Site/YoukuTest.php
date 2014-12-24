<?php

/**
 * Unit test for Widgetarian\Widgetfy\Site\Youku
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
 * - Widgetarian\Widgetfy\Site\Youku
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Widgetarian/Widgetfy
 */

use Widgetarian\Widgetfy\Site\Youku as Youku;

class YoukuTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $url = parse_url('http://v.youku.com/v_show/id_XMjMxOTQzOTI=.html');
        $this->assertNotFalse($extra = Youku::translatable($url));
        $this->assertEquals(Youku::translate($url, $extra), array(
            'html' => '<iframe width="510" height="498" '.
                'src="http://player.youku.com/embed/XMjMxOTQzOTI=" '.
                'frameborder="0" allowfullscreen></iframe>',
            'width' => 510,
            'height' => 498,
        ));
    }

}