<?php 
$errors = [];
ini_set('display_errors', 1);
function validate() {
	global $errors;

	if (empty($_POST['username'])) {
		$errors['username'] = 'Введите юзернейм администратора';
	}

	if (empty($_POST['password'])) {
		$errors['password'] = 'Введите пароль администратора';
	}

	if (empty($_POST['currency_title'])) {
		$errors['currency_title'] = 'Введите название валюты';
	}

	if (empty($_POST['currency_code'])) {
		$errors['currency_code'] = 'Введите код валюты';
	}

	if (empty($_POST['currency_value']) || !preg_match('/^[0-9.]{1,}$/', $_POST['currency_value'])) {
		$errors['currency_value'] = 'Допускаются цифры и десятичная точка';
	}

	if ((mb_strlen($_POST['email']) > 96) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = 'Не валидный  email';
	}

	$allowed = array(
		'jpg',
		'png',
	);


	if(!empty($_FILES['site_logo'])){        
        if($_FILES['site_logo']["error"] == UPLOAD_ERR_OK){
            $tmp_name = $_FILES["site_logo"]["tmp_name"];
            $name = basename($_FILES["site_logo"]["name"]);

            if (!in_array(strtolower(substr(strrchr($name, '.'), 1)), $allowed)) {
				$errors['site_logo'] = 'Файл должен быть jpg ли png';
			}else{
				move_uploaded_file($tmp_name, WWW . "/images/" . $name);
			}
        }
    }

	return !$errors;
}

if($_SERVER['REQUEST_METHOD'] == 'POST' && validate()){
	$config_db = require __DIR__ . '/../../config/config_db.php';

	try {
		$db = new \PDO($config_db['dsn'], htmlspecialchars_decode($config_db['user']), htmlspecialchars_decode($config_db['pass']), array(\PDO::ATTR_PERSISTENT => false));
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
	} catch (\PDOException $e) {
		exit('Error: Невозможно подключиться к базе данных ' . $config_db['user'] . '@' . $config_db['dsn'] . '!');
	}

	$db->query("DELETE FROM `setting` WHERE `key` IN('np_api', 'turbosms_sender', 'turbosms_api', 'w4p_private', 'w4p_account', 'banner_title', 'banner_text', 'banner_href', 'site_colour', 'footer_facebook', 'footer_twitter', 'footer_google')");

    $sth = $db->prepare('INSERT INTO `setting` SET `key` = ?, `value` = ?');

    $sth->execute(array('site_colour', $_POST['site_colour']));
    $sth->execute(array('footer_facebook', $_POST['facebook']));
    $sth->execute(array('footer_twitter', $_POST['twitter']));
    $sth->execute(array('footer_google', $_POST['google']));
    $sth->execute(array('np_api', $_POST['np_api']));
    $sth->execute(array('turbosms_sender', $_POST['turbosms_sender']));
    $sth->execute(array('turbosms_api', $_POST['turbosms_api']));
    $sth->execute(array('w4p_private', $_POST['w4p_private']));
    $sth->execute(array('w4p_account', $_POST['w4p_account']));

    if(!empty($_FILES['site_logo'])){
        $site_logo = '';
        
        if($_FILES['site_logo']["error"] == UPLOAD_ERR_OK){
            $tmp_name = $_FILES["site_logo"]["tmp_name"];
            $name = basename($_FILES["site_logo"]["name"]);

            if(!move_uploaded_file($tmp_name, __DIR__ . "/../../public/images/" . $name)){
            	die('Error ' . $tmp_name);
            }

            $site_logo = $name;
        }
    }else{
        $site_logo = '';
    }	

    if($site_logo){
        $db->query("DELETE FROM `setting` WHERE `key` = 'site_logo'");

        $sth->execute(array('site_logo', $site_logo)); 
    }

    $prepare = $db->prepare("INSERT INTO `user` SET login = ?, password = ?, email = ?, name = 'John', address = '', role = 'admin', phone = '' ON DUPLICATE KEY UPDATE password = ?");

	$prepare->execute(array(
		$_POST['username'], 
		password_hash($_POST['password'], PASSWORD_DEFAULT),
		$_POST['email'],
		password_hash($_POST['password'], PASSWORD_DEFAULT),
	));

	$db->query("DELETE FROM `currency`");

	$prepare = $db->prepare("INSERT INTO `currency` SET title = ?, code = ?, symbol_left = ?, symbol_right = ?, value = ?, base = '1'");

	$prepare->execute(array(
		$_POST['currency_title'], 
		$_POST['currency_code'], 
		$_POST['currency_symbol_left'], 
		$_POST['currency_symbol_right'], 
		$_POST['currency_value'], 
	));

    $output  = '<?php' . "\n";
	$output .= 'return [' . "\n";

	$output .= '    \'admin_email\' => \'\',' . "\n";
	$output .= '    \'pagination\' => 9,' . "\n";
	$output .= '    \'smtp_host\' => \'\',' . "\n";
	$output .= '    \'smtp_port\' => 25,' . "\n";
	$output .= '    \'smtp_protocol\' => \'tls\',' . "\n";
	$output .= '    \'smtp_login\' => \'\',' . "\n";
	$output .= '    \'smtp_password\' => \'\',' . "\n";
	$output .= '    \'img_width\' => 125,' . "\n";
	$output .= '    \'img_height\' => 200,' . "\n";
	$output .= '    \'gallery_width\' => 700,' . "\n";
	$output .= '    \'gallery_height\' => 1000,' . "\n";
	$output .= '    \'ik_key\' => \'\',' . "\n";
	$output .= '    \'ik_id\' => \'\',' . "\n";
	$output .= '];' . "\n";

	$file = fopen(__DIR__ . '/../../config/params.php', 'w');

	fwrite($file, $output);

	fclose($file);

	header('Location: /install/step_4.php');
    exit();
}

