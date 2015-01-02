<?php

require_once __DIR__ . '/includes/common.php';

use Phata\Widgetfy as Widgetfy;

// get a list of translatable URLs
$urls = getDemoURLs();

// options to use for these videos
$options = array(
  'width' => 640
);

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, user-scalable=no">
<title>Example 1</title>
<link rel="stylesheet" type="text/css" href="./misc/example1.css" />
</head>
<body>
<h1>Example 1</h1>
<section id="content">
    <?php foreach ($urls as $url) { ?>
    <?php $embed = Widgetfy::translate($url['url'], $options); ?>
    <?php $d = &$embed['dimension']; ?>
        <div class="videoblock <?php if ($d->dynamic) print 'videoblock-dynamic'; ?>" style="<?php print style_block($embed); ?>">
            <h2><?php print $url['name']; ?></h2>
            <div class="debug-info"><?php print json_encode($d); ?></div>
            <div class="videowrapper wrap-<?php print $d->scale_model;?>"
             style="<?php print style_wrapper($embed); ?>"><?php print $embed['html']; ?></div>
        </div>
    <?php } ?>
</section>
</body>
</html>
