<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li class='breadcrumb-home'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='48' height='48'><path d='M506.555 208.064L263.859 30.367a13.3 13.3 0 00-15.716 0L5.445 208.064c-5.928 4.341-7.216 12.665-2.875 18.593s12.666 7.214 18.593 2.875L256 57.588l234.837 171.943a13.236 13.236 0 007.848 2.57c4.096 0 8.138-1.885 10.744-5.445 4.342-5.927 3.054-14.251-2.874-18.592z'/><path d='M442.246 232.543c-7.346 0-13.303 5.956-13.303 13.303v211.749H322.521V342.009c0-36.68-29.842-66.52-66.52-66.52s-66.52 29.842-66.52 66.52v115.587H83.058V245.847c0-7.347-5.957-13.303-13.303-13.303s-13.303 5.956-13.303 13.303V470.9c0 7.347 5.957 13.303 13.303 13.303h133.029c6.996 0 12.721-5.405 13.251-12.267.032-.311.052-.651.052-1.036V342.01c0-22.009 17.905-39.914 39.914-39.914s39.914 17.906 39.914 39.914V470.9c0 .383.02.717.052 1.024.524 6.867 6.251 12.279 13.251 12.279h133.029c7.347 0 13.303-5.956 13.303-13.303V245.847c-.001-7.348-5.957-13.304-13.304-13.304z'/></svg><a href="<?= PATH ?>">Головна</a></li>
                <li>Вхід</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->
<!--prdt-starts-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-12">
                <div class="product-one login">
                    <div class="register-top heading">
                        <h2>Вхід</h2>
                    </div>

                    <div class="register-main">
                        <div class="col-md-5 account-left">
                            <form method="post" action="user/login" id="login" role="form" data-toggle="validator">
                                <div class="form-group has-feedback">
                                    <!-- <label for="login">Логін</label> -->
                                    <input type="text" name="login" class="form-control" id="login" placeholder="Логін" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="form-group has-feedback">
                                    <!-- <label for="pasword">Пароль</label> -->
                                    <input type="password" name="password" class="form-control" id="pasword" placeholder="Пароль" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <button type="submit" class="btn btn-default">Вхід</button>
                                <button type="button" class="btn btn-primary forgot-pass">Відновити пароль</button>
                                
                                <a href='user/signup' style="margin-left:40%;">Реєстрація</a>
                                
                                
                            </form>
                            <form method="post" action="user/forgot" id="forgot" role="form" data-toggle="validator">
                                <div class="form-group has-feedback">
                                    <!-- <label for="email">Відновлення пароля</label> -->
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Напишіть тут Ваш Email" value="<?=isset($_SESSION['form_data']['email']) ? h($_SESSION['form_data']['email']) : '';?>" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <button type="submit" class="btn btn-default">Відновити</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--product-end