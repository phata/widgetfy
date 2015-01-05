<?php

/**
 * Unit test for Phata\Widgetfy\Utils\Dimension
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
 * - Phata\Widgetfy\Utils\Dimension
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Utils\Dimension as Dimension;
use Phata\Widgetfy\Utils\DimensionError as DimensionError;

class DimensionTest extends PHPUnit_Framework_TestCase {

    public function testIsInt() {
        $this->assertTrue(Dimension::isInt(123));
        $this->assertTrue(Dimension::isInt('123'));
        $this->assertFalse(Dimension::isInt('123%'));
        $this->assertFalse(Dimension::isInt(''));
    }

    public function testIsPercentage() {
        $this->assertFalse(Dimension::isPercentage(123));
        $this->assertFalse(Dimension::isPercentage('100'));
        $this->assertFalse(Dimension::isPercentage(''));
        $this->assertTrue(Dimension::isPercentage('100%'));
    }

    // without
    public function testFromWidth1() {
        $d = Dimension::fromWidth(640);
        $this->assertEquals($d->width, 640);
        $this->assertFalse($d->height);
    }

    // with factor
    public function testFromWidth2() {
        $d = Dimension::fromWidth(640, 0.5625);
        $this->assertEquals($d->width, 640);
        $this->assertEquals($d->height, 360);
    }

    // raise error for $width
    public function testFromWidth3() {
        $error = FALSE;
        try {
            $d = Dimension::fromWidth('100%');
        } catch (DimensionError $e) {
            $this->assertEquals($e->getMessage(),
                'First parameter must be integer or integer string');
            $error = TRUE;
        }
        $this->assertTrue($error);
    }

    // raise error for $factor
    public function testFromWidth4() {
        $error = FALSE;
        try {
            $d = Dimension::fromWidth('100', 'abc');
        } catch (DimensionError $e) {
            $this->assertEquals($e->getMessage(),
                'Second parameter must be a number');
            $error = TRUE;
        }
        $this->assertTrue($error);
    }

    // basic, width only
    public function testToAttr1() {
        $d = new Dimension;
        $d->width = 100;
        $this->assertEquals('width="100"', $d->toAttr());
    }

    // basic, width and height
    public function testToAttr2() {
        $d = new Dimension;
        $d->width = 100;
        $d->height = 200;
        $this->assertEquals('width="100" height="200"', $d->toAttr());
    }

    // mix integer and percentage
    public function testToAttr3() {
        $d = new Dimension;
        $d->width = 100;
        $d->height = '100%';
        $this->assertEquals('width="100" height="100%"', $d->toAttr());
    }

    // basic, width only
    public function testToCSS1() {
        $d = new Dimension;
        $d->width = 100;
        $this->assertEquals('width:100px;', $d->toCSS());
    }

    // basic, width and height
    public function testToCSS2() {
        $d = new Dimension;
        $d->width = 100;
        $d->height = 200;
        $this->assertEquals('width:100px; height:200px;', $d->toCSS());
    }

    // mix integer and percentage
    public function testToCSS3() {
        $d = new Dimension;
        $d->width = 100;
        $d->height = '100%';
        $this->assertEquals('width:100px; height:100%;', $d->toCSS());
    }

    // test 'scale-width-height'
    public function testFromOptionsScaleWidthHeight() {

        // default
        $d = Dimension::fromOptions(array());
        $this->assertEquals('scale-width-height', $d->scale_model);
        $this->assertEquals(640, $d->width);
        $this->assertEquals(360, $d->height);
        $this->assertEquals(0.5625, $d->factor);
        $this->assertTrue($d->dynamic);

        // provide options
        $d = Dimension::fromOptions(array(
            'width' => 600,
        ), array(
            'scale_model' => 'scale-width-height',
            'default_width' => 800,
            'factor' => 0.5,
        ));
        $this->assertEquals('scale-width-height', $d->scale_model);
        $this->assertEquals(600, $d->width);
        $this->assertEquals(300, $d->height);
        $this->assertEquals(0.5, $d->factor);
        $this->assertTrue($d->dynamic);

    }

    // test 'scale-width'
    public function testFromOptionsScaleWidth() {

        // auto height
        $d = Dimension::fromOptions(array(
            'width' => 600,
        ), array(
            'scale_model' => 'scale-width',
            'default_width' => 800,
        ));
        $this->assertEquals('scale-width', $d->scale_model);
        $this->assertEquals(600, $d->width);
        $this->assertFalse($d->height);
        $this->assertFalse($d->factor);
        $this->assertTrue($d->dynamic);

        // fixed height
        $d = Dimension::fromOptions(array(
            'width' => 600,
        ), array(
            'scale_model' => 'scale-width',
            'default_width' => 800,
            'default_height' => 900,
        ));
        $this->assertEquals('scale-width', $d->scale_model);
        $this->assertEquals(600, $d->width);
        $this->assertEquals(900, $d->height);
        $this->assertFalse($d->factor);
        $this->assertTrue($d->dynamic);

    }

    // test 'no-scale'
    public function testFromOptionsNoScale() {

        $d = Dimension::fromOptions(array(
            'width' => 600,
            'height' => 400,
        ), array(
            'scale_model' => 'no-scale',
            'default_width' => 900,
            'default_height' => 700,
        ));
        $this->assertEquals('no-scale', $d->scale_model);
        $this->assertEquals(900, $d->width);
        $this->assertEquals(700, $d->height);
        $this->assertFalse($d->factor);
        $this->assertTrue($d->dynamic);

    }

}