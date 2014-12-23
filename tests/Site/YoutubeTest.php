<?php

use Widgetarian\Widgetfy\Site\Youtube as Youtube;

class YoutubeTest extends PHPUnit_Framework_TestCase {

    public function testTranslateVideo() {
        $url = parse_url('https://www.youtube.com/watch?v=PBLuP2JZcEg');
        $this->assertTrue(Youtube::translatable($url));
        $this->assertEquals(Youtube::translate($url), array (
          'html' => '<iframe width="576" height="354" '.
            'src="//www.youtube.com/embed/PBLuP2JZcEg" frameborder="0" allowfullscreen></iframe>',
          'width' => 576,
          'height' => 354,
      ));
    }

    public function testTranslatePlayList() {
        $url = parse_url('https://www.youtube.com/playlist?list=PLJicmE8fK0EiEzttYMD1zYkT-SmNf323z');
        $this->assertTrue(Youtube::translatable($url));
        $this->assertEquals(Youtube::translate($url), array (
          'html' => '<iframe width="640" height="360" '.
          'src="https://www.youtube.com/embed/videoseries?list=PLJicmE8fK0EiEzttYMD1zYkT-SmNf323z" '.
          'frameborder="0" allowfullscreen></iframe>',
          'width' => 640,
          'height' => 360,
        ));
    }

}
