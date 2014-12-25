<?php

/**
 * Unit test for Phata\Widgetfy\Site\Xuite
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
 * - Phata\Widgetfy\Site\Xuite
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\Xuite as Xuite;

class XuiteTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $url = parse_url('http://vlog.xuite.net/play/czRuNEo0LTIwOTE5OTkzLmZsdg==');
        $this->assertNotFalse($extra = Xuite::translatable($url, ''));
        $this->assertEquals(Xuite::translate($url, $extra), array(
            'html' => '<iframe marginwidth="0" marginheight="0" '.
                'src="//vlog.xuite.net/embed/czRuNEo0LTIwOTE5OTkzLmZsdg=='.
                '?ar=0&as=0" width="640" height="360" scrolling="no" frameborder="0"></iframe>',
            'width' => 640,
            'height' => 360,
        ));
    }

}