<?php

include 'vendor/autoload.php';

$environment = \League\CommonMark\Environment::createCommonMarkEnvironment();
$environment->addExtension(new \OSSchools\Extensions\CommonMark\OSSchoolsCommonMarkExtension());

$converter = new \League\CommonMark\Converter(new \League\CommonMark\DocParser($environment), new \League\CommonMark\HtmlRenderer($environment));

echo $converter->convertToHtml('# Awesome Stuff [Happens Here](https://rhodes.ml) but ~~not cool~~ https://google.com');