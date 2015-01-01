<?php

/**
 * Unit test for Phata\Widgetfy\Site\SteamStore
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
 * - Phata\Widgetfy\Site\SteamStore
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\SteamStore as SteamStore;

class SteamStoreTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $url = 'http://store.steampowered.com/app/252530/';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = SteamStore::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = SteamStore::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<iframe src="//store.steampowered.com/widget/252530/" '.
            'width="640" height="190" frameborder="0"></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['factor'], 0.2969);
        $this->assertEquals($embed['height'], 190); // fixed height
        $this->assertTrue($embed['special']['fixed_height']); // fixed height
    }

}