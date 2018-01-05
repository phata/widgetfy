<?php

/**
 * Unit test for Phata\Widgetfy\Utils\Calc
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
 * - Phata\Widgetfy\Utils\Calc
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Utils\Calc as Calc;
use PHPUnit\Framework\TestCase;

class CalcTest extends TestCase {

    public function testCalc_default() {
        $width = 640;
        $this->assertEquals(360, Calc::rectHeight($width));
    }

    public function testCalc_16_9() {
        $width = 640;
        $this->assertEquals(360, Calc::rectHeight($width, 0.5625));
    }

    public function testCalc_4_3() {
        $width = 640;
        $this->assertEquals(480, Calc::rectHeight($width, 0.75));
    }

}