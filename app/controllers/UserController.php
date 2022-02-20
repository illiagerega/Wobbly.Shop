<?php

namespace app\controllers;

use app\models\User;
use ishop\App;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class UserController extends AppController {

    public function signupAction(){
        if(!empty($_POST)){
            $user = new User();
            $data = $_POST;
            $user->load($data);
            if(!$user->validate($data) || !$user->checkUnique()){
                $user->getErrors();
                $_SESSION['form_data'] = $data;
            }else{
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                if($user->save('user')){
                    $_SESSION['success'] = 'Користувач зареєстрований';
                }else{
                    $_SESSION['error'] = 'Помилка!';
                }
            }
            redirect();
        }
        $this->setMeta('Реєстрація');
    }

    public function loginAction(){
        if(!empty($_POST)){
            $user = new User();
            if($user->login()){
                $_SESSION['success'] = 'Ви успішно авторизувались';
                redirect("/user/cabinet");
            }else{
                $_SESSION['error'] = 'Логін/пароль введений неправильно';
            }
            redirect();
        }
        $this->setMeta('Вхід');
    }

    public function logoutAction(){
        if(isset($_SESSION['user'])) unset($_SESSION['user']);
        redirect("/");
    }

    public function  cabinetAction() {
        if(!User::checkAuth()) redirect();
        $this->setMeta("Особистий кабінет");
    }

    public function editAction() {
        if(!User::checkAuth()) redirect("user/login");
        if(!empty($_POST)) {
            $user = new \app\models\admin\User();
            $data = $_POST;
            $data["id"] = $_SESSION["user"]["id"];
            $data["role"] = $_SESSION["user"]["role"];
            $user->load($data);
            if(!$user->attributes['password']){
                unset($user->attributes['password']);
            }else{
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            }
            if(!$user->validate($data) || !$user->checkUnique()){
                $user->getErrors();
                redirect();
            }
            if($user->update('user', $_SESSION["user"]["id"])){
                foreach($user->attributes as $k => $v){
                    if($k != 'password') $_SESSION['user'][$k] = $v;
                }
                $_SESSION['success'] = 'Зміни збережені';
            }
            redirect();
        }
        $this->setMeta("Зміна особистий даних");

    }

    public function ordersAction(){
        if(!User::checkAuth()) redirect("user/login");
        $orders = \R::findAll("order", "user_id = ?", [$_SESSION["user"]["id"]]);
        $this->setMeta("Історія замовлень");
        $this->set(compact("orders"));
    }
    public function electAction(){
        if(!User::checkAuth()) redirect("user/login");
        $this->setMeta("Обрані");
        $this->set(compact("elect"));
    }
    public function forgotAction($isAdmin = false) {
        if(!empty($_POST)){
            $user = new User();
            $email = !empty(trim($_POST['email'])) ? trim($_POST['email']) : null;
            $transport = (new Swift_SmtpTransport(App::$app->getProperty('smtp_host'), App::$app->getProperty('smtp_port'), App::$app->getProperty('smtp_protocol')))
                ->setUsername(App::$app->getProperty('smtp_login'))
                ->setPassword(App::$app->getProperty('smtp_password'))
            ;
//            // Create the Mailer using your created Transport
            $mailer = new Swift_Mailer($transport);
//
//            ob_start();
//            require APP . '/views/mail/mail_order.php';
//            $body = ob_get_clean();
            if($email) {
                if ($isAdmin) {
                    $user = \R::findOne('user', "email = ? AND role = 'admin'", [$email]);
                } else {
                    $user = \R::findOne('user', "email = ?", [$email]);
                }
            }
            // New password
            $newspass = substr($user->password, -7);

            // Message
            $message_client = (new Swift_Message("Новий пароль"))
                ->setFrom(App::$app->getProperty('smtp_login'))
                ->setTo($user->email)
                ->setBody('Ваш новий пароль ' .  $newspass)
            ;
            $user->password = password_hash($newspass, PASSWORD_DEFAULT);

            // Update password
            $update = \R::store($user);
            if($update) {
                $result = $mailer->send($message_client);
                $_SESSION['success'] = 'Ви змінили пароль, мы відправили Ваш пароль на Вашу електронну пошту';
                redirect("/user/login");
            } else {
                $_SESSION['error'] = 'Email введений неправильно';
            }
        }
        $this->setMeta('Вхід');
    }
}