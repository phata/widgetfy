<?php

/**
 * Unit test for Phata\Widgetfy\Site\BiliBili
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
 * - Phata\Widgetfy\Site\BiliBili
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

use Phata\Widgetfy\Site\BiliBili as BiliBili;
use PHPUnit\Framework\TestCase;

class BiliBiliTest extends TestCase {

    public function testTranslateVideo() {
        $url = 'http://www.bilibili.com/video/av5833793/';
        $url_parsed = parse_url($url);
        $this->assertNotFalse($info = BiliBili::preprocess($url_parsed));

        // test returning embed code
        $options = array('width'=>544);
        $embed = BiliBili::translate($info, $options);
        $this->assertEquals($embed['html'],
            '<embed width="544" height="416" quality="high" '.
            'allowfullscreen="true" type="application/x-shockwave-flash" '.
            'src="http://static.hdslb.com/miniloader.swf" '.
            'flashvars="aid=5833793&page=1" '.
            'pluginspage="http://www.adobe.com/shockwave/'.
            'download/download.cgi?P1_Prod_Version=ShockwaveFlash"></embed>'
        );
        $this->assertEquals($embed['type'], 'flash_embed');
        $this->assertEquals($embed['dimension']->factor, 0.7629);
    }

}
