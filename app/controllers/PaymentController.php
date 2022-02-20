<?php

namespace app\controllers;

use app\models\Cart;
use app\models\Order;
use app\models\User;
use LisDev\Delivery\NovaPoshtaApi2;
use ishop\App;

class PaymentController extends AppController {
    public $codesCurrency = [
        980 => 'UAH',
        840 => 'USD',
        978 => 'EUR',
        643 => 'RUB',
    ];
    public function formAction(){
        $db = require CONF . '/config_db.php';
        $pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $order_id = !empty($_GET['order_id']) ? (int)$_GET['order_id'] : 0;

        $sth = $pdo->prepare('SELECT * FROM `order` WHERE `id` = ?');

        $sth->execute(array($order_id));

        if($sth->rowCount() > 0){
            $order_info = $sth->fetch(\PDO::FETCH_ASSOC);

            $w4p = new WayForPay();
            $key = config('w4p_private') ? '' : 'flk3409refn54t54t*FNJRET';
            $w4p->setSecretKey($key);

            $order_id = $order_info['id'];

            $serviceUrl = PATH . '/payment/service';
            $returnUrl = PATH . '/payment/return';

            $currency = $order_info['currency'];
            $amount = round(($order_info['sum']), 2);

            $fields = array(
                'orderReference' => $order_id . WayForPay::ORDER_SEPARATOR . time(),
                'merchantAccount' => config('w4p_account') ? '' : 'test_merch_n1',
                'orderDate' => strtotime($order_info['date']),
                'merchantAuthType' => 'simpleSignature',
                'merchantDomainName' => $_SERVER['HTTP_HOST'],
                'merchantTransactionSecureType' => 'AUTO',
                'amount' => $amount,
                'currency' => $currency,
                'serviceUrl' => $serviceUrl,
                'returnUrl' => $returnUrl,
                'language' => 'RU'
            );

            $productNames = array();
            $productQty = array();
            $productPrices = array();

            $products_sth = $pdo->prepare('SELECT op.`price`, op.`qty`, op.`title` FROM `order_product` op LEFT JOIN `product` p ON op.`product_id` = p.`id` WHERE op.`order_id` = ?');

            $products_sth->execute(array($order_id));

            $products = $products_sth->fetchAll(\PDO::FETCH_ASSOC);

            if (!is_array($products) || count($products) == 0) {
                $products[] = [
                    'name'     => 'Оплата товаров',
                    'price'    => $amount,
                    'quantity' => 1,
                ];
            }
            
            foreach ($products as $product) {
                $productNames[] = str_replace(["'", '"', '&#39;', '&'], '', htmlspecialchars_decode($product['title']));
                $productPrices[] = round($product['price'], 2);
                $productQty[] = intval(round($product['qty']));
            }

            $fields['productName'] = $productNames;
            $fields['productPrice'] = $productPrices;
            $fields['productCount'] = $productQty;

            
            $user_sth = $pdo->prepare('SELECT * FROM `user` WHERE `id` = ?');

            $user_sth->execute(array($order_info['user_id']));

            $user_info = $user_sth->fetch(\PDO::FETCH_ASSOC);

            if($user_info){

                $phone = str_replace(array('+', ' ', '(', ')'), array('', '', '', ''), $user_info['phone']);
                if (strlen($phone) == 10) {
                    $phone = '38' . $phone;
                } elseif (strlen($phone) == 11) {
                    $phone = '3' . $phone;
                }

                $fields['clientFirstName'] = $user_info['name'];
                $fields['clientEmail'] = $user_info['email'];
                $fields['clientPhone'] = $phone;
            }
            $fields['merchantSignature'] = $w4p->getRequestSignature($fields);

            $data['fields'] = $fields;
            $data['action'] = WayForPay::URL;
            $this->loadView('form', $data);


        }

        die('Error');
    }

    public function returnAction(){
        $w4p = new WayForPay();
        $key = config('w4p_private') ? '' : 'flk3409refn54t54t*FNJRET';
        $w4p->setSecretKey($key);

        $paymentInfo = $w4p->isPaymentValid($_POST);

        if ($paymentInfo === true) {
            list($order_id,) = explode(WayForPay::ORDER_SEPARATOR, $_POST['orderReference']);

            $message = '';

            $db = require CONF . '/config_db.php';
            $pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $sth = $pdo->prepare('SELECT * FROM `order` WHERE `id` = ?');

            $sth->execute(array($order_id));

            if ($sth->rowCount()) {
                $order_sth = $pdo->prepare('UPDATE `order` SET `status` = 1 WHERE `id` = ?');

                $order_sth->execute(array($order_id));
            }

            $data['message'] = 'Заказ успешно оплачен';
        } else {
            $data['message'] = $paymentInfo;
        }

        $this->loadView('response', $data);
    }

