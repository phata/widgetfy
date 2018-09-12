# Widgetfy

[![Travis Test Status][ci-badge]][ci-branches-url] [![stable-version-badge]][packagist-url] [![license-badge]][packagist-url] [![download-badge]][packagist-url]

[stable-version-badge]: https://poser.pugx.org/phata/widgetfy/v/stable
[license-badge]: https://poser.pugx.org/phata/widgetfy/license
[download-badge]: https://poser.pugx.org/phata/widgetfy/downloads
[packagist-url]: https://packagist.org/packages/phata/widgetfy

**Widgetfy** is a PHP library to translate URLs of video sites into the
embed / widget.

Install
-------

First, install [composer] to your development platform.

Then run this in your project folder:

```shell
composer require phata/widgetfy
```

[composer]: https://getcomposer.org/download/

Example Code
------------

```php

// require the composer autoload script
require_once './vendor/autoload.php';

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

// using the default theme, and inlining the default CSS
// along with the first embed code.
echo Phata\Widgetfy\Theme::toHTML($embed, true);

```

For more detailed documentation, please visit our
[Documentation page on GitLab](https://gitlab.com/phata/widgetfy/wikis/Documentation).


Branches
--------

Branch | Purpose          | PHP Version       | Status
-------|------------------|-------------------|----------------------------------------
2.x    | Stable / Default | 7.1, 7.2          | [![Travis Test Status][ci-badge-2.x]][ci-branches-url]
1.x    | Maintenance      | 5.3, 5.4 5.5, 5.6 | [![Travis Test Status][ci-badge-1.x]][ci-branches-url]
master | Development      | 7.1, 7.2          | [![Travis Test Status][ci-badge]][ci-branches-url]

[ci-badge-2.x]: https://gitlab.com/phata/widgetfy/badges/2.x/build.svg
[ci-badge-1.x]: https://gitlab.com/phata/widgetfy/badges/1.x/build.svg
[ci-badge]: https://gitlab.com/phata/widgetfy/badges/master/build.svg
[ci-branches-url]: https://gitlab.com/phata/widgetfy/pipelines?scope=branches&page=1

License
-------

This file is part of Widgetfy.

Widgetfy is free software: you can redistribute it and/or modify it under the
terms of the GNU Lesser General Public License as published by the Free
Software Foundation, either version 3 of the License, or (at your option) any
later version.

Widgetfy is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
A PARTICULAR PURPOSE.  See the GNU Lesser General Public Licensefor more
details.

You should have received [a copy](LICENSE) of the GNU Lesser General Public License along
with Widgetfy.  If not, see <http://www.gnu.org/licenses/lgpl.html>.
