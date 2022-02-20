<!DOCTYPE html>
<html>
<head>
	<base href="/">
    <?php if(!empty($canonical)): ?>
        <link rel="canonical" href="<?=$canonical;?>"/>
    <?php endif; ?>
    <link rel="shortcut icon" href="images/star.png" type="image/png"/>
    <?=$this->getMeta();?>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="megamenu/css/ionicons.min.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="megamenu/css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="css/owl.carousel.css" type="text/css" media="screen"/>
    <link href="adminlte/bower_components/select2/dist/css/select2.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    

    <!--theme-style-->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="css/wobble-style.css" rel="stylesheet" type="text/css" media="all"/>
    <!--//theme-style-->
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body class="theme-<?php echo config('site_colour'); ?>">









    <!-- ============== Mobile Header ============== -->    
    <header class="m-header">
        <div class="container">
            <div class="row">
                
                <!-- Menu Button -->
                <button class="m-header__button m-header__menu umenu-open">
                    <span class="m-header__button-icon">
                        <svg width="20px" height="15px" viewBox="0 0 18 14">
                            <path d="M-0,8L-0,6L18,6L18,8L-0,8ZM-0,-0L18,-0L18,2L-0,2L-0,-0ZM14,14L-0,14L-0,12L14,12L14,14Z" />
                        </svg>
                    </span>
                </button>

                <!-- Logo -->
                <a href="<?=PATH;?>" class="m-header__logo">
                    <img src="images/<?php echo config('site_logo'); ?>" alt="">
                </a>
                
                <!-- Profile Button  -->
                <div class="m-header__button m-header__profile m-header__dropdown ml-auto">
                    <span class="m-header__button-icon">
                        <svg width="20" height="20" viewBox="0 0 20 20">
                            <path d="M20,20h-2c0-4.4-3.6-8-8-8s-8,3.6-8,8H0c0-4.2,2.6-7.8,6.3-9.3C4.9,9.6,4,7.9,4,6c0-3.3,2.7-6,6-6s6,2.7,6,6c0,1.9-0.9,3.6-2.3,4.7C17.4,12.2,20,15.8,20,20z M14,6c0-2.2-1.8-4-4-4S6,3.8,6,6s1.8,4,4,4S14,8.2,14,6z" />
                        </svg>
                    </span>
                     <ul>
                        <?php if(!empty($_SESSION['user'])): ?>
                            <li><a href="user/cabinet"><?=h($_SESSION['user']['name']);?></a></li>
                            <li><a href="user/logout">Вихід</a></li>
                        <?php else: ?>
                            <li><a href="user/login">Вхід</a></li>
                            <li><a href="user/signup">Реєстрація</a></li>
                        <?php endif; ?>
                    </ul>
                    
                    
                </div>
                
                <!-- Shopping Cart Button  -->
                <a href="cart/show" class="m-header__button m-header__cart" onclick="getCart(); return false;">
                    <span class="m-header__button-icon">
                        <svg width="20" height="20" viewBox="0 0 20 20">
                            <circle cx="7" cy="17" r="2" />
                            <circle cx="15" cy="17" r="2" />
                            <path d="M20,4.4V5l-1.8,6.3c-0.1,0.4-0.5,0.7-1,0.7H6.7c-0.4,0-0.8-0.3-1-0.7L3.3,3.9C3.1,3.3,2.6,3,2.1,3H0.4C0.2,3,0,2.8,0,2.6V1.4C0,1.2,0.2,1,0.4,1h2.5c1,0,1.8,0.6,2.1,1.6L5.1,3l2.3,6.8c0,0.1,0.2,0.2,0.3,0.2h8.6c0.1,0,0.3-0.1,0.3-0.2l1.3-4.4C17.9,5.2,17.7,5,17.5,5H9.4C9.2,5,9,4.8,9,4.6V3.4C9,3.2,9.2,3,9.4,3h9.2C19.4,3,20,3.6,20,4.4z" />
                        </svg>
                        <?php if(!empty($_SESSION['cart'])): ?>
                            <span class="m-header__cart-counter simpleCart_quantity"><?=$_SESSION['cart.qty'];?></span> 
                        <?php else: ?>
                            <span class="m-header__cart-counter simpleCart_quantity">0</span> 
                        <?php endif; ?>
                    </span>
                </a>
                
                 <!-- Search -->
                <div class="m-header__search">
                    <form action="search" method="get" autocomplete="off" class="m-header__search-form">
                        <button type="submit" value="" class="m-header__search-open">
                            <svg width="18" height="18" viewBox="0 0 20 20">
                                <path d="M19.2,17.8c0,0-0.2,0.5-0.5,0.8c-0.4,0.4-0.9,0.6-0.9,0.6s-0.9,0.7-2.8-1.6c-1.1-1.4-2.2-2.8-3.1-3.9C10.9,14.5,9.5,15,8,15c-3.9,0-7-3.1-7-7s3.1-7,7-7s7,3.1,7,7c0,1.5-0.5,2.9-1.3,4c1.1,0.8,2.5,2,4,3.1C20,16.8,19.2,17.8,19.2,17.8z M8,3C5.2,3,3,5.2,3,8c0,2.8,2.2,5,5,5c2.8,0,5-2.2,5-5C13,5.2,10.8,3,8,3z" />
                            </svg>
                        </button>
                        <input type="text" id="typeahead-m" name="s" class="m-header__search-input typeahead" placeholder="Поиск">
                        <button class="m-header__search-close"></button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    <!-- ============== /.Mobile Header ============== --> 



    <!-- ============== Sidebar Mobile Menu ============== --> 
    <div class="umenu">
        <div class="umenu__wrapper">
            <div class="umenu__content">

                <!-- Logo -->
                <a href="<?=PATH;?>" class="umenu-logo">
                    <img src="images/<?php echo config('site_logo'); ?>" alt="">
                </a>
                
                <!-- Profile -->
                <div class="umenu-profile active">
                    <span class="umenu-profile__title">Раді вас вітати, увійдіть в кабінет</span>
                    <ul style="display: block;">
                        <?php if(!empty($_SESSION['user'])): ?>
                            <li><a href="user/cabinet"><?=h($_SESSION['user']['name']);?></a></li>
                            <li><a href="user/logout">Вихід</a></li>
                        <?php else: ?>
                            <li><a href="user/login">Вхід</a></li>
                            <li><a href="user/signup">Реєстрація</a></li>
                        <?php endif; ?>
                    </ul>
                  
                </div>
                
                <!-- Catalog -->
                
                <ul class="umenu-menu">
                    <li class="umenu-menu__button">
                        <a href="#"><i class="fal fa-box-full"></i> Каталог</a>
                        
                        <?php new \app\widgets\menu\Menu(['tpl' => WWW . '/menu/menu.php',]); ?>
                   
                    </li>
                </ul>
                
               
            </div>
            <div style="margin-bottom:10px;" class='umenu__content'>
                <a href="<?php echo config('footer_facebook'); ?>" class="soc-item"><svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 0 24 24" width="48"><path d="M15.997 3.985h2.191V.169C17.81.117 16.51 0 14.996 0c-3.159 0-5.323 1.987-5.323 5.639V9H6.187v4.266h3.486V24h4.274V13.267h3.345l.531-4.266h-3.877V6.062c.001-1.233.333-2.077 2.051-2.077z"/></svg></a>
                <a href="<?php echo config('footer_twitter'); ?>" class="soc-item"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="48" height="48"><path d="M512 97.248c-19.04 8.352-39.328 13.888-60.48 16.576 21.76-12.992 38.368-33.408 46.176-58.016-20.288 12.096-42.688 20.64-66.56 25.408C411.872 60.704 384.416 48 354.464 48c-58.112 0-104.896 47.168-104.896 104.992 0 8.32.704 16.32 2.432 23.936-87.264-4.256-164.48-46.08-216.352-109.792-9.056 15.712-14.368 33.696-14.368 53.056 0 36.352 18.72 68.576 46.624 87.232-16.864-.32-33.408-5.216-47.424-12.928v1.152c0 51.008 36.384 93.376 84.096 103.136-8.544 2.336-17.856 3.456-27.52 3.456-6.72 0-13.504-.384-19.872-1.792 13.6 41.568 52.192 72.128 98.08 73.12-35.712 27.936-81.056 44.768-130.144 44.768-8.608 0-16.864-.384-25.12-1.44C46.496 446.88 101.6 464 161.024 464c193.152 0 298.752-160 298.752-298.688 0-4.64-.16-9.12-.384-13.568 20.832-14.784 38.336-33.248 52.608-54.496z"/></svg></a>
                <a href="<?php echo config('footer_google'); ?>" class="soc-item"><svg xmlns="http://www.w3.org/2000/svg" height="48" viewBox="0 0 24 24" width="48"><path d="M21.823 9h-2.187v2.177h-2.177v2.187h2.177v2.177h2.187v-2.177H24v-2.187h-2.177zM7.5 19.5c4.328 0 7.203-3.038 7.203-7.326 0-.491-.051-.87-.122-1.248h-7.08v2.578h4.257c-.174 1.095-1.289 3.233-4.257 3.233-2.557 0-4.645-2.118-4.645-4.737s2.087-4.738 4.645-4.738c1.463 0 2.435.624 2.988 1.156l2.036-1.954C11.214 5.237 9.526 4.5 7.5 4.5 3.356 4.5 0 7.856 0 12s3.356 7.5 7.5 7.5z"/></svg></a>
            </div>
            <button class="umenu-close">Закрыть</button>
        </div>
    </div>
    <!-- ============== /.Sidebar Mobile Menu ============== --> 

    <!-- ============== Header ============== -->
    <header class="header">

        <!-- ============== Header Top ============== -->
         <div class="header-top">
            <div class="container">
                <div class="row">
                    <!-- Currency -->
                    <!--<div class="header-item header-item-dropdown ml-auto">
                        <?php new \app\widgets\currency\Currency(); ?>
                    </div>-->
                    <div style="margin-left:10px;" class='footer-line'><a href="privacypolicy">Політика конфідеційності</a></div>
                    <div style="margin-left:10px;" class='footer-line'><a href="anonimity">Анонімність</a></div>
                    <div style="margin-left:10px;" class='footer-line'><a href="shipping">Доставка</a></div>
                </div>
            </div>
        </div>
        <!-- ============== /.Header Top ============== -->
        

        <!-- ============== Header Middle ============== -->
        <div class="header-middle">
            <div class="container">
                <div class="row">

                    <!-- Logo -->
                    <a href="<?=PATH;?>" class="header__logo">
                        <img src="images/<?php echo config('site_logo'); ?>" alt="">
                    </a>    
                    <!-- Profile -->
                    <?php if(!empty($_SESSION['user'])): ?>
                        <div class="header-indicator header-item-dropdown ml-auto">
                            <a href="user/cabinet" class="header-indicator__button">
                                <span class="header-indicator__icon">
                                    <svg width="32" height="32">
                                        <path d="M16,18C9.4,18,4,23.4,4,30H2c0-6.2,4-11.5,9.6-13.3C9.4,15.3,8,12.8,8,10c0-4.4,3.6-8,8-8s8,3.6,8,8c0,2.8-1.5,5.3-3.6,6.7C26,18.5,30,23.8,30,30h-2C28,23.4,22.6,18,16,18z M22,10c0-3.3-2.7-6-6-6s-6,2.7-6,6s2.7,6,6,6S22,13.3,22,10z"></path>
                                    </svg> 
                                </span>
                                <span class="header-indicator__title">Раді вас вітати</span> 
                                <span class="header-indicator__value"><?=h($_SESSION['user']['name']);?></span>
                            </a>
                            <ul>
                                <li><a href="user/logout">Вихід</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <div class="header-indicator header-item-dropdown ml-auto">
                            <a href="user/login" class="header-indicator__button">
                                <span class="header-indicator__icon">
                                    <svg width="32" height="32">
                                        <path d="M16,18C9.4,18,4,23.4,4,30H2c0-6.2,4-11.5,9.6-13.3C9.4,15.3,8,12.8,8,10c0-4.4,3.6-8,8-8s8,3.6,8,8c0,2.8-1.5,5.3-3.6,6.7C26,18.5,30,23.8,30,30h-2C28,23.4,22.6,18,16,18z M22,10c0-3.3-2.7-6-6-6s-6,2.7-6,6s2.7,6,6,6S22,13.3,22,10z"></path>
                                    </svg> 
                                </span>
                                <span class="header-indicator__title">Раді вас вітати</span> 
                                <span class="header-indicator__value">Мій профіль</span>
                            </a>
                            <ul>
                                <li><a href="user/login">Вхід</a></li>
                                <li><a href="user/signup">Реєстрація</a></li>
                            </ul>
                        </div>
                    <?php endif; ?>
                        
                    <!-- Shopping Cart -->
                     <div class="header-indicator">
                        <a href="cart/show" class="header-indicator__button" onclick="getCart(); return false;">
                            <span class="header-indicator__icon">
                                <svg width="32" height="32">
                                    <circle cx="10.5" cy="27.5" r="2.5"></circle>
                                    <circle cx="23.5" cy="27.5" r="2.5"></circle>
                                    <path d="M26.4,21H11.2C10,21,9,20.2,8.8,19.1L5.4,4.8C5.3,4.3,4.9,4,4.4,4H1C0.4,4,0,3.6,0,3s0.4-1,1-1h3.4C5.8,2,7,3,7.3,4.3l3.4,14.3c0.1,0.2,0.3,0.4,0.5,0.4h15.2c0.2,0,0.4-0.1,0.5-0.4l3.1-10c0.1-0.2,0-0.4-0.1-0.4C29.8,8.1,29.7,8,29.5,8H14c-0.6,0-1-0.4-1-1s0.4-1,1-1h15.5c0.8,0,1.5,0.4,2,1c0.5,0.6,0.6,1.5,0.4,2.2l-3.1,10C28.5,20.3,27.5,21,26.4,21z">
                                    </path>
                                </svg> 
                                <?php if(!empty($_SESSION['cart'])): ?>
                                    <span class="header-indicator__counter simpleCart_quantity"><?=$_SESSION['cart.qty'];?></span> 
                                <?php else: ?>
                                    <span class="header-indicator__counter simpleCart_quantity">0</span> 
                                <?php endif; ?>
                            </span>
                            <span class="header-indicator__title">Корзина</span> 


                            <?php if(!empty($_SESSION['cart'])): ?>
                                <span class="header-indicator__value simpleCart_total"><?=$_SESSION['cart.currency']['symbol_left'] . $_SESSION['cart.sum'] . $_SESSION['cart.currency']['symbol_right'];?></span>
                            <?php else: ?>
                                <span class="header-indicator__value simpleCart_total">Порожня корзина</span>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============== /.Header Middle ============== -->


        <!-- ============== Header Bottom ============== -->
        <div class="header-bottom">
            <div class="container">
                <div class="row">
                    
                    <!-- Header Catalog -->
                    <div class="header-menu header-catalog header-dropdown">
                        <?php new \app\widgets\menu\Menu([
                            'tpl' => WWW . '/menu/menu.php',
                        ]); ?>    
                    </div>        
                    
                    
                    <!-- Search Form -->
                    <div class="header-search ml-auto">
                        <form action="search" method="get" autocomplete="off" class="header-search__form">
                            <input class="header-search__input typeahead" type="text" id="typeahead" name="s" placeholder="Поиск">  
                            <button class="header-search__button" type="submit" value="">
                                <i class="far fa-search"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============== /.Header Bottom ============== -->

    </header>
    <!-- ============== /.Header ============== -->

    <!-- ============== Main Content ============== -->
    <main class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <?php if(isset($_SESSION['error'])): ?>
                        <div class="alert alert-danger">
                            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                        </div>
                    <?php endif; ?>
                    <?php if(isset($_SESSION['success'])): ?>
                        <div class="alert alert-success">
                            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?=$content;?>
    </main>
    <!-- ============== /.Main Content ============== -->








