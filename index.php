<?php
require_once("curl/curl.class.php");

$curl = new Curl("http://google.fr");
$curl->setOptionCurl();
echo $curl->getContentCurl();