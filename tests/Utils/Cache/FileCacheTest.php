<?php

/**
 * Unit test for Phata\Widgetfy\Utils\Cache\FileCache
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
 * - Phata\Widgetfy\Utils\Cache\FileCache
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Utils\Cache\FileCache as FileCache;
use PHPUnit\Framework\TestCase;

class FileCacheTest extends TestCase {

    public function testFile() {
        $c = new FileCache;
        $group = 'test';
        $key = 'testFile';
        $value = md5(time() . rand()); // random value
        $cache_fullpath = $c->fullpath($c->filename($group, $key));

        $c->set($group, $key, $value);
        $value2 = $c->get($group, $key);

        $this->assertTrue(file_exists($cache_fullpath));
        $this->assertEquals($value, $value2);
    }

}