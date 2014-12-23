<?php

/**
 * Unit test for Widgetarian\Widgetfy\Site\Metacafe
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
 * - Widgetarian\Widgetfy\Site\Metacafe
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Widgetarian/Widgetfy
 */

use Widgetarian\Widgetfy\Site\Metacafe as Metacafe;

class MetacafeTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $url = parse_url('http://www.metacafe.com/watch/11395429/arma_iii_altis_life_honest_farmers_lan_party/');
        $this->assertNotFalse($extra = Metacafe::translatable($url));

        // Note: Metacafe only support HTTP. Not HTTPS
        $this->assertEquals(Metacafe::translate($url, $extra), array(
			'html' => '<iframe src="http//www.metacafe.com/embed/11395429/" width="600" height="338" allowFullScreen frameborder=0></iframe>',
			'width' => 600,
			'height' => 338,
		));
    }

}