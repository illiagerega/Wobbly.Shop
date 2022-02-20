<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li class='breadcrumb-home'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='48' height='48'><path d='M506.555 208.064L263.859 30.367a13.3 13.3 0 00-15.716 0L5.445 208.064c-5.928 4.341-7.216 12.665-2.875 18.593s12.666 7.214 18.593 2.875L256 57.588l234.837 171.943a13.236 13.236 0 007.848 2.57c4.096 0 8.138-1.885 10.744-5.445 4.342-5.927 3.054-14.251-2.874-18.592z'/><path d='M442.246 232.543c-7.346 0-13.303 5.956-13.303 13.303v211.749H322.521V342.009c0-36.68-29.842-66.52-66.52-66.52s-66.52 29.842-66.52 66.52v115.587H83.058V245.847c0-7.347-5.957-13.303-13.303-13.303s-13.303 5.956-13.303 13.303V470.9c0 7.347 5.957 13.303 13.303 13.303h133.029c6.996 0 12.721-5.405 13.251-12.267.032-.311.052-.651.052-1.036V342.01c0-22.009 17.905-39.914 39.914-39.914s39.914 17.906 39.914 39.914V470.9c0 .383.02.717.052 1.024.524 6.867 6.251 12.279 13.251 12.279h133.029c7.347 0 13.303-5.956 13.303-13.303V245.847c-.001-7.348-5.957-13.304-13.304-13.304z'/></svg><a href="<?=PATH;?>">Головна</a></li>
                <li><a href="<?=PATH;?>/user/cabinet">Особистий кабінет</a></li>
                <li>Історія замовлень</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->
<!--prdt-starts-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-12 prdt-left">
                <?php if($orders): ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped table-condensed">
                            <thead>
                            <tr>
                                <th style="width: 10%">ID</th>
                                <th style="width: 30%">Статус</th>
                                <th style="width: 20%">Сумма</th>
                                <th style="width: 20%">Дата создания</th>
                                <th style="width: 20%">Дата изменения</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($orders as $order): ?>
                                <?php
                                if($order['status'] == '1'){
                                    $class = 'success';
                                    $text = 'Завершений';
                                }elseif($order['status'] == '2'){
                                    $class = 'info';
                                    $text = 'Оплачений';
                                }else{
                                    $class = '';
                                    $text = 'Новий';
                                }
                                ?>
                                <tr class="<?=$class;?>">
                                    <td><?=$order->id;?></td>
                                    <td><?=$text;?></td>
                                    <td><?=$order->sum;?> <?=$order->currency;?></td>
                                    <td><?=$order->date;?></td>
                                    <td><?=$order->update_at;?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-danger">Ви поки що не зробили жодного замовлення</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!--product-end-->