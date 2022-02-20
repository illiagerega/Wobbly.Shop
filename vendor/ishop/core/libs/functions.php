<?php

function debug($arr, $die = false){
    echo '<pre>' . print_r($arr, true) . '</pre>';
    if($die) die;
}

function redirect($http = false){
    if($http){
        $redirect = $http;
    }else{
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : PATH;
    }
    header("Location: $redirect");
    exit;
}

function h($str){
    return htmlspecialchars($str, ENT_QUOTES);
}

function config($key) {
    $db = require CONF . '/config_db.php';
    $pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);

    $sth = $pdo->prepare('SELECT * FROM `setting` WHERE `key` = ?');

    $sth->execute(array($key));

    if($sth->rowCount() > 0){
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        return $result['value'];
    }

    return false;
}