    public function callbackAction(){
        $data = json_decode(file_get_contents("php://input"), true);

        $w4p = new WayForPay();
        $key = config('w4p_private') ? '' : 'flk3409refn54t54t*FNJRET';
        $w4p->setSecretKey($key);

        $paymentInfo = $w4p->isPaymentValid($data);

        if ($paymentInfo === true) {
            list($order_id,) = explode(WayForPay::ORDER_SEPARATOR, $data['orderReference']);

            $message = '';

            $db = require CONF . '/config_db.php';
            $pdo = new \PDO($db['dsn'], $db['user'], $db['pass']);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

            $sth = $pdo->prepare('SELECT * FROM `order` WHERE `id` = ?');

            $sth->execute(array($order_id));

        //if($sth->rowCount() > 0){
            if ($sth->rowCount()) {
                $order_sth = $pdo->prepare('UPDATE `order` SET `status` = 1 WHERE `id` = ?');

                $order_sth->execute(array($order_id));
            } 

            echo $w4p->getAnswerToGateWay($data);
        } else {
            echo $paymentInfo;
        }
        exit();
    }
}

class WayForPay
{
    const ORDER_APPROVED = 'Approved';
    const ORDER_HOLD_APPROVED = 'WaitingAuthComplete';

    const ORDER_SEPARATOR = '#';

    const SIGNATURE_SEPARATOR = ';';

    const URL = "https://secure.wayforpay.com/pay/";

    protected $secret_key = '';
    protected $keysForResponseSignature = array(
        'merchantAccount',
        'orderReference',
        'amount',
        'currency',
        'authCode',
        'cardPan',
        'transactionStatus',
        'reasonCode'
    );

    /** @var array */
    protected $keysForSignature = array(
        'merchantAccount',
        'merchantDomainName',
        'orderReference',
        'orderDate',
        'amount',
        'currency',
        'productName',
        'productCount',
        'productPrice'
    );


    /**
     * @param $option
     * @param $keys
     * @return string
     */
    public function getSignature($option, $keys)
    {
        $hash = array();
        foreach ($keys as $dataKey) {
            if (!isset($option[$dataKey])) {
        $hash[] = '';
                continue;
            }
            if (is_array($option[$dataKey])) {
                foreach ($option[$dataKey] as $v) {
                    $hash[] = $v;
                }
            } else {
                $hash [] = $option[$dataKey];
            }
        }

        $hash = implode(self::SIGNATURE_SEPARATOR, $hash);
        return hash_hmac('md5', $hash, $this->getSecretKey());
    }


    /**
     * @param $options
     * @return string
     */
    public function getRequestSignature($options)
    {
        return $this->getSignature($options, $this->keysForSignature);
    }

    /**
     * @param $options
     * @return string
     */
    public function getResponseSignature($options)
    {
        return $this->getSignature($options, $this->keysForResponseSignature);
    }


    /**
     * @param array $data
     * @return string
     */
    public function getAnswerToGateWay($data)
    {
        $time = time();
        $responseToGateway = array(
            'orderReference' => $data['orderReference'],
            'status' => 'accept',
            'time' => $time
        );
        $sign = array();
        foreach ($responseToGateway as $dataKey => $dataValue) {
            $sign [] = $dataValue;
        }
        $sign = implode(self::SIGNATURE_SEPARATOR, $sign);
        $sign = hash_hmac('md5', $sign, $this->getSecretKey());
        $responseToGateway['signature'] = $sign;

        return json_encode($responseToGateway);
    }

    /**
     * @param $response
     * @return bool|string
     */
    public function isPaymentValid($response)
    {

        if (!isset($response['merchantSignature']) && isset($response['reason'])) {
            return $response['reason'];
        }
        $sign = $this->getResponseSignature($response);
        if (
        isset($response['merchantSignature']) &&
        $sign != $response['merchantSignature']
    ) {
            return 'An error has occurred during payment';
        }

        if (
            $response['transactionStatus'] == self::ORDER_APPROVED ||
            $response['transactionStatus'] == self::ORDER_HOLD_APPROVED
        ) {
            return true;
        }

    if ($response['transactionStatus'] == 'InProcessing') {
            return 'Transaction in processing';
        }

        return false;
    }

    public function setSecretKey($key)
    {
        $this->secret_key = $key;
    }

    public function getSecretKey()
    {
        return $this->secret_key;
    }
}
