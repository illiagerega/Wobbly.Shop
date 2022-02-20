<?php

# Подключение к базе данных
$localhost = '127.0.0.1';
$dbname = 'shop';
$username = 'root';
$password = 'root';

try {
    $dbh = new PDO('mysql:host='.$localhost.';dbname='.$dbname.'', $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) { echo 'error_connected';}


$dbh->query("SET NAMES utf8");
$dbh->query("SET CHARACTER SET utf8");
$dbh->query("SET character_set_client = utf8");
$dbh->query("SET character_set_connection = utf8");
$dbh->query("SET character_set_results = utf8");

$sql = "SELECT * FROM user WHERE login = '{$_SESSION['user']['login']}'";
$acc;
foreach($dbh->query($sql) as $row) { $acc = $row; }

$checkFavorites = array_filter(explode(",",$acc['favoritesAdvert']));
?>

<style>
.heartAddToFavorite {
    position: absolute;
    font-size: 25px;
    color: #bc0c0c;
    cursor: pointer;
    right: 40px;
}
</style>
<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li class='breadcrumb-home'><svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 512 512' width='48' height='48'><path d='M506.555 208.064L263.859 30.367a13.3 13.3 0 00-15.716 0L5.445 208.064c-5.928 4.341-7.216 12.665-2.875 18.593s12.666 7.214 18.593 2.875L256 57.588l234.837 171.943a13.236 13.236 0 007.848 2.57c4.096 0 8.138-1.885 10.744-5.445 4.342-5.927 3.054-14.251-2.874-18.592z'/><path d='M442.246 232.543c-7.346 0-13.303 5.956-13.303 13.303v211.749H322.521V342.009c0-36.68-29.842-66.52-66.52-66.52s-66.52 29.842-66.52 66.52v115.587H83.058V245.847c0-7.347-5.957-13.303-13.303-13.303s-13.303 5.956-13.303 13.303V470.9c0 7.347 5.957 13.303 13.303 13.303h133.029c6.996 0 12.721-5.405 13.251-12.267.032-.311.052-.651.052-1.036V342.01c0-22.009 17.905-39.914 39.914-39.914s39.914 17.906 39.914 39.914V470.9c0 .383.02.717.052 1.024.524 6.867 6.251 12.279 13.251 12.279h133.029c7.347 0 13.303-5.956 13.303-13.303V245.847c-.001-7.348-5.957-13.304-13.304-13.304z'/></svg><a href="<?= PATH ?>">Головна</a></li>
                <li><a href="<?= PATH ?>/user/cabinet">Особистий кабінет</a></li>
                <li>Обрані</li>
            </ol>
        </div>
    </div>
</div>
<!--prdt-starts-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top row">
            <div class="col-sm-9 prdt-left">
                    <div class="product-one row">
                        <?php
                        $curr = \ishop\App::$app->getProperty('currency');
                        $sql = "SELECT * FROM product WHERE status = '1'";
                        foreach($dbh->query($sql) as $row):
                        ?>
                        <?php 
                            
                            if(!in_array($row['id'], $checkFavorites)) continue;
                        ?>
                        <div class="col-sm-6 col-sm-4 product-left p-left">
                            <div class="product-main simpleCart_shelfItem">
                            <i data-login="<?=$_SESSION['user']['login']?>" data-prod-id="<?=$row['id']?>" class="far fa-heart heartAddToFavorite"></i>
                                <a href="product/<?=$row['alias'];?>" class="pm_img">
                                    <figure style="background: url('images/<?=$row['img'];?>') no-repeat center / contain;"></figure>
                                </a>
                                <a href="product/<?=$row['alias'];?>"><p class="pm_title"><?=substr($row['title'], 0, 55);?></p></a>
                                <p class="pm_available">Є в наявності</p>
                                <div class="pm_price-btn">
                                    <div class="pm_price">
                                        <?php if($row['old_price']): ?>
                                            <del><?=$curr['symbol_left'];?><?=$row['old_price'] * $curr['value'];?><?=$curr['symbol_right'];?></del>
                                        <?php endif; ?>
                                        <p><?=$curr['symbol_left'];?><?=$row['price'] * $curr['value'];?><?=$curr['symbol_right'];?></p>
                                    </div>
                                    <a data-id="<?=$row['id'];?>" href="cart/add?id=<?=$row['id'];?>" class="add-to-cart-link"><svg xmlns="http://www.w3.org/2000/svg" fill="#169FF0" viewBox="0 0 446.843 446.843"><path d="M444.09 93.103a14.343 14.343 0 00-11.584-5.888H109.92c-.625 0-1.249.038-1.85.119l-13.276-38.27a14.352 14.352 0 00-8.3-8.646L19.586 14.134c-7.374-2.887-15.695.735-18.591 8.1-2.891 7.369.73 15.695 8.1 18.591l60.768 23.872 74.381 214.399c-3.283 1.144-6.065 3.663-7.332 7.187l-21.506 59.739a11.928 11.928 0 001.468 10.916 11.95 11.95 0 009.773 5.078h11.044c-6.844 7.616-11.044 17.646-11.044 28.675 0 23.718 19.298 43.012 43.012 43.012s43.012-19.294 43.012-43.012c0-11.029-4.2-21.059-11.044-28.675h93.776c-6.847 7.616-11.048 17.646-11.048 28.675 0 23.718 19.294 43.012 43.013 43.012 23.718 0 43.012-19.294 43.012-43.012 0-11.029-4.2-21.059-11.043-28.675h13.433c6.599 0 11.947-5.349 11.947-11.948s-5.349-11.947-11.947-11.947H143.647l13.319-36.996c1.72.724 3.578 1.152 5.523 1.152h210.278a14.33 14.33 0 0013.65-9.959l59.739-186.387a14.33 14.33 0 00-2.066-12.828zM169.659 409.807c-10.543 0-19.116-8.573-19.116-19.116s8.573-19.117 19.116-19.117 19.116 8.574 19.116 19.117-8.573 19.116-19.116 19.116zm157.708 0c-10.543 0-19.117-8.573-19.117-19.116s8.574-19.117 19.117-19.117c10.542 0 19.116 8.574 19.116 19.117s-8.574 19.116-19.116 19.116zm75.153-261.658h-73.161V115.89h83.499l-10.338 32.259zm-21.067 65.712h-52.094v-37.038h63.967l-11.873 37.038zm-146.882 0v-37.038h66.113v37.038h-66.113zm66.113 28.677v31.064h-66.113v-31.064h66.113zm-161.569-65.715h66.784v37.038h-53.933l-12.851-37.038zm95.456-28.674V115.89h66.113v32.259h-66.113zm-28.673-32.259v32.259h-76.734l-11.191-32.259h87.925zm-43.982 126.648h43.982v31.064h-33.206l-10.776-31.064zm167.443 31.065v-31.064h42.909l-9.955 31.064h-32.954z"/></svg>Замовити</a>
                                </div>
                            </div>
                            <!-- <div class="product-main simpleCart_shelfItem">
                                <a href="product/<?=$row['alias'];?>" class="mask"><img class="img-responsive zoom-img" src="images/<?=$row['img'];?>" alt="" /></a>
                                <div class="product-bottom">
                                    <h3><?=$row['title'];?></h3>
                                    <p>Explore Now</p>
                                    <h4>
                                        <a data-id="<?=$row['id'];?>" class="add-to-cart-link" href="cart/add?id=<?=$row['id'];?>"><i></i></a> <span class=" item_price"><?=$curr['symbol_left'];?><?=$row['price'] * $curr['value'];?><?=$curr['symbol_right'];?></span>
                                        <?php if($row['oldprice']): ?>
                                            <small><del><?=$curr['symbol_left'];?><?=$row['old_price'] * $curr['value'];?><?=$curr['symbol_right'];?></del></small>
                                        <?php endif; ?>
                                    </h4>
                                </div>
                                <div class="srch srch1">
                                    <span>-50%</span>
                                </div>
                            </div> -->
                        </div>
                    <?php endforeach; ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--product-end