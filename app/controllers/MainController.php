<?php

namespace app\controllers;

use ishop\Cache;
use ishop\libs\TurboSMS;

class MainController extends AppController {

    public function indexAction(){
        $brands = \R::find('brand', 'LIMIT 3');
        $hits = \R::find('product', "hit = '1' AND status = '1' LIMIT 8");
        $novinki = \R::find('product', "novinki = '1' AND status = '1' LIMIT 8");
        $canonical = PATH;

        $db = require CONF . '/config_db.php';
        $pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);


        $results = $pdo->query('SELECT * FROM `home_banner_items`');

        $banners = $results->fetchAll(\PDO::FETCH_ASSOC);

        $this->setMeta('Головна сторінка', 'Опис...', 'Ключевик...');
        $this->set(compact('brands', 'hits', 'novinki', "canonical", "banners"));
    }


}