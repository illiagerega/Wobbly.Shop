/* Filters */
$('body').on('change', '.w_sidebar input', function(){
    if($(this).attr('id') == 'inputABC' || $(this).attr('id') == 'regulationPriceMin' || $(this).attr('id') == 'regulationPriceMax') return true;
    var checked = $('.w_sidebar input:checked'),
        data = '';
    checked.each(function () {
        data += this.value + ',';
    });
    if(data){
        $.ajax({
            url: location.href,
            data: {filter: data},
            type: 'GET',
            beforeSend: function(){
                $('.preloader').fadeIn(300, function(){
                    $('.product-one').hide();
                });
            },
            success: function(res){
                $('.preloader').delay(500).fadeOut('slow', function(){
                    $('.product-one').html(res).fadeIn();
                    var url = location.search.replace(/filter(.+?)(&|$)/g, ''); //$2
                    var newURL = location.pathname + url + (location.search ? "&" : "?") + "filter=" + data;
                    newURL = newURL.replace('&&', '&');
                    newURL = newURL.replace('?&', '?');
                    history.pushState({}, '', newURL);
                });
            },
            error: function () {
                alert('Ошибка!');
            }
        });
    }else{
        window.location = location.pathname;
    }
});
function getURLVar(key) {
  var query = String(document.location.href).split('?');
  if (query[1]) {
    var part = query[1].split('&');
    for (i = 0; i < part.length; i++) {
      var data = part[i].split('=');
      if (data[0] == key && data[1]) return data[1];
    }
  }
  return '';
}
function removeParam(key, sourceURL) {
    var splitUrl = sourceURL.split('?'),
        rtn = splitUrl[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? splitUrl[1] : '';
    if (queryString !== '') {
        params_arr = queryString.split('&');
        for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split('=')[0];
            if (param === key) {
                params_arr.splice(i, 1);
            }
        }
        rtn = rtn + '?' + params_arr.join('&');
    }
    return rtn;
}
$('[name="limit"]').change(function() {
    var val = this.value;

    const url = new URL(document.location);
    const searchParams = url.searchParams;

    var sign = '';
    if (location.href.indexOf('?') !== -1) {
        sign = "&";
    } else sign = "?";

    if(getURLVar('limit') == 9 || getURLVar('limit') == 12 || getURLVar('limit') == 15){
        searchParams.delete("limit");
    }

    var href = url.toString() + sign + "limit=" + val;

    $.ajax({
        url: href,
        type: 'GET',
        beforeSend: function(){
            $('.preloader').fadeIn(300, function(){
                $('.product-one').hide();
            });
        },
        success: function(res){
            $('.preloader').delay(500).fadeOut('slow', function(){
                $('.product-one').html(res).fadeIn();

                window.history.pushState({}, '', href);
            });
        }
    });
});
$('#inputABC').change(function() {
    if($(this).is(':checked')) {
        $.ajax({
            url: location.href,
            type: 'GET',
            beforeSend: function(){
                $('.preloader').fadeIn(300, function(){
                    $('.product-one').hide();
                });
            },
            success: function(res){
                $('.preloader').delay(500).fadeOut('slow', function(){
                    $('.product-one').html(res).fadeIn();
                    if(getURLVar('ABC') == 'yes'){
                        const url = new URL(document.location);
                        const searchParams = url.searchParams;
                        searchParams.delete("ABC"); 
                        window.history.pushState({}, '', url.toString());
                    }
                    var sign = '';
                    if(location.href.indexOf('?') !== -1) {
                        sign = "&";
                    }
                    else sign = "?";
    
                    window.location.href = window.location + sign + "ABC=yes";
                });
            },
            error: function () {
                alert('Ошибка!');
            }
        });
    }
    else {
        const url = new URL(document.location);
        const searchParams = url.searchParams;
        searchParams.delete("ABC"); 
        window.history.pushState({}, '', url.toString());
        window.location.href = window.location;
    }
});
$('.btnClearPriceRegulation').click(function() {
    $.ajax({
        url: location.href,
        type: 'GET',
        beforeSend: function(){
            $('.preloader').fadeIn(300, function(){
                $('.product-one').hide();
            });
        },
        success: function(res){
            $('.preloader').delay(500).fadeOut('slow', function(){
                $('.product-one').html(res).fadeIn();
                const url = new URL(document.location);
                const searchParams = url.searchParams;
                searchParams.delete("priceMin"); 
                searchParams.delete("priceMax"); 
                window.history.pushState({}, '', url.toString());
                window.location.href = window.location;
            });
        },
        error: function () {
            alert('Ошибка!');
        }
    });
});
$(document).ready(function() {
    $('.arrowDropMenuFilter').each(function() {
        $(this).click();
    });
});
if (!$('.block-star-for-score i.act2').length)
$('.block-star-for-score i').click(function() {
    var t = $(this);

    $.ajax({
        type: "POST",
        url: "/public/js/updateRaiting.php",
        data: { 
            idProduct: $(this).attr('data-star-product-id'), 
            raiting: $(this).attr('id'),
            login: $('.heartAddToFavorite').attr('data-login')
        }
      }).done(function( msg ) {
        $('block-star-for-score span i.act').nextAll('i').removeClass('col2');
        $('block-star-for-score span i.act').prevAll('i').addClass('col2');
        t.addClass('col2 act2');
    });
});
$('.heartAddToFavorite').click(function() {
    var t = $(this);
    var par = t.hasClass('fas') ? 1 : 0;

    $.ajax({
        type: "POST",
        url: "/public/js/updateFavoriteProduct.php",
        data: { 
            idProduct: $(this).attr('data-prod-id'),
            login:  $(this).attr('data-login'),
            par: par
        }
      }).done(function( msg ) {
        if(msg == 'add') {
            $(this).css('color','orange');
        }
        else {
            $(this).css('color','#bc0c0c');
        }

        if (par) {
            t.removeClass('fas');
            t.addClass('far');
        } else {
            t.removeClass('far');
            t.addClass('fas');
        }
    });
});
$('.sky-form h4').click(function() {
    if($(this).find('> i').attr('data-dostup') != 'closed') {
        $('#' + $(this).find('> i').attr('data-block-id')).fadeOut(300);
        $(this).find('> i').attr('data-dostup','closed');
        $(this).find('> i').removeAttr('class');
        $(this).find('> i').attr('class','fas fa-sort-down arrowDropMenuFilter');
    }
    else {
        $('#' + $(this).find('> i').attr('data-block-id')).fadeIn(300);
        $(this).find('> i').removeAttr('data-dostup');
        $(this).find('> i').removeAttr('class');
        $(this).find('> i').attr('class','fas fa-sort-up arrowDropMenuFilter');
    }
});
$('#regulationPriceMin').blur(function() {
    $.ajax({
        url: location.href,
        type: 'GET',
        beforeSend: function(){
            $('.preloader').fadeIn(300, function(){
                $('.product-one').hide();
            });
        },
        success: function(res){
            $('.preloader').delay(500).fadeOut('slow', function(){
                $('.product-one').html(res).fadeIn();
                if(getURLVar('priceMin') != '' && getURLVar('priceMin') != 'undefined'){
                    const url = new URL(document.location);
                    const searchParams = url.searchParams;
                    searchParams.delete("priceMin"); 
                    searchParams.delete("priceMax"); 
                    window.history.pushState({}, '', url.toString());
                }
                var sign = '';
                if(location.href.indexOf('?') !== -1) {
                    sign = "&";
                }
                else sign = "?";

                window.location.href = window.location + sign + "priceMin=" + $('#regulationPriceMin').val() + "&priceMax=" + $('#regulationPriceMax').val();
            });
        },
        error: function () {
            alert('Ошибка!');
        }
    });
});
$('#regulationPriceMax').blur(function() {
    $.ajax({
        url: location.href,
        type: 'GET',
        beforeSend: function(){
            $('.preloader').fadeIn(300, function(){
                $('.product-one').hide();
            });
        },
        success: function(res){
            $('.preloader').delay(500).fadeOut('slow', function(){
                $('.product-one').html(res).fadeIn();
                if(getURLVar('priceMin') != '' && getURLVar('priceMin') != 'undefined'){
                    const url = new URL(document.location);
                    const searchParams = url.searchParams;
                    searchParams.delete("priceMin"); 
                    searchParams.delete("priceMax"); 
                    window.history.pushState({}, '', url.toString());
                }
                var sign = '';
                if(location.href.indexOf('?') !== -1) {
                    sign = "&";
                }
                else sign = "?";

                window.location.href = window.location + sign + "priceMin=" + $('#regulationPriceMin').val() + "&priceMax=" + $('#regulationPriceMax').val();
            });
        },
        error: function () {
            alert('Ошибка!');
        }
    });
});
/* Search */
var products = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.whitespace,
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    remote: {
        wildcard: '%QUERY',
        url: path + '/search/typeahead?query=%QUERY'
    }
});