if (isset($errors['warning'])) {
	$error_warning = $errors['warning'];
} else {
	$error_warning = '';
}

if (isset($errors['username'])) {
	$error_username = $errors['username'];
} else {
	$error_username = '';
}

if (isset($errors['password'])) {
	$error_password = $errors['password'];
} else {
	$error_password = '';
}

if (isset($errors['email'])) {
	$error_email = $errors['email'];
} else {
	$error_email = '';
}

if (isset($errors['site_logo'])) {
	$error_site_logo = $errors['site_logo'];
} else {
	$error_site_logo = '';
}

if (isset($errors['currency_title'])) {
	$error_currency_title = $errors['currency_title'];
} else {
	$error_currency_title = '';
}

if (isset($errors['currency_code'])) {
	$error_currency_code = $errors['currency_code'];
} else {
	$error_currency_code = '';
}

if (isset($errors['currency_value'])) {
	$error_currency_value = $errors['currency_value'];
} else {
	$error_currency_value = '';
}

if (isset($_POST['username'])) {
	$username = $_POST['username'];
} else {
	$username = 'admin';
}

if (isset($_POST['password'])) {
	$password = $_POST['password'];
} else {
	$password = '';
}

if (isset($_POST['email'])) {
	$email = $_POST['email'];
} else {
	$email = '';
}

if (isset($_POST['site_colour'])) {
	$site_colour = $_POST['site_colour'];
} else {
	$site_colour = 'blue';
}

if (isset($_POST['facebook'])) {
	$facebook = $_POST['facebook'];
} else {
	$facebook = '';
}


if (isset($_POST['google'])) {
	$google = $_POST['google'];
} else {
	$google = '';
}


if (isset($_POST['twitter'])) {
	$twitter = $_POST['twitter'];
} else {
	$twitter = '';
}

if (isset($_POST['np_api'])) {
	$np_api = $_POST['np_api'];
} else {
	$np_api = '';
}

if (isset($_POST['turbosms_sender'])) {
	$turbosms_sender = $_POST['turbosms_sender'];
} else {
	$turbosms_sender = '';
}

if (isset($_POST['turbosms_api'])) {
	$turbosms_api = $_POST['turbosms_api'];
} else {
	$turbosms_api = '';
}

if (isset($_POST['w4p_private'])) {
	$w4p_private = $_POST['w4p_private'];
} else {
	$w4p_private = '';
}

if (isset($_POST['w4p_account'])) {
	$w4p_account = $_POST['w4p_account'];
} else {
	$w4p_account = '';
}


if (isset($_POST['currency_title'])) {
	$currency_title = $_POST['currency_title'];
} else {
	$currency_title = 'UAH';
}

if (isset($_POST['currency_code'])) {
	$currency_code = $_POST['currency_code'];
} else {
	$currency_code = 'UAH';
}

if (isset($_POST['currency_symbol_left'])) {
	$currency_symbol_left = $_POST['currency_symbol_left'];
} else {
	$currency_symbol_left = '';
}

if (isset($_POST['currency_symbol_right'])) {
	$currency_symbol_right = $_POST['currency_symbol_right'];
} else {
	$currency_symbol_right = 'UAH';
}

if (isset($_POST['currency_value'])) {
	$currency_value = $_POST['currency_value'];
} else {
	$currency_value = '1';
}


include './view/step_3.tpl';