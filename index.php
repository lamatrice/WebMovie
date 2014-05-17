<?php
require_once("curl/curl.class.php");
require_once("parser/parser.class.php");

// $curl = new Curl("http://www.koreus.com/modules/news/");
// $curl->setOptionCurl();
// $content = $curl->getContentCurl();
// echo $content;
$html = file_get_contents('site1.html');

$html = new ParserHtmlDom($html);
$title = $html->getTitle("h1", "itemTitle", null, 1, true);
print_r($title);