<!--information-starts-->
<footer>
    <div class="footer-content">
        <div class="container">
            <div class="warning-message">
                <img src="/images/exchange.svg" alt="warn">
                Товары эротического характера не подлежат возврату или замене
            </div>
            <div class="warning-message">
                <img src="/images/18.svg" alt="warn">
                Просмотр представленных материалов разрешен только лицам старше 18 лет!
            </div>
            <a href="#" class="oferta-link">Публичная оферта</a>
            <div class="soc-row">
                <a href="<?php echo config('footer_facebook'); ?>" class="social-item">
                    <svg width="42" height="42" viewBox="0 0 42 42" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M21 42C32.598 42 42 32.598 42 21C42 9.40202 32.598 0 21 0C9.40202 0 0 9.40202 0 21C0 32.598 9.40202 42 21 42Z" fill="#3B5998"/>
                        <path d="M26.2794 21.8222H22.5322V35.5502H16.8549V21.8222H14.1548V16.9977H16.8549V13.8756C16.8549 11.643 17.9154 8.14703 22.5827 8.14703L26.7881 8.16463V12.8477H23.7368C23.2363 12.8477 22.5326 13.0978 22.5326 14.1628V17.0022H26.7754L26.2794 21.8222Z" fill="white"/>
                    </svg>
                </a>
                <a href="<?php echo config('footer_instagram'); ?>" class="social-item">
                    <img src="/images/instagram.svg" alt="insta">
                </a>
            </div>
        </div>
    </div>
    <div class="footer-line">© 2020 Всё защищено!</div>
