<?php session_start(); ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Переход к оплате</title>
</head>
<body>

<p>Через несколько секунд Вы будете перенаправлены на страницу оплаты...</p>

<form action="<?php echo $action ?>" method="post" id="payments">
    <?php
    foreach ($fields as $k => $v) {
        if(is_array($v)){
            foreach ($v as $vv) {
                echo "<input type=\"hidden\" name=\"{$k}[]\" value=\"{$vv}\" />";
            }
        } else {
            echo "<input type=\"hidden\" name=\"{$k}\" value=\"{$v}\" />";
        }

    }
    ?>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script>
    setTimeout(function(){
        $('form').submit();
    }, 2000);
</script>

</body>
</html>