<?php

/**
 * Unit test for Phata\Widgetfy\Site\NicoNico
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
 * - Phata\Widgetfy\Site\NicoNico
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\NicoNico as NicoNico;
use PHPUnit\Framework\TestCase;

class NicoNicoTest extends TestCase {

    public function testTranslateVideo() {
        $url = 'http://www.nicovideo.jp/watch/sm4772361';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = NicoNico::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = NicoNico::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<script type="text/javascript" '.
            'src="http://ext.nicovideo.jp/thumb_watch/sm4772361"></script>'
        );
        $this->assertEquals($embed['type'], 'javascript');
        $this->assertEquals($embed['dimension']->width, 485);
        $this->assertEquals($embed['dimension']->height, 385);
        $this->assertEquals($embed['dimension']->factor, FALSE);
        $this->assertEquals($embed['javascript'], 'flash_embed');
    }

}