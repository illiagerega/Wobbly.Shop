<?php include './view/header.tpl'; ?>
<div class="container">
  <header>
    <div class="row">
      <div class="col-sm-6">
        <h1 class="pull-left">3<small>/4</small></h1>
        <h3>Настройка<br>
          <small>Настройка сайта</small></h3>
      </div>
      <div class="col-sm-6">
        <div id="logo" class="pull-right hidden-xs"> <img src="assets/image/logo.png"/></div>
      </div>
    </div>
  </header>
  <?php if($error_warning) { ?>
  <div class="alert alert-danger alert-dismissible"><i class="fa fa-exclamation-circle"></i> {{ error_warning }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>
  <div class="row">
    <div class="col-sm-9">
      <form action="step_3.php" method="post" enctype="multipart/form-data" class="form-horizontal">
        <p>1. Введите данные для создания администратора магазина</p>
        <fieldset>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-username">Username</label>
            <div class="col-sm-10">
              <input type="text" name="username" value="<?php echo $username; ?>" id="input-username" class="form-control" />
              <?php if($error_username) { ?>
              <div class="text-danger"><?php echo $error_username; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-password">Password</label>
            <div class="col-sm-10">
              <input type="password" name="password" value="<?php echo $password; ?>" id="input-password" class="form-control" />
              <?php if($error_password) { ?>
              <div class="text-danger"><?php echo $error_password; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-email">Email</label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" />
              <?php if($error_email) { ?>
              <div class="text-danger"><?php echo $error_email; ?></div>
              <?php } ?>
            </div>
          </div>
        </fieldset>
        <p>2. Введите настройки сайта</p>
        <p>Если Вам что то не нужно, оставьте поле пустым!</p>
        <fieldset>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-w4p_account">WayForPay - Merchant login</label>
            <div class="col-sm-10">
              <input type="text" name="w4p_account" value="<?php echo $w4p_account; ?>" id="input-w4p_account" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-w4p_private">WayForPay - Secret key</label>
            <div class="col-sm-10">
              <input type="text" name="w4p_private" value="<?php echo $w4p_private; ?>" id="input-w4p_private" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-np_api">Новaя почта - Ключ API</label>
            <div class="col-sm-10">
              <input type="text" name="np_api" value="<?php echo $np_api; ?>" id="input-np_api" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-turbosms_api">TurboSMS - Ключ API</label>
            <div class="col-sm-10">
              <input type="text" name="turbosms_api" value="<?php echo $turbosms_api; ?>" id="input-turbosms_api" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-turbosms_sender">TurboSMS - Отправитель</label>
            <div class="col-sm-10">
              <input type="text" name="turbosms_sender" value="<?php echo $turbosms_sender; ?>" id="input-turbosms_sender" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-facebook">Ссылка на Facebook</label>
            <div class="col-sm-10">
              <input type="text" name="facebook" value="<?php echo $facebook; ?>" id="input-facebook" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-twitter">Ссылка на Twitter</label>
            <div class="col-sm-10">
              <input type="text" name="twitter" value="<?php echo $twitter; ?>" id="input-twitter" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-google">Ссылка на Google+</label>
            <div class="col-sm-10">
              <input type="text" name="google" value="<?php echo $google; ?>" id="input-google" class="form-control" />
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-site_logo">Логотип</label>
            <div class="col-sm-10">
              <input type="file" name="site_logo">
              <?php if($error_site_logo) { ?>
              <div class="text-danger"><?php echo $error_site_logo; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-site_logo">Цвет сайта</label>
            <div class="col-sm-10">
              <label><input type="radio" name="site_colour" value="green"<?php if($site_colour == 'green') { echo 'checked'; } ?>>Green</label><br>
              <label><input type="radio" name="site_colour" value="red" <?php if($site_colour == 'red') { echo 'checked'; } ?>>Red</label><br>
              <label><input type="radio" name="site_colour" value="orange" <?php if($site_colour == 'orange') { echo 'checked'; } ?>>Orange</label><br>
              <label><input type="radio" name="site_colour" value="yellow" <?php if($site_colour == 'yellow') { echo 'checked'; } ?>>Yellow</label><br>
              <label><input type="radio" name="site_colour" value="green" <?php if($site_colour == 'green') { echo 'checked'; } ?>>Green</label><br>
              <label><input type="radio" name="site_colour" value="violet" <?php if($site_colour == 'violet') { echo 'checked'; } ?>>Violet</label><br>
              <label><input type="radio" name="site_colour" value="brown" <?php if($site_colour == 'brown') { echo 'checked'; } ?>>Brown</label><br>
              <label><input type="radio" name="site_colour" value="blue" <?php if($site_colour == 'blue') { echo 'checked'; } ?>>Blue</label>
            </div>
          </div>
        </fieldset>
        <p>3. Введите настройки основной валюты</p>
        <p>Если у Вас в магазине будет гривна, оставьте Всё как есть</p>
        <fieldset>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-currency_title">Наименование валюты</label>
            <div class="col-sm-10">
              <input type="text" name="currency_title" value="<?php echo $currency_title; ?>" id="input-currency_title" class="form-control" />
              <?php if($error_currency_title) { ?>
              <div class="text-danger"><?php echo $error_currency_title; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-currency_code">Код валюты</label>
            <div class="col-sm-10">
              <input type="text" name="currency_code" value="<?php echo $currency_code; ?>" id="input-currency_code" class="form-control" />
              <?php if($error_currency_code) { ?>
              <div class="text-danger"><?php echo $error_currency_code; ?></div>
              <?php } ?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-currency_symbol_left">Символ слева</label>
            <div class="col-sm-10">
              <input type="text" name="currency_symbol_left" value="<?php echo $currency_symbol_left; ?>" id="input-currency_symbol_left" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-currency_symbol_right">Символ справа</label>
            <div class="col-sm-10">
              <input type="text" name="currency_symbol_right" value="<?php echo $currency_symbol_right; ?>" id="input-currency_symbol_right" class="form-control" />
            </div>
          </div>
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-currency_value">Значение</label>
            <div class="col-sm-10">
              <input type="text" name="currency_value" value="<?php echo $currency_value; ?>" id="input-currency_value" class="form-control" />
              <?php if($error_currency_value) { ?>
              <div class="text-danger"><?php echo $error_currency_value; ?></div>
              <?php } ?>
            </div>
          </div>
        </fieldset>
        <div class="buttons">
          <div class="pull-left"></div>
          <div class="pull-right">
            <input type="submit" value="Продолжить" class="btn btn-primary" />
          </div>
        </div>
      </form>
    </div>
    <div class="col-sm-3">
      <ul class="list-group">
        <li class="list-group-item">Пользовательское соглашение</li>
        <li class="list-group-item">Установка</li>
        <li class="list-group-item"><b>Настройка</b></li>
        <li class="list-group-item">Завершение</li>
      </ul>
</div>
  </div>
</div>
<?php include './view/footer.tpl'; ?>