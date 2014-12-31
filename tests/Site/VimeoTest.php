<?php

/**
 * Unit test for Phata\Widgetfy\Site\Vimeo
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
 * - Phata\Widgetfy\Site\Vimeo
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\Vimeo as Vimeo;

class VimeoTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $url = 'http://vimeo.com/97875604';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($extra = Vimeo::translatable($url_parsed, $url));

        // test returning embed code
        $embed = Vimeo::translate($url_parsed, $extra);
        $this->assertEquals($embed['html'],
            '<iframe src="//player.vimeo.com/video/97875604" '.
            'width="800" height="450" frameborder="0" '.
            'webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>'
        );
    }

}