<?php

/**
 * Template file for the default theme
 *
 * PHP Version 7.0
 *
 * @category  File
 * @package   Phata\Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2018 Koala Yeung
 * @license   http://www.gnu.org/licenses/lgpl.html LGPL License
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy;

?>
<div <?php print Theme::renderBlockAttrs($embed); ?>>
    <div <?php print Theme::renderWrapperAttrs($embed); ?>><?php print $embed['html']; ?></div>
</div>
