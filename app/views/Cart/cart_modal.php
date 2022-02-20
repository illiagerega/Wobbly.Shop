<?php if(!empty($_SESSION['cart'])): ?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <!-- <thead>
            <tr>
                <th>Фото</th>
                <th>Товар</th>
                <th>Кіл-ть</th>
                <th>Ціна</th>
                <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
            </tr>
            </thead> -->
            <tbody>
            <?php foreach($_SESSION['cart'] as $id => $item): ?>
                <tr>
                    <td><a href="product/<?=$item['alias'];?>"><img src="images/<?=$item['img'];?>" alt=""></a></td>
                    <td><a href="product/<?=$item['alias'];?>"><?=$item['title'];?></td>
                    <td>x<?=$item['qty'];?></td>
                    <td><?=$item['price'];?>₴</td>
                    <td><span data-id="<?=$id;?>" class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></td>
                </tr>
            <?php endforeach; ?>
                <tr>
                    <td>Кількість:</td>
                    <td colspan="1" class="text-left cart-qty"><?=$_SESSION['cart.qty'];?></td>
                </tr>
                <tr>
                    <td>На сумму:</td>
                    <td colspan="1" class="text-left cart-sum"><?= $_SESSION['cart.currency']['symbol_left'] . $_SESSION['cart.sum'] . $_SESSION['cart.currency']['symbol_right'];?></td>
                </tr>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <h3>Кошик пустий</h3>
<?php endif; ?>