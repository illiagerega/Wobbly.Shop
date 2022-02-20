<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование баннера на главной
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Редактирование</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <form action="<?=ADMIN;?>/banner/save" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="banner-items" class="table">
                                <tbody>
                                    <?php $banner_item_row = 0; ?>
                                    <?php foreach($items as $item){ ?>
                                    <tr id="banner-item-<?php echo $banner_item_row; ?>">
                                        <td>
                                             <input type="text" name="item[<?php echo $banner_item_row; ?>][title]" class="form-control" placeholder="Заголовок" value="<?php echo $item['title']; ?>">
                                        </td>
                                        <td>
                                             <input type="text" name="item[<?php echo $banner_item_row; ?>][link]" class="form-control" placeholder="Ссылка" value="<?php echo $item['link']; ?>">
                                        </td>
                                        <td>
                                             <input type="text" name="item[<?php echo $banner_item_row; ?>][button]" class="form-control" placeholder="Кнопка" value="<?php echo $item['button']; ?>">
                                        </td>
                                        
                                        <td>
                                            <input type="file" name="item[<?php echo $banner_item_row; ?>][image]" class="form-control" value="">
                                            <input type="hidden" name="item[<?php echo $banner_item_row; ?>][file_old]" value="<?php echo $item['image']; ?>">
                                        </td>
                                        <td>
                                            <button type="button" onclick="$('#banner-item-<?php echo $banner_item_row; ?>').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>
                                        </td>
                                    </tr>
                                    <?php $banner_item_row++; ?>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td><button onclick="addBannerElement()" type="button" class="btn btn-primary">Добавить элемент</button></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <div class="box-footer">
                        <input type="hidden" name="id" value="<?=$product->id;?>">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</section>
  <script type="text/javascript"><!--
        var banner_item_row = <?php echo $banner_item_row; ?>;

        function addBannerElement() {
            html  = '';
            html += '<tr id="banner-item-' + banner_item_row + '">';
            html +=     '<td>';
            html +=          '<input type="text" name="item[' + banner_item_row + '][title]" class="form-control" placeholder="Заголовок" value="">';
            html +=     '</td>';
            html +=     '<td>';
            html +=          '<input type="text" name="item[' + banner_item_row + '][link]" class="form-control" placeholder="Ссылка" value="">';
            html +=     '</td>';
            html +=     '<td>';
            html +=          '<input type="text" name="item[' + banner_item_row + '][button]" class="form-control" placeholder="Кнопка" value="">';
            html +=     '</td>';
                
            html +=     '<td>';
            html +=         '<input type="file" name="item[' + banner_item_row + '][image]" class="form-control" value="">';
            html +=     '<td>';
            html +=         '<button type="button" onclick="$(\'#banner-item-' + banner_item_row + '\').remove();" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button>';
            html +=     '</td>';
            html += '</tr>';

            $('#banner-items tbody').append(html);
            
            banner_item_row++;
        }
//--></script>
<!-- /.content -->