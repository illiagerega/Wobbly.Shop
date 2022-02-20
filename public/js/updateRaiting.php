<?php

if($_POST['login'] == '' || $_POST['login'] == null || $_POST['login'] == 'undefined') return true;
//if($_COOKIE['raitingClick'] == $_POST['idProduct']) exit;

# Подключение к базе данных
$localhost = 'localhost';
$dbname = 'loveandl_main';
$username = 'loveandl_main';
$password = 'QvGXzkMuzAWXs6r';

try {
    $dbh = new PDO('mysql:host='.$localhost.';dbname='.$dbname.'', $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { echo 'error_connected';}


$dbh->query("SET NAMES utf8");
$dbh->query("SET CHARACTER SET utf8");
$dbh->query("SET character_set_client = utf8");
$dbh->query("SET character_set_connection = utf8");
$dbh->query("SET character_set_results = utf8");


$idProduct = $_POST['idProduct'];
$raiting = $_POST['raiting'];

switch($raiting) {
    case '_1':
        $sql = "SELECT * FROM product WHERE id = {$idProduct}";
        $row;
        foreach($dbh->query($sql) as $rows) { $row = $rows; }

        $row['negativeRaiting'] += 1;

        $sql = "UPDATE product SET negativeRaiting = {$row['negativeRaiting']} WHERE id = {$idProduct}";
        $dbh->query($sql);
        setcookie("raitingClick", $idProduct, time()+360000, '/');
        setcookie("raitingClick$idProduct", 1, time()+360000, '/');
        break;

    case '_2':
        $sql = "SELECT * FROM product WHERE id = {$idProduct}";
        $row;
        foreach($dbh->query($sql) as $rows) { $row = $rows; }

        $row['negativeRaiting'] += 2;

        $sql = "UPDATE product SET negativeRaiting = {$row['negativeRaiting']} WHERE id = {$idProduct}";
        $dbh->query($sql);
        setcookie("raitingClick", $idProduct, time()+360000, '/');
        setcookie("raitingClick$idProduct", 2, time()+360000, '/');
        break;

    case '_3':
        $sql = "SELECT * FROM product WHERE id = {$idProduct}";
        $row;
        foreach($dbh->query($sql) as $rows) { $row = $rows; }

        $row['positiveRaiting'] += 1;

        $sql = "UPDATE product SET positiveRaiting = {$row['positiveRaiting']} WHERE id = {$idProduct}";
        $dbh->query($sql);
        setcookie("raitingClick", $idProduct, time()+360000, '/');
        setcookie("raitingClick$idProduct", 3, time()+360000, '/');
        break;

    case '_4':
        $sql = "SELECT * FROM product WHERE id = {$idProduct}";
        $row;
        foreach($dbh->query($sql) as $rows) { $row = $rows; }

        $row['positiveRaiting'] += 2;

        $sql = "UPDATE product SET positiveRaiting = {$row['positiveRaiting']} WHERE id = {$idProduct}";
        $dbh->query($sql);
        setcookie("raitingClick", $idProduct, time()+360000, '/');
        setcookie("raitingClick$idProduct", 4, time()+360000, '/');
        break;

    case '_5':
        $sql = "SELECT * FROM product WHERE id = {$idProduct}";
        $row;
        foreach($dbh->query($sql) as $rows) { $row = $rows; }

        $row['positiveRaiting'] += 3;

        $sql = "UPDATE product SET positiveRaiting = {$row['positiveRaiting']} WHERE id = {$idProduct}";
        $dbh->query($sql);
        setcookie("raitingClick", $idProduct, time()+360000, '/');
        setcookie("raitingClick$idProduct", 5, time()+360000, '/');
        break;
}