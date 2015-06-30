<?php

/**
 * class Phata\Widgetfy\Core
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
 * This file defines Phata\Widgetfy
 * which is a shortcut interface to use the library
 *
 * @package   Widgetfy
 * @author    Koala Yeung <koalay@gmail.com>
 * @copyright 2014 Koala Yeung
 * @licence   http://www.gnu.org/licenses/lgpl.html
 * @link      http://github.com/Phata/Widgetfy
 */

namespace Phata\Widgetfy;

class Core {

    /**
     * simplified interface to translate a url into embed code
     *
     * @param string $url URL to be translated
     * @return mixed array of embed information or
     *         NULL if not translatable
     */
    public static function translate($url, $options=array()) {
        if (($embed = \Phata\Widgetfy\Site::translate($url,
                $options)) != NULL) {
            return $embed;
        } elseif (($embed = \Phata\Widgetfy\MediaFile::translate($url,
                $options)) != NULL) {
            return $embed;
        }
        return NULL;
    }

}
