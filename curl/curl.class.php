<?php

/**
* 
*/
class Curl
{
	private $_url;

	function __construct($url) {
		return $this->setCurlInit($url);	
	}

	function setCurlInit($url) {
		return $this->_url = curl_init($url);
	}

	function setOptionCurl(){
		curl_setopt($this->_url, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->_url, CURLOPT_FOLLOWLOCATION, true);
	}

	function getContentCurl(){
		$content = curl_exec($this->_url);
		curl_close($this->_url);
		return $content;
	}
}