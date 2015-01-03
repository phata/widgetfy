<?php

/**
 * class Phata\Widgetfy\Utils\Dimension
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
 * This file defines Phata\Widgetfy\Utils\Dimension
 * which is an utility class to help the Widgetfy
 * library to function.
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy\Utils;

class Dimension {

    /**
     * The scaling model of the given dimension
     *
     * Describe how the object will response if we want to change
     * the width of the dimension. For example if we want to change
     * the width of a flash video of a certain provider, how we
     * should generate the height parameter?
     *
     * 3 possible values:
     *
     * - 'scale-width-height':
     *    The scale ratio should remain the same. The height should
     *    be generated as proposion to the given width.
     *
     * - 'scale-width':
     *    You wouldn't calculate the height by the width. The height
     *    will simply change itself with the width or it will simply
     *    stay the same.
     *
     * - 'no-scale':
     *    You simply cannot scale the object. The width and height
     *    are fixed.
     *
     * @var string
     */
    public $scale_model = FALSE;

    /**
     * Pixel size of the object width
     * Or FALSE if not applicable
     *
     * @var mixed
     */
    public $width = FALSE;

    /**
     * Pixel size of the object height
     * Or FALSE if not applicable
     *
     * @var mixed
     */
    public $height = FALSE;

    /**
     * Pixel size of the object height
     * Or FALSE if not applicable
     *
     * @var mixed
     */
    public $factor = FALSE;

    /**
     * Whether or not this object could be changed
     * dynamically with the browser width / device
     * width.
     *
     * @var boolean
     */
    public $dynamic = FALSE;

    /**
     * translate from width and ratio to dimension
     *
     * @param mixed[] $options array of options in link translation
     * @param mixed[] $scale_spec specification of scaling property
     *        specific to a video / widget source
     * @param string $scale_model model of scaling property
     * @return rendered dimension
     */
    public static function &fromOptions($options,
            $scale_spec=array(), $scale_model='scale-width-height') {

        // render Dimension according to scale model
        switch ($scale_model) {

            case 'no-scale':

                /*
                 * 'no-scale':
                 *
                 * This scale model does not scale at all.
                 * The width and height are fixed to defaults
                 *
                 * 'no-scale' **requires** these fields in $scale_spec:
                 * - 'default_width' int the fixed width value
                 * - 'default_height' int the fixed height value
                 * - 'dynamic' boolean if this object can scale dynamically
                 */

                // default spec
                $scale_spec = (array) $scale_spec + array(
                    'dynamic' => FALSE,
                );

                $d = new Dimension;

                // validate spec
                if (!isset($scale_spec['default_width'])) {
                    throw DimensionError('scale model `no-scale` '.
                        'requires `default_width`');
                    return;
                }
                if (!isset($scale_spec['default_height'])) {
                    throw DimensionError('scale model `no-scale` '.
                        'requires `default_height`');
                    return;
                }
                if (!self::isInt($scale_spec['default_width'])) {
                    throw DimensionError('scale model `no-scale` '.
                        'requires integer for `default_width`');
                    return;
                }
                if (!self::isInt($scale_spec['default_height'])) {
                    throw DimensionError('scale model `no-scale` '.
                        'requires integer for `default_height`');
                    return;
                }

                // use default width and height
                $d->width = $scale_spec['default_width'];
                $d->height = $scale_spec['default_height'];

                // note scale model
                $d->scale_model = $scale_model;

                // determine dynamic property
                $d->dynamic = (bool) $scale_spec['dynamic'];

                return $d;

            case 'scale-width':

                /*
                 * 'scale-width':
                 *
                 * Width of the element varies with definition.
                 * Height scales to width automatically, or fixed.
                 *
                 * 'scale-width' accepts these fields in $scale_spec:
                 * - 'default_width' mixed width to use if no option provided
                 * - 'default_height' (optional) int the fixed height value
                 * - 'dynamic' boolean if this object can scale dynamically
                 */

                // default spec
                $scale_spec = (array) $scale_spec + array(
                    'default_width' => 640,
                    'dynamic' => TRUE,
                );

                $d = new Dimension;

                // determine width
                $d->width = isset($options['width']) ? 
                    $options['width'] : $scale_spec['default_width'];

                if (isset($scale_spec['default_height'])) {
                    // if default height is defined
                    // treated as fixed height
                    // otherwise presume height to be automatically scaled
                    $d->height = $scale_spec['default_height'];
                }

                // note scale model
                $d->scale_model = $scale_model;

                // determine dynamic property
                $d->dynamic = (bool) $scale_spec['dynamic'];

                return $d;

            case 'scale-width-height':
            default:

                /*
                 * 'scale-width-height':
                 *
                 * Represents normal iframe video embed.
                 * Adapts width and height by given values.
                 * Defining width doesn't hint the browser how height it is.
                 *
                 * 'scale-width-height' accepts these fields in $scale_spec:
                 * - 'factor' float factor height / width
                 * - 'default_width' mixed width to use if no option provided
                 * - 'max_width' int width to use if there is a maximum width
                 * - 'dynamic' boolean if this object can scale dynamically
                 */

                // default spec
                $scale_spec = (array) $scale_spec + array(
                    'factor' => 0.5625,
                    'default_width' => 640,
                    'max_width' => FALSE,
                    'dynamic' => TRUE,
                );

                // validate spec
                if (!self::valid($scale_spec['default_width'])) {
                    throw new DimensionError('default_width in $scale_spec is not valid');
                }

                // determine width
                $width = isset($options['width']) ? 
                    $options['width'] : $scale_spec['default_width'];

                // if max widht presents, use max width
                $width =
                    ($scale_spec['max_width'] != FALSE) &&
                    ($scale_spec['max_width'] < $width) ?
                    $scale_spec['max_width'] : $width;

                $d = self::fromWidth($width,
                    $scale_spec['factor'], $scale_model);

                // determine dynamic property
                $d->dynamic = (bool) $scale_spec['dynamic'];

                return $d;

        }

    }

    /**
     * translate from width and ratio to dimension
     *
     * @param int $width width of the rectangular dimension
     * @param float $factor a factor to determine height.
     *        bool False to omit height
     * @param string $scale_model model of scaling property
     * @return rendered dimension
     */
    public static function &fromWidth($width,
        $factor=FALSE, $scale_model=FALSE) {

    	// validate parameter
    	if (!self::isInt($width)) {
    		throw new DimensionError(
    			'First parameter must be integer or integer string');
    		return NULL;
    	} elseif (($factor !== FALSE) && !is_numeric($factor)) {
    		throw new DimensionError(
    			'Second parameter must be a number');
    		return NULL;
    	}

    	// render dimension
    	$d = new Dimension;
    	$d->width = $width;
    	if ($factor !== FALSE) {
    		$d->height = Calc::rectHeight($width, $factor);
    	}
        $d->factor = $factor;
        $d->scale_model = $scale_model;
    	return $d;
    }

    /**
     * translate the current dimension data
     * to attribute width="xxx" height="yyy"
     *
     * @return string HTML/XML attribute width and height
     */
    public function toAttr($prefix='', $suffix='') {
    	$attrs = array();
    	if ($this->width !== FALSE) {
    		$attrs[] = 'width="'.addslashes($this->width).'"';
    	}
    	if ($this->height !== FALSE) {
    		$attrs[] = 'height="'.addslashes($this->height).'"';
    	}
    	return $prefix.implode(' ', $attrs).$suffix;
    }

    /**
     * translate the current dimension data
     * to attribute width: 123px height: 456px
     *
     * @return string HTML/XML attribute width and height
     */
    public function toCSS($prefix='', $suffix='') {
    	$defs = array();
    	if ($this->width !== FALSE) {
    		$defs[] = 'width:'.
    			addslashes(self::toCSSvalue($this->width)).';';
    	}
    	if ($this->height !== FALSE) {
    		$defs[] = 'height:'.
    			addslashes(self::toCSSvalue($this->height)).';';
    	}
    	return $prefix.implode(' ', $defs).$suffix;
    }

    /**
     * translate a variable to CSS value
     */
    public static function toCSSvalue($var) {
    	if (self::isInt($var)) return $var.'px';
    	return $var;
    }

    /**
     * determine if a given variable is a
     * valid parameter for width and height
     *
     * @param mixed $var variable to test
     * @return boolean whether the variable pass the test
     */
    public static function valid($var) {
    	return self::isInt($var) || self::isPercentage($var);
    }

    /**
     * determine if a given variable is an integer
     * or an integer string
     *
     * @param mixed $var variable to test
     * @return boolean whether the variable pass the test
     */
    public static function isInt($var) {
    	return is_int($var) || preg_match('/^\d+$/', (string) $var);
    }

    /**
     * determine if a given variable is a percentage string
     *
     * @param mixed $var variable to test
     * @return boolean whether the variable pass the test
     */
    public static function isPercentage($var) {
    	return preg_match('/^\d+\%$/', (string) $var) == 1;
    }

}
