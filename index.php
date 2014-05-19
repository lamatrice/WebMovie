<?php
require_once("curl/curl.class.php");
require_once("parser/parser.class.php");
require_once("bdd/bdd.class.php");

$curl = new Curl("http://www.koreus.com/videos/nouveau/");
$curl->setOptionCurl();
$html = $curl->getContentCurl();
// echo $html;
//$html = file_get_contents('site1.html');

$html = new ParserHtmlDom($html);
$titre = array();
$description = array();
$url = array();
$listUrl = $html->getListUrl("div", "thumbnail", null, 0, "koreusity");
$fileVideo = array('saiyen.html','kangourou.html','diabolo.html');
$html->clean();
foreach($listUrl as $key => $href){
	if($key < 22){
		$curl = new Curl('http://www.koreus.com'.$href);
		$curl->setOptionCurl();
		$html = $curl->getContentCurl();
		$html = new ParserHtmlDom($html);
		if ($html->getUrlVideo("youtube") != NULL){
			echo $html->getTextWithContainer("div", null,"principal",0,"h1")."\n";
			echo $html->getUrlVideo("youtube")."\n";
			$titre[] = $html->getTextWithContainer("div", null,"principal",0,"h1");
			$url[] = $html->getUrlVideo("youtube");
			$description[] = $html->getTextWithContainer("div", null,"mediadescription",0,"p");
		}
		$html->clean();
	}
}


$db = new PDO('mysql:host=localhost;dbname=wpvideo', 'root', 'counter');
$manager = new BddManager($db);
$manager->add($titre, $description, $url);