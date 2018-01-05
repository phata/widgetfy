<?php

/**
 * Default theming facility.
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
 * This file defines Phata\Widgetfy\Site
 * which is the main interface to translate url into
 * widget embed code.
 *
 * PHP Version >=7.0
 *
 * @category  File
 * @package   Phata\Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2018 Koala Yeung
 * @license   http://www.gnu.org/licenses/lgpl.html LGPL License
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy;

/**
 * Default theming facility.
 *
 * @category  Class
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @license   http://www.gnu.org/licenses/lgpl.html LGPL License
 * @link      http://github.com/Phata/Widgetfy
 */
class Theme
{

    /**
     * Helper function to make a non-unicode string shortter
     *
     * @param string $string The string to be trimmed
     * @param int    $length The targeted trimed length
     *
     * @return string trimmed string
     */
    public static function stringTrim(string $string, int $length): string
    {
        if ($length<16) return $string;
        if (strlen($string)>$length) {
            $str_head = substr($string, 0, $length-10);
            $str_tail = substr($string, -7, 7);
            return $str_head.'...'.$str_tail;
        }
        return $string;
    }
    /**
     * Helper funcion to template. Render attributes for .videoblock
     *
     * @param array $embed embed definition
     *
     * @return string HTTP attributes
     */
    public static function renderBlockAttrs(array $embed): string
    {
        // attributes to be rendered
        $classes = array();
        $styles = array();
        // shortcuts
        $d = &$embed['dimension'];
        // determine classes
        $classes[] = 'videoblock';
        if ($d->dynamic) {
            $classes[] = 'videoblock-dynamic';
        }
        // determine inline CSS style(s)
        // if scale model is no-scale, allow to "force dynamic"
        // by setting "dynamic" to TRUE
        if ($d->dynamic) {
            $styles[] = 'max-width:'.$d->width.'px';
        } else {
            $styles[] = 'width: '.$d->width.'px';
        }
        // render the attributes
        $class = implode(' ', $classes);
        $style = implode('; ', $styles) . (!empty($styles) ? ';' : '');
        return 'class="'.$class.'" style="'.$style.'"';
    }


    /**
     * Helper funcion to template. Render attributes for .videowrapper
     *
     * @param array $embed embed definition
     *
     * @return string HTTP attributes
     */
    public static function renderWrapperAttrs(array $embed): string
    {
        // attributes to be rendered
        $classes = array();
        $styles = array();
        // shortcuts
        $d = &$embed['dimension'];
        // determine classes
        $classes[] = 'video-wrapper';
        if ($d->dynamic) {
            $classes[] = 'wrap-'.$d->scale_model;
        }
        // determine inline CSS style(s)
        if ($d->dynamic && ($d->scale_model == 'scale-width-height')) {
            $styles[] = 'padding-bottom: ' . ($d->factor * 100) . '%;';
        }
        // render the attributes
        $class = implode(' ', $classes);
        $style = implode('; ', $styles) . (!empty($styles) ? ';' : '');
        return 'class="'.$class.'" style="'.$style.'"';
    }

    /**
     * Theme the given embed information array into HTML string
     *
     * @param array   $embed       Embed information produced by
     *                             Core::translate function.
     * @param boolean $inlineStyle Whether the returned string should include default
     *                             stylesheet. Default to be false.
     *
     * @return string
     */
    public static function toHTML(array $embed, bool $inlineStyle=false): string
    {
        static $css_done;
        $css = '';

        // use object dimension as dimension reference
        $d = &$embed['dimension'];

        // link to the stylesheet on first run
        if ($inlineStyle && !isset($css_done)) {
            $css = '<style>' . Theme::style() .  '</style>';
            $css_done = true;
        }

        ob_start();
        include __DIR__ . '/Theme/theme.tpl.php';
        $codeblock = ob_get_contents();
        ob_end_clean();
        return preg_replace('/[\t ]*[\r\n]+[\t ]*/', ' ', $css.$codeblock);
    }

    /**
     * Return the default CSS style for inlining.
     * Simply returning the content in src/Theme/theme.css
     *
     * @return string
     */
    public static function style(): string
    {
        static $_css;
        if (!isset($_css)) {
            $_css = file_get_contents(__DIR__ . '/Theme/theme.css');
        }
        return $_css;
    }
}