</footer>

<!-- Modal -->
<div class="modal fade" id="cart" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><svg fill="#169FF0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512.001 512.001" width="48" height="48"><path d="M284.286 256.002L506.143 34.144c7.811-7.811 7.811-20.475 0-28.285-7.811-7.81-20.475-7.811-28.285 0L256 227.717 34.143 5.859c-7.811-7.811-20.475-7.811-28.285 0-7.81 7.811-7.811 20.475 0 28.285l221.857 221.857L5.858 477.859c-7.811 7.811-7.811 20.475 0 28.285a19.938 19.938 0 0014.143 5.857 19.94 19.94 0 0014.143-5.857L256 284.287l221.857 221.857c3.905 3.905 9.024 5.857 14.143 5.857s10.237-1.952 14.143-5.857c7.811-7.811 7.811-20.475 0-28.285L284.286 256.002z"/></svg></button>
                <h4 class="modal-title" id="myModalLabel">Кошик</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Продовжити покупки</button>
                <a href="cart/view" type="button" class="btn btn-primary">Оформити замовлення</a>
                <!-- <button type="button" class="btn btn-danger" onclick="clearCart()">Очистити кошик</button> -->
            </div>
        </div>
    </div>
</div>

<div class="preloader"><img src="images/ring.svg" alt=""></div>


