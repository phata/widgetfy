<?php

/**
 * Unit test for Phata\Widgetfy\Utils\URL
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
 * - Phata\Widgetfy\Utils\URL
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Utils\URL as URL;

class URLTest extends PHPUnit_Framework_TestCase {

    // basic, full test
    public function testURL1() {
        $url = 'http://user1:pass1@foobar.com:1024/some/path?query=string#hash';
        $parsed = parse_url($url);
        $result = URL::build($parsed);
        $this->assertEquals($url, $result);
    }

    // simple url with query and hash
    public function testURL2() {
        $url = 'http://foobar.com/some/path?query=string#hash';
        $parsed = parse_url($url);
        $result = URL::build($parsed);
        $this->assertEquals($url, $result);
    }

    // simple url
    public function testURL3() {
        $url = 'http://foobar.com/some/path';
        $parsed = parse_url($url);
        $result = URL::build($parsed);
        $this->assertEquals($url, $result);
    }

    // url without scheme
    public function testURL4() {
        $url = '//foobar.com/some/path';
        $parsed = parse_url($url);
        $result = URL::build($parsed);
        $this->assertEquals($url, $result);
    }

    // path only
    public function testURL5() {
        $url = '/some/path?query=value#somehash';
        $parsed = parse_url($url);
        $result = URL::build($parsed);
        $this->assertEquals($url, $result);
    }

    // partial path only
    public function testURL6() {
        $url = 'some/path?query=value#somehash';
        $parsed = parse_url($url);
        $result = URL::build($parsed);
        $this->assertEquals($url, $result);
    }

    // query and hash only
    public function testURL7() {
        $url = '?query=value#somehash';
        $parsed = parse_url($url);
        $result = URL::build($parsed);
        $this->assertEquals($url, $result);
    }

    // hash only
    public function testURL8() {
        $url = '#somehash';
        $parsed = parse_url($url);
        $result = URL::build($parsed);
        $this->assertEquals($url, $result);
    }

}