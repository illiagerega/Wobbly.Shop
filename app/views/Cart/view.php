
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li class='breadcrumb-home'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='48' height='48'><path d='M506.555 208.064L263.859 30.367a13.3 13.3 0 00-15.716 0L5.445 208.064c-5.928 4.341-7.216 12.665-2.875 18.593s12.666 7.214 18.593 2.875L256 57.588l234.837 171.943a13.236 13.236 0 007.848 2.57c4.096 0 8.138-1.885 10.744-5.445 4.342-5.927 3.054-14.251-2.874-18.592z'/><path d='M442.246 232.543c-7.346 0-13.303 5.956-13.303 13.303v211.749H322.521V342.009c0-36.68-29.842-66.52-66.52-66.52s-66.52 29.842-66.52 66.52v115.587H83.058V245.847c0-7.347-5.957-13.303-13.303-13.303s-13.303 5.956-13.303 13.303V470.9c0 7.347 5.957 13.303 13.303 13.303h133.029c6.996 0 12.721-5.405 13.251-12.267.032-.311.052-.651.052-1.036V342.01c0-22.009 17.905-39.914 39.914-39.914s39.914 17.906 39.914 39.914V470.9c0 .383.02.717.052 1.024.524 6.867 6.251 12.279 13.251 12.279h133.029c7.347 0 13.303-5.956 13.303-13.303V245.847c-.001-7.348-5.957-13.304-13.304-13.304z'/></svg><a href="<?= PATH ?>">Головна</a></li>
                <li>Кошик</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->
