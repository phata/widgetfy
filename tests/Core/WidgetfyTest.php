<?php

/**
 * Unit test for Phata\Widgetfy
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
 * - Phata\Widgetfy
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy as Widgetfy;

class WidgetfyTest extends PHPUnit_Framework_TestCase {

    public function testGeneric() {
        $url = 'https://youtube.com/watch?v=PBLuP2JZcEg';
        $options = array('width'=>640);

        // test returning embed code
        $embed = Widgetfy::translate($url, $options);
        $this->assertEquals($embed['html'],
            '<iframe width="640" height="360" '.
            'src="//www.youtube.com/embed/PBLuP2JZcEg" frameborder="0" allowfullscreen></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['dimension']->factor, 0.5625);
    }

    public function testSiteOverride() {
        $url = 'https://youtube.com/watch?v=PBLuP2JZcEg';
        $options = array(
            'width' => 640,
            'overrides' => array(
                // override global options in specific class
                'Phata\Widgetfy\Site\Youtube' => array(
                    'width' => 800,
                    'factor' => 0.75
                ),
            ),
        );

        // test returning embed code
        $embed = Widgetfy::translate($url, $options);
        $this->assertEquals($embed['html'],
            '<iframe width="800" height="600" '.
            'src="//www.youtube.com/embed/PBLuP2JZcEg" frameborder="0" allowfullscreen></iframe>'
        );
        $this->assertEquals($embed['type'], 'iframe');
        $this->assertEquals($embed['dimension']->width, 800);
        $this->assertEquals($embed['dimension']->height, 600);
        $this->assertEquals($embed['dimension']->factor, 0.75);
    }

}