<?php
require_once("curl/curl.class.php");
require_once("parser/parser.class.php");

$curl = new Curl("http://www.koreus.com/modules/news/");
$curl->setOptionCurl();
$html = $curl->getContentCurl();
// echo $html;
//$html = file_get_contents('site1.html');

$html = new ParserHtmlDom($html);
// $title = $html->getTitle("p", "itemText", null, 0, true);
// //print_r($title);
$listUrl = $html->getListUrl("p", "itemText", null, 0, "koreusity");
$fileVideo = array('saiyen.html','kangourou.html','diabolo.html');
$html->clean();
//print_r($listUrl);
foreach($listUrl as $key => $href){
	// if($key <= 3){
		//$html = file_get_contents($href);
		$curl = new Curl($href);
		$curl->setOptionCurl();
		$html = $curl->getContentCurl();
		$html = new ParserHtmlDom($html);
		echo $html->getTextWithContainer("div", null,"principal",0,"h1")."<br />"."\n";
		echo "Descriptif : " . $html->getTextWithContainer("div", null,"mediadescription",0,"p")."<br /><br />"."\n";
		$html->clean();
	// }
}