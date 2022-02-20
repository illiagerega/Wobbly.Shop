<?php

namespace app\controllers\admin;
use ishop\App;

class BannerController extends AppController {

    public function indexAction(){
        $db = require CONF . '/config_db.php';
        $pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);

        $result = $pdo->query("SELECT * FROM `home_banner_items`");

        $data = $result->fetchAll(\PDO::FETCH_ASSOC);

        $items = [];

        if($data){
            foreach($data as $row){
                $items[] = $row;
            }
        }

        $this->setMeta('Настройки сайта');
        $this->set(['items' => $items]);
    }

    public function saveAction(){
        if(!empty($_POST['item']) && is_array($_POST['item'])){
            $items = $_POST['item'];
        }else{
            $items = array();
        }

        $db = require CONF . '/config_db.php';
        $pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);

        $pdo->query("DELETE FROM `home_banner_items`");

        $sth = $pdo->prepare('INSERT INTO `home_banner_items` SET `title` = ?, `link` = ?, `image` = ?, `button` = ?');
        
        foreach($items as $key => $item){
            $image = '';

            if(!empty($_FILES['item']["name"][$key]['image'])){
                if($_FILES['item']["error"][$key]['image'] == UPLOAD_ERR_OK){
                    $tmp_name = $_FILES["item"]["tmp_name"][$key]['image'];
                    $old_name = basename($_FILES["item"]["name"][$key]['image']);
                    $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $old_name));
                    $new_name = md5($old_name . time()) . "." . $ext;
                    move_uploaded_file($tmp_name, WWW . "/images/" . $new_name);

                    $image = $new_name;
                }

                
            }

            if(!$image && !empty($item['file_old'])){
                $image = $item['file_old'];
            }

            $sth->execute(array(
                $item['title'], 
                $item['link'],
                $image,
                $item['button']
            )); 
            /**/
        }


        $_SESSION['success'] = 'Изменения сохранены';
            
        redirect();
    }
}