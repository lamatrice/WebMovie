<?php
require_once("curl/curl.class.php");
require_once("parser/parser.class.php");

$curl = new Curl("http://www.koreus.com/video/diabolo-avec-projections.html");
$curl->setOptionCurl();
$content = $curl->getContentCurl();
//echo $content;
$html = file_get_contents('site1.html');

$html = new ParserHtmlDom($html);
// $title = $html->getTitle("p", "itemText", null, 0, true);
// //print_r($title);
$listUrl = $html->getListUrl("p", "itemText", null, 0, "video");
print_r($listUrl);
// foreach($listUrl as $key => $href){
// 	if($key <= 3){
// 		echo $href;
// 	}
// }