<?php

/**
 * Unit test for Phata\Widgetfy\Site\Youku
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
 * - Phata\Widgetfy\Site\Youku
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\Youku as Youku;

class YoukuTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $url ='http://v.youku.com/v_show/id_XMjMxOTQzOTI=.html';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Youku::preprocess($url_parsed));

        // test returning embed code
        $options = array('width' => 640);
        $embed = Youku::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<iframe width="640" height="625" '.
            'src="http://player.youku.com/embed/XMjMxOTQzOTI=" '.
            'frameborder="0" allowfullscreen></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['factor'], 0.9764);
    }

}