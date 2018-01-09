<?php

include 'vendor/autoload.php';

$environment = \League\CommonMark\Environment::createCommonMarkEnvironment();
$environment->addExtension(new \OSSchools\Extensions\CommonMark\OSSchoolsCommonMarkExtension());

$converter = new \League\CommonMark\Converter(new \League\CommonMark\DocParser($environment), new \League\CommonMark\HtmlRenderer($environment));

echo $converter->convertToHtml("Test" . PHP_EOL . "```php" . PHP_EOL . "public function google() {" . PHP_EOL . "    return true;" . PHP_EOL . "}" . PHP_EOL . "```" . PHP_EOL . "https://google.com/store [Rhodes](https://rhodes.ml)");