<?php $curr = \ishop\App::$app->getProperty('currency');  ?>
<script>
    var path = '<?=PATH;?>',
        course = <?=$curr;?>,
        symboleLeft = '<?=$curr['symbol_left'];?>',
        symboleRight = '<?=$curr['symbol_right'];?>';
</script>

<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/validator.js"></script>
<script src="js/typeahead.bundle.js"></script>
<!--dropdown-->
<script src="js/jquery.easydropdown.js"></script>
<script src="megamenu/js/megamenu.js"></script>
<script src="js/imagezoom.js"></script>
<script defer src="js/jquery.flexslider.js"></script>
<script>
    // Can also be used with $(document).ready()
    $(window).load(function() {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails"
        });
    });
</script>
<script src="js/jquery.easydropdown.js"></script>
<script src="adminlte/bower_components/select2/dist/js/select2.js"></script>
<script type="text/javascript">
    $(function() {

        var menu_ul = $('.menu_drop > li > ul'),
            menu_a  = $('.menu_drop > li > a');

        menu_ul.hide();

        menu_a.click(function(e) {
            e.preventDefault();
            if(!$(this).hasClass('active')) {
                menu_a.removeClass('active');
                menu_ul.filter(':visible').slideUp('normal');
                $(this).addClass('active').next().stop(true,true).slideDown('normal');
            } else {
                $(this).removeClass('active');
                $(this).next().stop(true,true).slideUp('normal');
            }
        });

    });
</script>

<script src="js/owl.carousel.min.js"></script>
<script src="js/umenu.js"></script>
<script src="js/main.js"></script>
<!--End-slider-script-->
    <?php

    $query = \R::getAll("select favoritesAdvert from user WHERE login = '" . htmlspecialchars($_SESSION['user']['login']) . "'");

    if (isset($query[0]['favoritesAdvert'])) {
        $wish = array_filter(explode(",", $query[0]['favoritesAdvert']));

    ?>
        <script>
            $(document).ready(function(){
                var pids = <?php echo json_encode($wish); ?>;

                for (i in pids) {
                    $('.heartAddToFavorite[data-prod-id="' + pids[i] + '"]').addClass('fas').removeClass('far');
                }
            });
        </script>
    <?php } ?>
</body>
</html>