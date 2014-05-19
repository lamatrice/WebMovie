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
    $q->closeCursor();
    foreach ($url as $key => $value) {
      //echo $url[$key]."\n";
      //echo $titre[$key];
      if (!in_array($value, $saveUrl)){
        $val = $this->_db->prepare('INSERT INTO robot(url, titre, description) VALUES(:url, :titre, :description)');
        $val->execute(array(
          'url' => $value,
          'titre' => $titre[$key],
          'description' => $description[$key]
          ));
        //echo 'DEja =>'.$value."\n";
      }
    }
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