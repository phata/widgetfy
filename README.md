Widgetfy
========

**Widgetfy** is a PHP library to translate URLs of video sites into the
embed / widget.

Example Code
------------

```php

require_once 'PATH/TO/Widgetfy/autoload.php';

use Phata\Widgetfy\Core as Widgetfy;

// simple setup
if (($embed = Widgetfy::translate($link)) != NULL) {
    echo $embed['html'];
}

// adjust all video to width 640px, if the source support that
$options = array('width'=>640);
if (($embed = Widgetfy::translate($link, $options)) != NULL) {
    echo $embed['html'];
}

```

For more detailed documentation, please visit our
[Documentation page on GitHub](https://github.com/Phata/Widgetfy/wiki/Documentation).


Branches
--------
Branch | Purpose          | Status
-------|------------------|----------------------------------------------------------------------------------
1.x    | Stable / Default | ![Travis Test Status](https://api.travis-ci.org/Phata/Widgetfy.svg?branch=1.x)  
master | Development      | ![Travis Test Status](https://api.travis-ci.org/Phata/Widgetfy.svg?branch=master)


Licence
-----------
This file is part of Widgetfy.

Widgetfy is free software: you can redistribute it and/or modify it under the
terms of the GNU Lesser General Public License as published by the Free
Software Foundation, either version 3 of the License, or (at your option) any
later version.

Widgetfy is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
A PARTICULAR PURPOSE.  See the GNU Lesser General Public Licensefor more
details.

You should have received a copy of the GNU Lesser General Public License along
with Widgetfy.  If not, see <http://www.gnu.org/licenses/lgpl.html>.
