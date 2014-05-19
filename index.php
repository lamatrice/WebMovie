<?php
require_once("curl/curl.class.php");
require_once("parser/parser.class.php");
require_once("bdd/bdd.class.php");

$curl = new Curl("http://www.koreus.com/videos/nouveau/");
$curl->setOptionCurl();
$html = $curl->getContentCurl();

$html = new ParserHtmlDom($html);
$titre = array();
$description = array();
$url = array();
$categorie = $html->getCategorie("nouveau");
$html->clean();
//print_r($categorie);
foreach($categorie as $key => $cat){
	$curl = new Curl('http://www.koreus.com'.$cat);
	$curl->setOptionCurl();
	$html = $curl->getContentCurl();
	$html = new ParserHtmlDom($html);
	$listUrl = $html->getListUrl("div", "thumbnail", null, 0, "koreusity");
	//print_r($listUrl);
	$html->clean();
	foreach($listUrl as $key => $href){
		if($key < 22){
			$curl = new Curl('http://www.koreus.com'.$href);
			$curl->setOptionCurl();
			$html = $curl->getContentCurl();
			$html = new ParserHtmlDom($html);
			if ($html->getUrlVideo("youtube") != NULL){
				//echo $html->getTextWithContainer("div", null,"principal",0,"h1")."\n";
				//echo $html->getUrlVideo("youtube")."\n";
				$titre[] = $html->getTextWithContainer("div", null,"principal",0,"h1");
				$url[] = $html->getUrlVideo("youtube");
				$description[] = $html->getTextWithContainer("div", null,"mediadescription",0,"p");
			}
			$html->clean();
		}
	}
}

$titre = array_unique($titre);
$description = array_unique($description);
$url = array_unique($url);

$db = new PDO('mysql:host=localhost;dbname=wpvideo', 'root', 'counter');
$manager = new BddManager($db);
$manager->add($titre, $description, $url);
//$manager->add(array('saddas'), array('dasas'), array('http://www.youtube.com/watch?v=asdas'));