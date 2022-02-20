<?php

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


$advertID = $_POST['idProduct'];
$login = $_POST['login'];
$par = $_POST['par'];
$checkFavorites;
$updateFavorites = isset($_SESSION['updateFavorites']) ? $_SESSION['updateFavorites'] : '';
$result;

$sql = "SELECT * FROM user WHERE login = '{$login}'";
foreach($dbh->query($sql) as $rows) { $result = $rows; }

if ($par) {
    $checkFavorites = array_filter(explode(",",$updateFavorites));
    $countCycle = count($checkFavorites);

    if(in_array($advertID, $checkFavorites)) {
        for($q = 0; $q < $countCycle; $q++) {
            if($advertID == $checkFavorites[$q]) unset($checkFavorites[$q]);
        }
        # Обновление в базе
        $sql = "UPDATE user SET favoritesAdvert = '{$checkFavorites}' WHERE login = '{$login}'";
        $dbh->query($sql);
        echo 'null';
        exit;
    }
}

# Если поле избранных содержит ID
if(!empty($result) && ($result['favoritesAdvert'] != '' || $result['favoritesAdvert'] != null || $result['favoritesAdvert'] != '-')) {

    $checkFavorites = array_filter(explode(",",$result['favoritesAdvert']));
    $countCycle = count($checkFavorites); // От 0
    
    # Если ид объявления найден в базе в спец. поле пользователя
    if(in_array($advertID, $checkFavorites)) {
        for($q = 0; $q < $countCycle; $q++) {

            # Пропускаем объявление (то есть убираем из базы)
            if($advertID == $checkFavorites[$q]) continue;
            
            # Запись новых данных
            $updateFavorites .= $checkFavorites[$q].',';
        }
        # Обновление в базе
        $sql = "UPDATE user SET favoritesAdvert = '{$updateFavorites}' WHERE login = '{$login}'";
        $dbh->query($sql);
        echo 'null';
    }
    # Если ид объявления не найден в базе в спец поле пользователя
    else {
        # Запись новых данных + обновление в базе
        $updateFavorites = ($result['favoritesAdvert'] == '' || $result['favoritesAdvert'] == null || $result['favoritesAdvert'] == '-') ? $advertID.',' : $result['favoritesAdvert'].''.$advertID.',';
        $sql = "UPDATE user SET favoritesAdvert = '{$updateFavorites}' WHERE login = '{$login}'";
        $dbh->query($sql);
        echo 'null';
    }
}
# Если после избранных не содержит ничего
else {
    # Запись новых данных + обновление в базе
    $updateFavorites = ($result['favoritesAdvert'] == '' || $result['favoritesAdvert'] == null || $result['favoritesAdvert'] == '-') ? $advertID.',' : $result['favoritesAdvert'].''.$advertID.',';
    $sql = "UPDATE user SET favoritesAdvert = '{$updateFavorites}' WHERE login = '{$login}'";
    $dbh->query($sql);
    echo 'add';
}