<!--prdt-starts-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="product-one cart">
                <div class="register-top heading">
                    <h2>Оформленя замовлення</h2>
                </div>
                <br><br>
                <?php if(!empty($_SESSION['cart'])):?>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <!-- <thead>
                                    <tr>
                                        <th>Фото</th>
                                        <th>Товар</th>
                                        <th>Кол-ть</th>
                                        <th>Ціна</th>
                                        <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
                                    </tr>
                                    </thead> -->
                                    <tbody>
                                    <?php foreach($_SESSION['cart'] as $id => $item): ?>
                                        <tr>
                                            <td><a href="product/<?=$item['alias'] ?>"><img src="images/<?= $item['img'] ?>" alt="<?=$item['title'] ?>"></a></td>
                                            <td><a href="product/<?=$item['alias'] ?>"><?=$item['title'] ?></a></td>
                                            <td>x<?=$item['qty'] ?></td>
                                            <td><?=$item['price'] ?>₴</td>
                                            <td><a href="/cart/delete/?id=<?=$id ?>"><span data-id="<?=$id ?>" class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></a></td>
                                        </tr>
                                    <?php endforeach;?>
                                    <tr>
                                        <td>Кількість:</td>
                                        <td colspan="1" class="text-left cart-qty"><?=$_SESSION['cart.qty'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>На сумму:</td>
                                        <td colspan="1" class="text-left cart-sum"><?= $_SESSION['cart.currency']['symbol_left'] . $_SESSION['cart.sum'] . " {$_SESSION['cart.currency']['symbol_right']}" ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="account-left">
                            <?php if(!isset($_SESSION['user'])): ?>
                                <button class="btn btn-default register_form active">Замовлення</button>
                                <button class="btn btn-default fast_form">Швидке замовлення</button>
                            <?php endif; ?>
                            <form method="post" action="cart/checkout" role="form" class="full" data-toggle="validator">
                                <?php if(!isset($_SESSION['user'])): ?>
                                    <div class="form-group has-feedback">
                                        <!-- <br><label for="login">Логін</label> -->
                                        <input type="text" name="login" class="form-control" id="login" placeholder="Логін" value="<?= isset($_SESSION['form_data']['login']) ? $_SESSION['form_data']['login'] : '' ?>" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <!-- <label for="pasword">Пароль</label> -->
                                        <input type="password" name="password" class="form-control" id="pasword" placeholder="Пароль" value="<?= isset($_SESSION['form_data']['password']) ? $_SESSION['form_data']['password'] : '' ?>" data-minlength="6" data-error="Пароль повинен мати мінімум 7 символів" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <!-- <label for="name">Ім'я</label> -->
                                        <input type="text" name="name" class="form-control" id="name" placeholder="Ім'я" value="<?= isset($_SESSION['form_data']['name']) ? $_SESSION['form_data']['name'] : '' ?>" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>
                                    <div class="form-group has-feedback">
                                        <!-- <label for="email">Email</label> -->
                                        <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="<?= isset($_SESSION['form_data']['email']) ? $_SESSION['form_data']['email'] : '' ?>" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <!-- <label for="phone">Телефон</label> -->
                                        <input type="text" name="phone" class="form-control" id="phone" placeholder="Телефон" value="<?= isset($_SESSION['form_data']['phone']) ? $_SESSION['form_data']['phone'] : '' ?>" required>
                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                    </div>

                                    <div class="form-group has-feedback">
                                        <label>Як можна зв"язатись з Вами після замовлення?</label>
                                            <select name='call' style="width: 250px;">
                                                <option value='not'>Не дзвонити(без сплати ми будемо змушені з вами зв'язатися)</option>
                                                <option value='yes'>Дзвонити</option>
                                                <option value='mes'>Повідомлення у мессенджері</option>
                                            </select>
                                    </div>


    <!--                                    <div class="form-group has-feedback">-->
    <!--                                        <label for="address">Номер відділення Нової Пошти</label>-->
    <!--                                        <input type="text" name="address" class="form-control" id="address" placeholder="Номер відділення" value="--><?//= isset($_SESSION['form_data']['address']) ? $_SESSION['form_data']['address'] : '' ?><!--" required>-->
    <!--                                        <span class="glyphicon form-control-feedback" aria-hidden="true"></span>-->
    <!--                                    </div>-->
                                    
                                <?php endif; ?>
                                <select class="np_cities" name="npCityRef">
                                    <?php foreach ($_SESSION['np.cities'] as $row) { ?>
                                        <option value="<?=$row['Ref']?>"><?=$row['Description']?></option>
                                    <?php } ?>
                                </select>                              
                                <div class="np_warehouses"></div>
                                <div class="form-group">
                                	<label>Оплатить онлайн</label>
                                	<input class="" type="checkbox" name="pay" value="1">
                                </div>
                                <?php if(isset($_SESSION['user'])): ?>
                                <div class="form-group has-feedback">
                                    <label>Як можна зв"язатись з Вами після замовлення?</label>
                                        <select name='call'>
                                            <option value='not'>Не дзвонити(без сплати ми будемо змушені з вами зв'язатися)</option>
                                            <option value='yes'>Дзвонити</option>
                                            <option value='mes'>Повідомлення у мессенджері</option>
                                        </select>
                                    </div>
                                    <?php endif; ?>
                                <?php if(isset($_SESSION['user'])): ?>
                                    <div class="form-group">
                                        <label for="address">Введіть кількість бонусів, яку Ви бажаєте потратити(або промокод)</label>
                                        <textarea name="note" class="form-control"></textarea>
                                    </div>
                                    <?php endif; ?>
                                <button type="submit" class="btn btn-default">Замовити</button>
                            </form>
                            <?php if(!isset($_SESSION['user'])): ?>
                                <form method="post" action="cart/fast" role="form" class="fast" data-toggle="validator">
                                    <?php if(!isset($_SESSION['user'])): ?>
                                        <div class="form-group has-feedback">
                                            <!-- <br><label for="name">Ім'я</label> -->
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Ім'я" value="<?= isset($_SESSION['form_data']['name']) ? $_SESSION['form_data']['name'] : '' ?>" required>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                        <div class="form-group has-feedback">
                                            <!-- <label for="phone">Телефон</label> -->
                                            <input type="text" name="phone" class="form-control" id="phone" placeholder="Телефон" value="<?= isset($_SESSION['form_data']['phone']) ? $_SESSION['form_data']['phone'] : '' ?>" required>
                                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                        </div>

                                        <select class="np_cities" name="npCityRef">
                                            <?php foreach ($_SESSION['np.cities'] as $row) { ?>
                                                <option value="<?=$row['Ref']?>"><?=$row['Description']?></option>
                                            <?php } ?>
                                        </select>
                                        <div class="np_warehouses"></div>
                                        
                                    <?php endif; ?>
                                    <!--<div class="form-group">
                                        <label for="address">Нотатка</label>
                                        <textarea name="note" class="form-control"></textarea>
                                    </div>-->
                                    <button type="submit" class="btn btn-default">Замовити</button>
                                </form>
                            <?php endif; ?>
                            <?php if(isset($_SESSION['form_data'])) unset($_SESSION['form_data']); ?>
                        </div>
                        </div>
                    </div>
                <?php else: ?>
                    <h3>Кошик пустий</h3>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>
<!--product-end