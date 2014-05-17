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
		$title = "";
		if(!empty($balise)){
			$option = $balise;
			if(!empty($class)){
				$option .= '[class='.$class.']';
			}else if(!empty($id)){
				$option .= '[id='.$id.']';
			}
		}

		if($list == false){
			return $this->_html->find($option, 0)->children($child)->plaintext;
		}else{
			foreach($this->_html->find($option) as $name){
				$title[] = utf8_encode($name->children($child)->plaintext)."\n";
			}
			return $title;
		}
	}

	function getText($balise, $class, $id){
		return "";
	}

	function getUrlImg($balise, $class, $id){
		return "";
	}

	function splitUrl(){

	}

	function Init($content){
		return $this->_html = str_get_html($content, true, true, DEFAULT_TARGET_CHARSET, false, DEFAULT_BR_TEXT, DEFAULT_SPAN_TEXT);
	}
}