<?php

namespace app\controllers\admin;


use ishop\libs\Pagination;
use ishop\libs\TurboSMS;

class OrderController extends AppController {

    public function indexAction(){
//        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
//        $perpage = 3;
//        $count = \R::count('order');
//        $pagination = new Pagination($page, $perpage, $count);
//        $start = $pagination->getStart();

        if(isset($_GET['date1']) && isset($_GET['date2'])) {
            $date1 = $_GET['date1'];
            $date2 = $_GET['date2'];
            $orders = \R::getAll("SELECT `order`.`id`, `order`.`user_id`, `order`.`status`, `order`.`date`, `order`.`update_at`, `order`.`currency`, `user`.`name`, ROUND(SUM(`order_product`.`price` * `order_product`.`qty`), 2) AS `sum` FROM `order`
  JOIN `user` ON `order`.`user_id` = `user`.`id`
  JOIN `order_product` ON `order`.`id` = `order_product`.`order_id`
  WHERE `order`.`date` BETWEEN :date1 AND :date2 GROUP BY `order`.`id` ORDER BY `order`.`status`, `order`.`id`", ['date1' => $date1, 'date2' => $date2]);
        } else {
            $orders = \R::getAll("SELECT `order`.`id`, `order`.`user_id`, `order`.`status`, `order`.`date`, `order`.`update_at`, `order`.`currency`, `user`.`name`, ROUND(SUM(`order_product`.`price` * `order_product`.`qty`), 2) AS `sum` FROM `order`
  JOIN `user` ON `order`.`user_id` = `user`.`id`
  JOIN `order_product` ON `order`.`id` = `order_product`.`order_id`
  GROUP BY `order`.`id` ORDER BY `order`.`status`, `order`.`id`");
        }
        $this->setMeta('Список заказов');
        $this->set(compact('orders', 'pagination', 'count'));
    }

    public function viewAction(){
        $order_id = $this->getRequestID();
        $order = \R::getRow("SELECT `order`.*, `user`.`phone`, `user`.`name`, ROUND(SUM(`order_product`.`price` * `order_product`.`qty`), 2) AS `sum` FROM `order`
  JOIN `user` ON `order`.`user_id` = `user`.`id`
  JOIN `order_product` ON `order`.`id` = `order_product`.`order_id`
  WHERE `order`.`id` = ?
  GROUP BY `order`.`id` ORDER BY `order`.`status`, `order`.`id` LIMIT 1", [$order_id]);
        if(!$order){
            throw new \Exception('Страница не найдена', 404);
        }
        $order_products = \R::findAll('order_product', "order_id = ?", [$order_id]);
        $this->setMeta("Заказ №{$order_id}");
        $this->set(compact('order', 'order_products'));
    }

    public function changeAction(){
        $order_id = $this->getRequestID();
        $status = $_GET['status']? 2:1;
        $order = \R::load('order', $order_id);
        $user = \R::load('user', $order->user_id);
        if(!$order){
            throw new \Exception('Страница не найдена', 404);
        }
        $order->status = $status;
        $order->update_at = date("Y-m-d H:i:s");
        $ttn = $order->ttn;
        \R::store($order);
        $_SESSION['success'] = 'Изменения сохранены';
        if($_GET['status'] && !empty($ttn)) {
            $sms = new TurboSMS(TURBOSMS_API, TURBOSMS_SENDER);
            $sms->sendSMS($user->phone, "Ваш заказ принят. ТТН ".$ttn);
        }
        redirect();
    }

    public function deleteAction(){
        $order_id = $this->getRequestID();
        $order = \R::load('order', $order_id);
        \R::trash($order);
        $_SESSION['success'] = 'Заказ удален';
        redirect(ADMIN . '/order');
    }

    public function statisticsAction() {
        if($_GET['date_from'] && $_GET['date_to']){
            $date =  date('Y-m-d', strtotime($_GET['date_to'].'+1 day'));
            switch($_GET['status']){
                case 0:
                    $str = " AND `status` = '0'";
                    break;
                case 1:
                    $str = " AND `status` = '1'";
                    break;
                default:
                    $str = '';
                    break;
            }
            $sql = 'SELECT * FROM `order` WHERE `date` BETWEEN "'.$_GET['date_from'].'" AND "'.$date.'"'.$str;
            $array =  \R::getAll($sql);
            $data = [];
            for($i = $_GET['date_from']; strtotime($i) < strtotime($_GET['date_to']); $i = date('Y-m-d', strtotime($i.' +1 day'))){
                $data[$i][0] = 0;
                $data[$i][1] = 0;
            }
            foreach($array as $row){
                $data[date('Y-m-d', strtotime($row['date']))][$row['status']] += 1;
            }
            $this->set(compact('data'));
        }
        $this->setMeta('Статистика');
    }

    public function ttnAction() {
        $order_id = $this->getRequestID();
        $order = \R::load('order', $order_id);
        $order->ttn = $_GET['ttn'];
        \R::store($order);
        redirect(ADMIN . '/order');
    }
}