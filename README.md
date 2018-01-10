# commonmark-ext

This is an extension to [thephpleague/commonmark](https://github.com/thephpleague/commonmark)

### Features
* Automatic Link Generation without <...> with generated titles from the webpage
    * `https://google.com/store` becomes `[Google Store](https://google.com/store)`
    * Supports all URL types
    * Automatic E-mail linking as well
* Strike-through support `~~strike this~~` looks like this: ~~strike this~~

### How to use
```php
<?php

require 'vendor/autoload.php';

$environment = \League\CommonMark\Environment::createCommonMarkEnvironment();
$environment->addExtension(new \OSSchools\Extensions\CommonMark\OSSchoolsCommonMarkExtension());

$converter = new \League\CommonMark\Converter(new \League\CommonMark\DocParser($environment), new \League\CommonMark\HtmlRenderer($environment));

$converter->convertToHtml("# Your Markdown Here");
```