<?php

/**
 * Unit test for Phata\Widgetfy\Core
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
 * @category  File
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @license   http://www.gnu.org/licenses/lgpl.html LGPL License
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Theme;
use Phata\Widgetfy\Utils\Dimension;
use PHPUnit\Framework\TestCase;

/**
 * Test case for Phata\Widgetfy\Theme
 *
 * @category  Class
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @license   http://www.gnu.org/licenses/lgpl.html LGPL License
 * @link      http://github.com/Phata/Widgetfy
 */
class ThemeTest extends TestCase
{

    /**
     * Test Theme::toHTML
     *
     * @return void
     */
    public function testToHTMLWithoutCSS()
    {
        $embed = [
            'html' => 'hello',
            'dimension' => Dimension::fromWidth(640),
        ];
        $result = Theme::toHTML($embed);
        $expected = '<div class="videoblock" style="width: 640px;"> <div class="video-wrapper" style="">hello</div> </div>';
        $this->assertEquals(trim($result), trim($expected));
    }

}
