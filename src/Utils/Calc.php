<?php

/**
 * class Phata\Widgetfy\Utils\Calc
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
 * This file defines Phata\Widgetfy\Utils\Calc
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

class Calc{

    /**
     * calculates the height of a rectangle with a given
     * height and aspect factor
     *
     * @param int $width width of the rectangle
     * @param float $factor the result of height / width
     *        default to be ratio of a 16:9 rectangle
     * @return int round up result of height
     */
    public static function rectHeight($width, $aspect_factor=0.5625) {
        return ceil($width * $aspect_factor);
    }

}
