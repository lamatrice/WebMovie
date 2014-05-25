<?php
require_once("curl/curl.class.php");
require_once("parser/parser.class.php");
require_once("bdd/bdd.class.php");

$curl = new Curl("http://www.koreus.com/videos/nouveau/");
$curl->setOptionCurl();
$html = $curl->getContentCurl();

$titre = array();
$description = array();
$url = array();
$id = array();
$html = new ParserHtmlDom($html);
$categorie = $html->getCategorie("nouveau");
$html->clean();
//print_r($categorie);
foreach($categorie as $keys => $cat){
		$listUrl = array();
		$curl = new Curl('http://www.koreus.com'.$cat);
		$curl->setOptionCurl();
		$html = $curl->getContentCurl();
		$html = new ParserHtmlDom($html);
		$listUrl = $html->getListUrl("div", "thumbnail", null, 0, "koreusity");
		//print_r($listUrl);
		$html->clean();
		foreach($listUrl as $key => $href){
			if($key < 23){
				$curl = new Curl('http://www.koreus.com'.$href);
				$curl->setOptionCurl();
				$html = $curl->getContentCurl();
				$html = new ParserHtmlDom($html);
				if ($html->getUrlVideo("youtube") != NULL){
					//echo $html->getTextWithContainer("div", null,"principal",0,"h1")."\n";
					//echo $html->getUrlVideo("youtube")."\n";
					$titre[] = $html->getTextWithContainer("div", null,"principal",0,"h1");
					$url[] = $html->getUrlVideo("youtube");
					$description[] = str_replace('Description : ', '',$html->getTextWithContainer("div", null,"mediadescription",0,"p"));
					$pars = $html->getUrlVideo("youtube");
					parse_str( parse_url( $pars, PHP_URL_QUERY ), $my_array_of_vars );
					$id[] = $my_array_of_vars['v'];
				}
				$html->clean();
			}
		}
}

$titre = array_unique($titre);
$description = array_unique($description);
$url = array_unique($url);
$id = array_unique($id);

$db = new PDO('mysql:host=localhost;dbname=wpvideo', 'root', 'counter');
$manager = new BddManager($db);
$saveTitre = $manager->addwp($titre, $url, $description, $id);
$manager->putIdvideo($saveTitre);