products.initialize();

$("#typeahead, #typeahead-m").typeahead({
    // hint: false,
    highlight: true
},{
    name: 'products',
    display: 'title',
    limit: 10,
    source: products
});

$('#typeahead, #typeahead-m').bind('typeahead:select', function(ev, suggestion) {
    // console.log(suggestion);
    window.location = path + '/search/?s=' + encodeURIComponent(suggestion.title);
});








/*Cart*/
$('body').on('click', '.add-to-cart-link', function(e){
    e.preventDefault();
    var id = $(this).data('id'),
        qty = $('.quantity input').val() ? $('.quantity input').val() : 1,
        mod = $('.available select').val();
  
    $.ajax({
        url: '/cart/add',
        data: {id: id, qty: qty, mod: mod},
        type: 'GET',
        success: function(res){
            showCart(res);
        },
        error: function(){
            alert('Ошибка! Попробуйте позже');
        }
    });
});

$('#cart .modal-body').on('click', '.del-item', function(){
    var id = $(this).data('id');
    $.ajax({
        url: '/cart/delete',
        data: {id: id},
        type: 'GET',
        success: function(res){
            showCart(res);
        },
        error: function(){
            alert('Error!');
        }
    });
});

function showCart(cart){
    if($.trim(cart) == 'Корзина пуста'){
        $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'none');
    }else{
        $('#cart .modal-footer a, #cart .modal-footer .btn-danger').css('display', 'inline-block');
    }
    $('#cart .modal-body').html(cart);
    $('#cart').modal();
    if($('.cart-sum').text()){
        $('.simpleCart_total').html($('#cart .cart-sum').text());
    }else{
        $('.simpleCart_total').text('Корзина пуста');
    }
    if($('.cart-qty').text()){
        $('.simpleCart_quantity').html($('#cart .cart-qty').text());
    }else{
        $('.simpleCart_quantity').text('0');
    }

}


