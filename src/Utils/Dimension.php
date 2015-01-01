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

    public $width = FALSE;
    public $height = FALSE;

    /**
     * translate from width and ratio to dimension
     *
     * @param int $width width of the rectangular dimension
     * @param float $factor a factor to determine height.
     *        bool False to omit height
     * @return rendered dimension
     */
    public static function &fromWidth($width, $factor=FALSE) {

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
    		$d->height = Calc::retHeight($width, $factor);
    	}
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
