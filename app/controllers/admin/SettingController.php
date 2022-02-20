<?php

namespace app\controllers\admin;

class SettingController extends AppController {

    public function indexAction(){
        $db = require CONF . '/config_db.php';
        $pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);

        $result = $pdo->query("SELECT * FROM `setting` WHERE `key` IN('banner_title', 'banner_text', 'banner_image', 'banner_href', 'site_colour', 'site_logo', 'footer_facebook', 'footer_twitter', 'footer_google')");

        $data = $result->fetchAll(\PDO::FETCH_ASSOC);

        $return = [];

        if($data){
            foreach($data as $row){
                $return[$row['key']] = $row['value'];
            }
        }

        $this->setMeta('Настройки сайта');
        $this->set($return);
    }

    public function saveAction(){
        if(!empty($_POST['site_colour'])){
            $site_colour = $_POST['site_colour'];
        }else{
            $site_colour = 'blue';
        }

        if(!empty($_POST['footer_facebook'])){
            $footer_facebook = $_POST['footer_facebook'];
        }else{
            $footer_facebook = '';
        }

        if(!empty($_POST['footer_twitter'])){
            $footer_twitter = $_POST['footer_twitter'];
        }else{
            $footer_twitter = '';
        }

        if(!empty($_POST['footer_google'])){
            $footer_google = $_POST['footer_google'];
        }else{
            $footer_google = '';
        }

        if(!empty($_POST['np_api'])){
            $np_api = $_POST['np_api'];
        }else{
            $np_api = '';
        }

        if(!empty($_POST['turbosms_sender'])){
            $turbosms_sender = $_POST['turbosms_sender'];
        }else{
            $turbosms_sender = '';
        }

        if(!empty($_POST['turbosms_api'])){
            $turbosms_api = $_POST['turbosms_api'];
        }else{
            $turbosms_api = '';
        }

        if(!empty($_POST['w4p_private'])){
            $w4p_private = $_POST['w4p_private'];
        }else{
            $w4p_private = '';
        }

        if(!empty($_POST['w4p_account'])){
            $w4p_account = $_POST['w4p_account'];
        }else{
            $w4p_account = '';
        }

        if(!empty($_POST['percent'])){
            $percent = $_POST['percent'];
        }else{
            $percent = '';
        }

        if(!empty($_FILES['site_logo'])){
            $site_logo = '';
            
            if($_FILES['site_logo']["error"] == UPLOAD_ERR_OK){
                $tmp_name = $_FILES["site_logo"]["tmp_name"];
                $name = basename($_FILES["site_logo"]["name"]);

                move_uploaded_file($tmp_name, WWW . "/images/" . $name);

                $site_logo = $name;
            }
        }else{
            $site_logo = '';
        }

        $db = require CONF . '/config_db.php';
        $pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);

        $pdo->query("DELETE FROM `setting` WHERE `key` IN('np_api', 'turbosms_sender', 'turbosms_api', 'w4p_private', 'w4p_account', 'banner_title', 'banner_text', 'banner_href', 'site_colour', 'footer_facebook', 'footer_twitter', 'footer_google', 'percent')");

        $sth = $pdo->prepare('INSERT INTO `setting` SET `key` = ?, `value` = ?');

        $sth->execute(array('site_colour', $site_colour));
        $sth->execute(array('footer_facebook', $footer_facebook));
        $sth->execute(array('footer_twitter', $footer_twitter));
        $sth->execute(array('footer_google', $footer_google));
        $sth->execute(array('np_api', $_POST['np_api']));
        $sth->execute(array('turbosms_sender', $_POST['turbosms_sender']));
        $sth->execute(array('turbosms_api', $_POST['turbosms_api']));
        $sth->execute(array('w4p_private', $_POST['w4p_private']));
        $sth->execute(array('w4p_account', $_POST['w4p_account']));
        $sth->execute(array('percent', $_POST['percent']));

        
        if($site_logo){
            $pdo->query("DELETE FROM `setting` WHERE `key` = 'site_logo'");

            $sth->execute(array('site_logo', $site_logo)); 
        }

        $_SESSION['success'] = 'Изменения сохранены';
            
        redirect();
    }
}