function getCart() {
    $.ajax({
        url: '/cart/show',
        type: 'GET',
        success: function(res){
            showCart(res);
        },
        error: function(){
            alert('Ошибка! Попробуйте позже');
        }
    });
}

function clearCart() {
    $.ajax({
        url: '/cart/clear',
        type: 'GET',
        success: function(res){
            showCart(res);
        },
        error: function(){
            alert('Ошибка! Попробуйте позже');
        }
    });
}
/*Cart*/





$('.available select').on('change', function(){
    var modId = $(this).val(),
        color = $(this).find('option').filter(':selected').data('title'),
        price = $(this).find('option').filter(':selected').data('price'),
        basePrice = $('#base-price').data('base');
    if(price){
        $('#base-price').text(symboleLeft + price + symboleRight);
    }else{
        $('#base-price').text(symboleLeft + basePrice + symboleRight);
    }
});

/*Forgot pass*/

$('#forgot').hide();

$('.forgot-pass').click(function () {
    $('#forgot').toggle();
})
// Fast form
$('.fast').hide();

$('.fast_form').click(function () {
    $('.full').hide();
    $('.fast').show();
    $('.register_form').removeClass('active');
    $(this).addClass('active');
});

$('.register_form').click(function () {
    $('.full').show();
    $('.fast').hide();
    $('.fast_form').removeClass('active');
    $(this).addClass('active');
})

$('.np_cities').select2();
$('.np_cities').on('change', function () {
    $.ajax({
        url: '/cart/warehouses',
        type: 'GET',
        data: { np_city_ref: this.value },
        success: function(res){
            $('.np_warehouses').html(res);
            $('.np_warehouses_select').select2();
        }
    });
    // console.log(this.value);
});













// ========== Set Cuerrency in Cookies  
$('.header-item__currency').click(function(){

    // Set cookies Function
    function set_cookie(name, value, exp_y, exp_m, exp_d, path, domain, secure){
        var cookie_string = name + "=" + escape (value);
        if (exp_y){
            var expires = new Date ( exp_y, exp_m, exp_d );
            cookie_string += "; expires=" + expires.toGMTString();
        }
        if(path)
            cookie_string += "; path=" + escape(path);
        if (domain)
            cookie_string += "; domain=" + escape(domain);
        if (secure)
            cookie_string += "; secure";
        document.cookie = cookie_string;
    }

    // Get current date and set 1 year for cookies save
    var current_date = new Date;
    var cookie_year = current_date.getFullYear() + 1;
    var cookie_month = current_date.getMonth();
    var cookie_day = current_date.getDate();
    
    // Set currency and reload page
    set_cookie ("currency", $(this).html(), cookie_year, cookie_month, cookie_day );
    document.location.reload();
});



// ========== Header Dropdown --- Set class if has child 
$(".header-dropdown li").each(function (){
    $(this).has("ul").addClass("has-submenu");  
});



$(".home-slider").owlCarousel({
    items: 1,
    loop: true,
    dots: true,
    smartSpeed: 1000,
    // autoplay: true,
    // autoplayTimeout: 5000,
    // autoplaySpeed: 1000,
});




// Открыть поиск на мобильных
   $(".m-header__search-open").click(function (){
      if(!$(".m-header").hasClass("m-search__active")){
         $(".m-header").addClass("m-search__active");
         $(".m-header").find("input").focus();
         return false;
      }
   });

   // Закрыть поиск на мобильных
   $(".m-header__search-close").click(function (){
      $(this).parents(".m-header").removeClass("m-search__active");
      return false;
   });


$(".m-header__dropdown").click(function (){
   $(this).toggleClass("active"); 
});

// Плюс/минус кол-ва товара
$('.count-control.minus').click(function() {
  var sp = parseFloat($(this).next('.count-value').val());
  if (sp != ("1")){
    $(this).next('.count-value').val(sp - 1);
  };
 });

 $('.count-control.plus').click(function() {
    var sp = parseFloat($(this).prev('.count-value').val());
    $(this).prev('.count-value').val(sp + 1);
 });

