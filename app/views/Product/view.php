<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<style>
.block-star-for-score i {
    cursor: pointer;
}
.heartAddToFavorite {
    position: absolute;
    margin-top: -25px;
    font-size: 25px;
    color: #bc0c0c;
    cursor: pointer;
}
    .col {color: #333}
    .col2 {color: yellow}
</style>
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <!--<li><a href="index.html">Home</a></li>
                <li class="active">Single</li>-->
                <?=$breadcrumbs;?>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->
<!--start-single-->
<div class="single contact">
    <div class="container">
        <div class="single-main">
            <div class="single-main-left">
                <div class="sngl-top row">
                    <div class="col-md-5 single-top-left">
                        <?php if($gallery): ?>
                        <div class="flexslider">
                            <ul class="slides">
                                <?php foreach($gallery as $item): ?>
                                <li data-thumb="images/<?=$item->img;?>">
                                    <div class="thumb-image"> <img src="images/<?=$item->img;?>" data-imagezoom="true" alt=""/> </div>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php else: ?>
                            <img src="images/<?=$product->img;?>" alt="">
                        <?php endif; ?>
                        <!-- FlexSlider -->

                    </div>
                    <?php
                    $curr = \ishop\App::$app->getProperty('currency');
                    $cats = \ishop\App::$app->getProperty('cats');
                    ?>
                    <div class="col-md-7 single-top-right">
                        <div class="single-para simpleCart_shelfItem">
                        <i data-login="<?=$_SESSION['user']['login']?>" data-prod-id="<?=$product->id?>" class="far fa-heart heartAddToFavorite"></i>
                            <h2><?=$product->title;?></h2>
                            
                            <h5 class="item_price" id="base-price" data-base="<?=$product->price * $curr['value'];?>"><?=$curr['symbol_left'];?><?=$product->price * $curr['value'];?><?=$curr['symbol_right'];?></h5>
                            <div class="block-star-for-score">
                                <span>
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

                                $sql = "SELECT * FROM product WHERE id = '".$product->id."'";
                                $row;
                                foreach($dbh->query($sql) as $rows) { $row = $rows; }

                                $count    = $rows['positiveRaiting'] + $rows['negativeRaiting']; 
                                $result   = $rows['positiveRaiting'] - $rows['negativeRaiting']; 
                                $estimate = $result / $count * 5;
                            ?>
                                <i data-star-product-id="<?=$product->id;?>" id="_1" class="fas fa-star<?php echo isset($_COOKIE['raitingClick' . $product->id]) && $_COOKIE['raitingClick' . $product->id] == 1 ? ' act2 act col2' : ''; ?>"></i>
                                <i data-star-product-id="<?=$product->id;?>" id="_2" class="fas fa-star<?php echo isset($_COOKIE['raitingClick' . $product->id]) && $_COOKIE['raitingClick' . $product->id] == 2 ? ' act2 act col2' : ''; ?>"></i>
                                <i data-star-product-id="<?=$product->id;?>" id="_3" class="fas fa-star<?php echo isset($_COOKIE['raitingClick' . $product->id]) && $_COOKIE['raitingClick' . $product->id] == 3 ? ' act2 act col2' : ''; ?>"></i>
                                <i data-star-product-id="<?=$product->id;?>" id="_4" class="fas fa-star<?php echo isset($_COOKIE['raitingClick' . $product->id]) && $_COOKIE['raitingClick' . $product->id] == 4 ? ' act2 act col2' : ''; ?>"></i>
                                <i data-star-product-id="<?=$product->id;?>" id="_5" class="fas fa-star<?php echo isset($_COOKIE['raitingClick' . $product->id]) && $_COOKIE['raitingClick' . $product->id] == 5 ? ' act2 act col2' : ''; ?>"></i>
                                    </span>
                                <span>Оценка: <?=round($estimate, 1);?></span>
                            </div>
                            <?php if($product->old_price): ?>
                                <del><?=$curr['symbol_left'];?><?=$product->old_price * $curr['value'];?><?=$curr['symbol_right'];?></del>
                            <?php endif; ?>
                            <?=$product->content;?>
                            <?php if($mods): ?>
                            <div class="available">
                                <ul>
                                    <li>Color
                                        <select>
                                            <option>Обрати колiр</option>
                                            <?php foreach($mods as $mod): ?>
                                            <option data-title="<?=$mod->title;?>" data-price="<?=$mod->price * $curr['value'];?>" value="<?=$mod->id;?>"><?=$mod->title;?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </li>
                                    <div class="clearfix"> </div>
                                </ul>
                            </div>
                            <?php endif; ?>
                            <ul class="tag-men">
                                <li><span>Категорiя</span><span>: <a href="category/<?=$cats[$product->category_id]['alias'];?>"><?=$cats[$product->category_id]['title'];?></a></span></li>
                            </ul>
                            <div class="quantity count-wrap">
                                <div class="count-control minus">-</div>
                                <input class="count-value" type="number" size="4" value="1" name="quantity" min="1" step="1">
                                <div class="count-control plus">+</div>
                            </div>
                            <a id="productAdd" data-id="<?=$product->id;?>" href="cart/add?id=<?=$product->id;?>" class="add-cart item_add add-to-cart-link">Додати у кошик </a>

                        </div>
                    </div>
                    <div class="clearfix"> </div>
                    <div class="col-md-12"><div id="disqus_thread"></div></div>
                    <script>
                        (function() { // DON'T EDIT BELOW THIS LINE
                        var d = document, s = d.createElement('script');
                        s.src = 'https://k-shop-2.disqus.com/embed.js';
                        s.setAttribute('data-timestamp', +new Date());
                        (d.head || d.body).appendChild(s);
                        })();
                    </script>
                    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
                </div>
                </div>
                <?php if($related): ?>
                <div class="latestproducts">
                    <div class="product-one">
                        <h3>З цим товаром також купують:</h3>
                        <?php foreach($related as $item): ?>
                        <div class="col-sm-6 col-md-4 product-left p-left">
                            <div class="product-main simpleCart_shelfItem">
                            <a href="product/<?=$product->alias;?>" class="pm_img">
                                <figure style="background: url('images/<?=$product->img;?>') no-repeat center / contain;"></figure>
                            </a>
                            <a href="product/<?=$product->alias;?>"><p class="pm_title"><?=$product->title;?></p></a>
                            <p class="pm_available">Є в наявності</p>
                            <div class="pm_price-btn">
                                <div class="pm_price">
                                    <?php if($product->old_price): ?>
                                        <del><?=$curr['symbol_left'];?><?=$product->old_price * $curr['value'];?><?=$curr['symbol_right'];?></del>
                                    <?php endif; ?>
                                    <p><?=$curr['symbol_left'];?><?=$product->price * $curr['value'];?><?=$curr['symbol_right'];?></p>
                                </div>
                                <a data-id="<?=$product->id;?>" href="cart/add?id=<?=$product->id;?>" class="add-to-cart-link"><svg xmlns="http://www.w3.org/2000/svg" fill="#169FF0" viewBox="0 0 446.843 446.843"><path d="M444.09 93.103a14.343 14.343 0 00-11.584-5.888H109.92c-.625 0-1.249.038-1.85.119l-13.276-38.27a14.352 14.352 0 00-8.3-8.646L19.586 14.134c-7.374-2.887-15.695.735-18.591 8.1-2.891 7.369.73 15.695 8.1 18.591l60.768 23.872 74.381 214.399c-3.283 1.144-6.065 3.663-7.332 7.187l-21.506 59.739a11.928 11.928 0 001.468 10.916 11.95 11.95 0 009.773 5.078h11.044c-6.844 7.616-11.044 17.646-11.044 28.675 0 23.718 19.298 43.012 43.012 43.012s43.012-19.294 43.012-43.012c0-11.029-4.2-21.059-11.044-28.675h93.776c-6.847 7.616-11.048 17.646-11.048 28.675 0 23.718 19.294 43.012 43.013 43.012 23.718 0 43.012-19.294 43.012-43.012 0-11.029-4.2-21.059-11.043-28.675h13.433c6.599 0 11.947-5.349 11.947-11.948s-5.349-11.947-11.947-11.947H143.647l13.319-36.996c1.72.724 3.578 1.152 5.523 1.152h210.278a14.33 14.33 0 0013.65-9.959l59.739-186.387a14.33 14.33 0 00-2.066-12.828zM169.659 409.807c-10.543 0-19.116-8.573-19.116-19.116s8.573-19.117 19.116-19.117 19.116 8.574 19.116 19.117-8.573 19.116-19.116 19.116zm157.708 0c-10.543 0-19.117-8.573-19.117-19.116s8.574-19.117 19.117-19.117c10.542 0 19.116 8.574 19.116 19.117s-8.574 19.116-19.116 19.116zm75.153-261.658h-73.161V115.89h83.499l-10.338 32.259zm-21.067 65.712h-52.094v-37.038h63.967l-11.873 37.038zm-146.882 0v-37.038h66.113v37.038h-66.113zm66.113 28.677v31.064h-66.113v-31.064h66.113zm-161.569-65.715h66.784v37.038h-53.933l-12.851-37.038zm95.456-28.674V115.89h66.113v32.259h-66.113zm-28.673-32.259v32.259h-76.734l-11.191-32.259h87.925zm-43.982 126.648h43.982v31.064h-33.206l-10.776-31.064zm167.443 31.065v-31.064h42.909l-9.955 31.064h-32.954z"/></svg>Замовити</a>
                            </div>
                        </div>
                            <!-- <div class="product-main simpleCart_shelfItem">
                                <a href="product/<?=$item['alias'];?>" class="mask"><img class="img-responsive zoom-img" src="images/<?=$item['img'];?>" alt="" /></a>
                                <div class="product-bottom">
                                    <h3><a href="product/<?=$item['alias'];?>"><?=$item['title'];?></a></h3>
                                    <p>Explore Now</p>
                                    <h4>
                                        <a class="item_add add-to-cart-link" href="cart/add?id=<?=$item['id'];?>" data-id="<?=$item['id'];?>"><i></i></a>
                                        <span class="item_price"><?=$curr['symbol_left'];?><?=$item['price'] * $curr['value'];?><?=$curr['symbol_right'];?></span>
                                        <?php if($item['old_price']): ?>
                                            <del><?=$curr['symbol_left'];?><?=$item['old_price'] * $curr['value'];?><?=$curr['symbol_right'];?></del>
                                        <?php endif; ?>
                                    </h4>
                                </div>
                                <div class="srch">
                                    <span>-50%</span>
                                </div>
                            </div> -->
                        </div>
                        <?php endforeach; ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?php endif; ?>

                <?php if($recentlyViewed): ?>
                    <div class="latestproducts">
                        <div class="product-one">
                            <h3>Нещодавно переглянуті:</h3>
                            <div class="row">
                            <?php foreach($recentlyViewed as $item): ?>
                                
                                    <div class="col-sm-6 col-md-4 product-left p-left">
                                    <div class="product-main simpleCart_shelfItem">
                                        <a href="product/<?=$item['alias'];?>" class="pm_img">
                                            <figure style="background: url('images/<?=$item['img'];?>') no-repeat center / contain;"></figure>
                                        </a>
                                        <a href="product/<?=$item['alias'];?>"><p class="pm_title"><?=$item['title'];?></p></a>
                                        <p class="pm_available">Є в наявності</p>
                                        <div class="pm_price-btn">
                                            <div class="pm_price">
                                                <?php if($product->old_price): ?>
                                                    <del><?=$curr['symbol_left'];?><?=$product->old_price * $curr['value'];?><?=$curr['symbol_right'];?></del>
                                                <?php endif; ?>
                                                <p><?=$curr['symbol_left'];?><?=$product->price * $curr['value'];?><?=$curr['symbol_right'];?></p>
                                            </div>
                                            <a data-id="<?=$product->id;?>" href="cart/add?id=<?=$product->id;?>" class="add-to-cart-link"><svg xmlns="http://www.w3.org/2000/svg" fill="#169FF0" viewBox="0 0 446.843 446.843"><path d="M444.09 93.103a14.343 14.343 0 00-11.584-5.888H109.92c-.625 0-1.249.038-1.85.119l-13.276-38.27a14.352 14.352 0 00-8.3-8.646L19.586 14.134c-7.374-2.887-15.695.735-18.591 8.1-2.891 7.369.73 15.695 8.1 18.591l60.768 23.872 74.381 214.399c-3.283 1.144-6.065 3.663-7.332 7.187l-21.506 59.739a11.928 11.928 0 001.468 10.916 11.95 11.95 0 009.773 5.078h11.044c-6.844 7.616-11.044 17.646-11.044 28.675 0 23.718 19.298 43.012 43.012 43.012s43.012-19.294 43.012-43.012c0-11.029-4.2-21.059-11.044-28.675h93.776c-6.847 7.616-11.048 17.646-11.048 28.675 0 23.718 19.294 43.012 43.013 43.012 23.718 0 43.012-19.294 43.012-43.012 0-11.029-4.2-21.059-11.043-28.675h13.433c6.599 0 11.947-5.349 11.947-11.948s-5.349-11.947-11.947-11.947H143.647l13.319-36.996c1.72.724 3.578 1.152 5.523 1.152h210.278a14.33 14.33 0 0013.65-9.959l59.739-186.387a14.33 14.33 0 00-2.066-12.828zM169.659 409.807c-10.543 0-19.116-8.573-19.116-19.116s8.573-19.117 19.116-19.117 19.116 8.574 19.116 19.117-8.573 19.116-19.116 19.116zm157.708 0c-10.543 0-19.117-8.573-19.117-19.116s8.574-19.117 19.117-19.117c10.542 0 19.116 8.574 19.116 19.117s-8.574 19.116-19.116 19.116zm75.153-261.658h-73.161V115.89h83.499l-10.338 32.259zm-21.067 65.712h-52.094v-37.038h63.967l-11.873 37.038zm-146.882 0v-37.038h66.113v37.038h-66.113zm66.113 28.677v31.064h-66.113v-31.064h66.113zm-161.569-65.715h66.784v37.038h-53.933l-12.851-37.038zm95.456-28.674V115.89h66.113v32.259h-66.113zm-28.673-32.259v32.259h-76.734l-11.191-32.259h87.925zm-43.982 126.648h43.982v31.064h-33.206l-10.776-31.064zm167.443 31.065v-31.064h42.909l-9.955 31.064h-32.954z"/></svg>Замовити</a>
                                        </div>
                                    </div>
                                    
                                    <!--<div class="col-sm-6 col-md-4 product-left p-left">
                                    <div class="product-main simpleCart_shelfItem">
                                        <a href="product/<?=$product->alias;?>" class="pm_img">
                                            <figure style="background: url('images/<?=$product->img;?>') no-repeat center / contain;"></figure>
                                        </a>
                                        <a href="product/<?=$product->alias;?>"><p class="pm_title"><?=$product->title;?></p></a>
                                        <p class="pm_available">Є в наявності</p>
                                        <div class="pm_price-btn">
                                            <div class="pm_price">
                                                <?php if($product->old_price): ?>
                                                    <del><?=$curr['symbol_left'];?><?=$product->old_price * $curr['value'];?><?=$curr['symbol_right'];?></del>
                                                <?php endif; ?>
                                                <p><?=$curr['symbol_left'];?><?=$product->price * $curr['value'];?><?=$curr['symbol_right'];?></p>
                                            </div>
                                            <a data-id="<?=$product->id;?>" href="cart/add?id=<?=$product->id;?>" class="add-to-cart-link"><svg xmlns="http://www.w3.org/2000/svg" fill="#169FF0" viewBox="0 0 446.843 446.843"><path d="M444.09 93.103a14.343 14.343 0 00-11.584-5.888H109.92c-.625 0-1.249.038-1.85.119l-13.276-38.27a14.352 14.352 0 00-8.3-8.646L19.586 14.134c-7.374-2.887-15.695.735-18.591 8.1-2.891 7.369.73 15.695 8.1 18.591l60.768 23.872 74.381 214.399c-3.283 1.144-6.065 3.663-7.332 7.187l-21.506 59.739a11.928 11.928 0 001.468 10.916 11.95 11.95 0 009.773 5.078h11.044c-6.844 7.616-11.044 17.646-11.044 28.675 0 23.718 19.298 43.012 43.012 43.012s43.012-19.294 43.012-43.012c0-11.029-4.2-21.059-11.044-28.675h93.776c-6.847 7.616-11.048 17.646-11.048 28.675 0 23.718 19.294 43.012 43.013 43.012 23.718 0 43.012-19.294 43.012-43.012 0-11.029-4.2-21.059-11.043-28.675h13.433c6.599 0 11.947-5.349 11.947-11.948s-5.349-11.947-11.947-11.947H143.647l13.319-36.996c1.72.724 3.578 1.152 5.523 1.152h210.278a14.33 14.33 0 0013.65-9.959l59.739-186.387a14.33 14.33 0 00-2.066-12.828zM169.659 409.807c-10.543 0-19.116-8.573-19.116-19.116s8.573-19.117 19.116-19.117 19.116 8.574 19.116 19.117-8.573 19.116-19.116 19.116zm157.708 0c-10.543 0-19.117-8.573-19.117-19.116s8.574-19.117 19.117-19.117c10.542 0 19.116 8.574 19.116 19.117s-8.574 19.116-19.116 19.116zm75.153-261.658h-73.161V115.89h83.499l-10.338 32.259zm-21.067 65.712h-52.094v-37.038h63.967l-11.873 37.038zm-146.882 0v-37.038h66.113v37.038h-66.113zm66.113 28.677v31.064h-66.113v-31.064h66.113zm-161.569-65.715h66.784v37.038h-53.933l-12.851-37.038zm95.456-28.674V115.89h66.113v32.259h-66.113zm-28.673-32.259v32.259h-76.734l-11.191-32.259h87.925zm-43.982 126.648h43.982v31.064h-33.206l-10.776-31.064zm167.443 31.065v-31.064h42.909l-9.955 31.064h-32.954z"/></svg>Замовити</a>
                                        </div>
                                    </div>-->
                                    
                                    <!-- <div class="product-main simpleCart_shelfItem">
                                        <a href="product/<?=$item['alias'];?>" class="mask"><img class="img-responsive zoom-img" src="images/<?=$item['img'];?>" alt="" /></a>
                                        <div class="product-bottom">
                                            <h3><a href="product/<?=$item['alias'];?>"><?=$item['title'];?></a></h3>
                                            <p>Explore Now</p>
                                            <h4>
                                                <a class="item_add add-to-cart-link" href="cart/add?id=<?=$item['id'];?>" data-id="<?=$item['id'];?>"><i></i></a>
                                                <span class="item_price"><?=$curr['symbol_left'];?><?=$item['price'] * $curr['value'];?><?=$curr['symbol_right'];?></span>
                                                <?php if($item['old_price']): ?>
                                                    <del><?=$curr['symbol_left'];?><?=$item['old_price'] * $curr['value'];?><?=$curr['symbol_right'];?></del>
                                                <?php endif; ?>
                                            </h4>
                                        </div>
                                        <div class="srch">
                                            <span>-50%</span>
                                        </div>
                                    </div> -->
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?php endif; ?>
                <br><br>
                
            <div class="clearfix"> </div>
        </div>
    </div>
</div>
<script>
    if (!$('.block-star-for-score i.act2').length)
    $('.block-star-for-score span i').hover(
        function(){
            if ($('.block-star-for-score i.act2').length) return false;
            $('.block-star-for-score span i').removeClass('col2 act');
            $(this).addClass('col2 act');
            $(this).nextAll('i').removeClass('col2');
            $(this).prevAll('i').addClass('col2');
        },
        function(){
            //$('.block-star-for-score span i').removeClass('col2');
        }
    );
    $('.block-star-for-score span i.act2').prevAll('i').addClass('col2');
</script>
<!--end-single