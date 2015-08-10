<?php

/**
 * Unit test for Phata\Widgetfy\Site\Twitter
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
 * - Phata\Widgetfy\Site\Twitter
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\Twitter as Twitter;

class TwitterTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $url = 'https://twitter.com/rantyu_xx/status/629262344196001793/video/1';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = Twitter::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>640);
        $embed = Twitter::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<blockquote class="twitter-video" lang="zh-tw"><a href="https://twitter.com/rantyu_xx/status/629262344196001793"></a></blockquote>'.
            '<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>'
        );
        $this->assertEquals($embed['type'], 'javascript');
        $this->assertEquals($embed['dimension']->width, 560);
        $this->assertEquals($embed['dimension']->height, 560);
    }

}
