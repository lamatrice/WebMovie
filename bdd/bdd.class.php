<?php
class BddManager
{
  private $_db; // Instance de PDO.

  public function __construct($db)
  {
    $this->setDb($db);
  }

  public function add($titre, $description, $url)
  {
    $saveUrl = array();
    $q = $this->_db->query('SELECT * FROM robot');
    $q->setFetchMode(PDO::FETCH_OBJ);
    while( $tab = $q->fetch() ){
      $saveUrl[] = $tab->url;
    }
    foreach ($titre as $key => $value) {
      if (in_array($url[$key], $saveUrl)){
        // INSERTION SQL $url[$key]
        echo "";
      }
    }
    $q->closeCursor();
    return '';
  }

  public function get($id)
  {
  }


  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}
?>