<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Настройки сайта
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Настройки сайта</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <form action="<?=ADMIN;?>/setting/save" method="post">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th>Значение</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Цвет сайта</td>
                                    <td>
                                        <label><input type="radio" name="site_colour" value="green"<?php if($site_colour == 'green') { echo 'checked'; } ?>>Green</label><br>
                                        <label><input type="radio" name="site_colour" value="red" <?php if($site_colour == 'red') { echo 'checked'; } ?>>Red</label><br>
                                        <label><input type="radio" name="site_colour" value="orange" <?php if($site_colour == 'orange') { echo 'checked'; } ?>>Orange</label><br>
                                        <label><input type="radio" name="site_colour" value="yellow" <?php if($site_colour == 'yellow') { echo 'checked'; } ?>>Yellow</label><br>
                                        <label><input type="radio" name="site_colour" value="green" <?php if($site_colour == 'green') { echo 'checked'; } ?>>Green</label><br>
                                        <label><input type="radio" name="site_colour" value="violet" <?php if($site_colour == 'violet') { echo 'checked'; } ?>>Violet</label><br>
                                        <label><input type="radio" name="site_colour" value="brown" <?php if($site_colour == 'brown') { echo 'checked'; } ?>>Brown</label><br>
                                        <label><input type="radio" name="site_colour" value="blue" <?php if($site_colour == 'blue') { echo 'checked'; } ?>>Blue</label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Логотип сайта</td>
                                    <td><input type="file" name="site_logo"></td>
                                </tr>
                                <tr>
                                    <td>Ссылка на Facebook</td>
                                    <td><input type="text" name="footer_facebook" value="<?php echo $footer_facebook; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Ссылка на Twitter</td>
                                    <td><input type="text" name="footer_twitter" value="<?php echo $footer_twitter; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Ссылка на Google+</td>
                                    <td><input type="text" name="footer_google" value="<?php echo $footer_google; ?>"></td>
                                </tr>
                                <tr>
                                    <td>WayForPay - Merchant Account</td>
                                    <td><input type="text" name="w4p_account" value="<?php echo $w4p_account; ?>"></td>
                                </tr>
                                <tr>
                                    <td>WayForPay - Secret key</td>
                                    <td><input type="text" name="w4p_private" value="<?php echo $w4p_private; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Новaя почта - Ключ API</td>
                                    <td><input type="text" name="np_api" value="<?php echo $np_api; ?>"></td>
                                </tr>
                                <tr>
                                    <td>TurboSMS - Ключ API</td>
                                    <td><input type="text" name="turbosms_api" value="<?php echo $turbosms_api; ?>"></td>
                                </tr>
                                <tr>
                                    <td>TurboSMS - Отправитель</td>
                                    <td><input type="text" name="turbosms_sender" value="<?php echo $turbosms_sender; ?>"></td>
                                </tr>
                                <tr>
                                    <td>Процент от покупки, который переводится в бонусы</td>
                                    <td><input type="text" name="percent" value="<?php echo $percent; ?>"></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th><button type="submit">Сохранить</button></th>
                                </tr>
                            </tfoot>
                        </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->