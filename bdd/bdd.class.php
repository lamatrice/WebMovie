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

  public function addwp($titre, $url, $description, $id)
  {
    $saveUrl = array();
    $saveTitre = array();
    $q = $this->_db->prepare('SELECT ID FROM wp_posts WHERE (post_status=:publish OR post_status=:pending) AND post_type=:post');
    $q->execute(array(
      ':publish' => "publish",
      ':pending' => "pending",
      ':post' => "post"
      ));
    $q->setFetchMode(PDO::FETCH_OBJ);
    while( $tab = $q->fetch() ){
      //print_r($tab);
      $idYoutube[] = $this->getIdVideo($tab->ID);
    }
    //print_r(array_filter($idYoutube));
    $q->closeCursor();
    foreach ($id as $key => $value) {
      if (!in_array($value, $idYoutube)){

        // echo $titre[$key]."\n";
        // echo $description[$key]."\n";
        // echo $value."\n";
        // echo $id[$key]."\n";
        $saveTitre[] = $titre[$key];
        $val = $this->_db->prepare('INSERT INTO wp_posts(post_title,post_content,post_name,post_date,post_date_gmt,post_modified,post_modified_gmt,post_author,post_status) 
          VALUES(:post_title,:post_content,:post_name,:post_date,:post_date_gmt,:post_modified,:post_modified_gmt,:post_author,:post_status)');
        //print_r($val);
        $val->execute(array(
          'post_title' => $titre[$key],
          'post_content' => $description[$key],
          'post_name' => $titre[$key],
          'post_date' => date("Y-m-d H:i:s"),
          'post_date_gmt' => date("Y-m-d H:i:s"),
          'post_modified' => date("Y-m-d H:i:s"),
          'post_modified_gmt' => date("Y-m-d H:i:s"),
          'post_author' => 1,
          'post_status' => 'pending'
          ));
        $id_post = $this->_db->lastInsertId();
        $val = $this->_db->prepare('INSERT INTO wp_postmeta(post_id,meta_key,meta_value) 
          VALUES(:post_id,:meta_key,:meta_value)');
        $val->execute(array(
          'post_id' => $id_post,
          'meta_key' => 'id_youtube',
          'meta_value' => $value
          ));
       }
    }
    return $saveTitre;
  }

  public function putIdvideo($titre){
    //print_r($titre);

  }
  public function getIdVideo($id)
  {
    $q = $this->_db->query("SELECT * FROM wp_postmeta WHERE post_id=".$id." AND meta_key = 'id_youtube'");
    $res = $q->fetch(PDO::FETCH_ASSOC);
    //print_r($res);
    return ($res['meta_value']);
  }


  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }
}
?>