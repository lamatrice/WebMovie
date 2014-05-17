<?php
include "simple-html/simple_html_dom.php";

/**
* 
*/
class ParserHtmlDom
{
	private $_html;

	function __construct($content)
	{
		return $this->Init($content);
	}

	/**
	* Balise => h1, h2, div etc...
	* Class => Nom de la class dans la balise
	* Div => Nom de la div dans la balise
	* Child => la postion de l'enfant dans la div (premier element = 0)
	* List => si il n'y a qu'un seule titre dans la page $list == false => <string> Sinon Array avec tous les titres
	*/
	function getTitle($balise = null, $class = null, $id = null, $child = 0, $list = true){
		$title = null;
		$option = null;
		if(!empty($balise)){
			$option = $balise;
			if(!empty($class)){
				$option .= '[class='.$class.']';
			}else if(!empty($id)){
				$option .= '[id='.$id.']';
			}
		}

		if($list == false){
			if ($child == 1)
				return utf8_encode($this->_html->find($option, 0)->children($child)->plaintext);
			else
				return utf8_encode($this->_html->find($option, 0)->plaintext);
		}else{
			foreach($this->_html->find($option) as $name){
				$title[] = utf8_encode($name->children($child)->plaintext)."\n";
			}
			return $title;
		}
	}

	/**
	* Balise => h1, h2, div etc...
	* Class => Nom de la class dans la balise
	* Div => Nom de la div dans la balise
	* Child => Position de la la balise a dans le conteneur
	* Contain => Mot qui est contenu dans l'url
	*/
	function getListUrl($balise = null, $class = null, $id = null, $child = 0, $contain = null){
		$href = null;
		$option = null;
		if(!empty($balise)){
			$option = $balise;
			if(!empty($class)){
				$option .= '[class='.$class.']';
			}else if(!empty($id)){
				$option .= '[id='.$id.']';
			}
		}
		foreach($this->_html->find($option) as $name){
			if (strpos($name->find("a", $child)->href, $contain) == false)
				$href[] = $name->find("a", $child)->href;
		}
		return $href;
	}

	function getTextWithContainer($baliseContainer = null, $class = null, $id = null, $child = 0, $balise = null){
		$href = null;
		$option = null;
		if(!empty($baliseContainer)){
			$option = $baliseContainer;
			if(!empty($class)){
				$option .= '[class='.$class.']';
			}else if(!empty($id)){
				$option .= '[id='.$id.']';
			}
		}
		return utf8_encode($this->_html->find($option." ".$balise, $child)->plaintext);
	}

	function getUrlImg($balise, $class, $id){
		return "";
	}
	function getUrlVideo(){
		return $this->_html->find("div[class=blockContent] ul", 4)->children(1)->children(0)->href;
		
	}

	function splitUrl(){

	}

	function clean(){
		$this->_html->clear();
		unset($this->_html);
	}

	function Init($content){
		return $this->_html = str_get_html($content, true, true, DEFAULT_TARGET_CHARSET, false, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
	}
}