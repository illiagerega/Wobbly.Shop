<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Список товаров
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Список товаров</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <form method="get" action="<?=ADMIN?>/product/">
                <select name="category">
                    <option value="0" <?=$_GET['category'] == 0? 'selected' : false?>>Все</option>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?=$category['id']?>" <?=$_GET['category'] == $category['id']? 'selected' : false?>><?=$category['title']?></option>
                    <?php } ?>
                </select>
                <input type="submit" class="btn-success">
            </form>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="productTable">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Категория</th>
                                <th>Наименование</th>
                                <th>Алиас</th>
                                <th>Цена</th>
                                <th>Старая цена</th>
                                <th>Ключевые слова</th>
                                <th>Описание</th>
                                <th>Статус</th>
                                <th>Хит</th>
                                <th>Кол-во заказов</th>
                                <th>Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($products as $product): ?>
                                <tr>
                                    <td><?=$product['id'];?></td>
                                    <td><?=$product['cat'];?></td>
                                    <td><?=$product['title'];?></td>
                                    <td><?=$product['alias'];?></td>
                                    <td><?=$product['price'];?></td>
                                    <td><?=$product['old_price'];?></td>
                                    <td><?=$product['keywords'];?></td>
                                    <td><?=$product['description'];?></td>
                                    <td><?=$product['status'] ? 'Да' : 'Нет';?></td>
                                    <td><?=$product['hit'] ? 'Да' : 'Нет';?></td>
                                    <td><?=$product['count']?></td>
                                    <td><a href="<?=ADMIN;?>/product/edit?id=<?=$product['id'];?>"><i class="fa fa-fw fa-eye"></i></a> <a class="delete" href="<?=ADMIN;?>/product/delete?id=<?=$product['id'];?>"><i class="fa fa-fw fa-close text-danger"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
<!--                    <div class="text-center">-->
<!--                        <p>(--><?//=count($products);?><!-- товаров из --><?//=$count;?><!--)</p>-->
<!--                        --><?php //if($pagination->countPages > 1): ?>
<!--                            --><?//=$pagination;?>
<!--                        --><?php //endif; ?>
<!--                    </div>-->
                </div>
            </div>
        </div>
    </div>

</section>
<!-- /.content -->