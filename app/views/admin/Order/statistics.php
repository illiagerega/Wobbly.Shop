<section class="content-header">
    <h1>
        Статистика
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li class="active">Статистика</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <form method="get">
                        <input type="text" id="date_from" name="date_from" style="margin-right: 10px;" autocomplete="off" value="<?=$_GET['date_from']?>">
                        <input type="text" id="date_to" name="date_to" style="margin-right: 10px;" autocomplete="off" value="<?=$_GET['date_to']?>">
                        <select name="status" style="margin-right: 10px;">
                            <option value="-1" <?= $_GET['status'] == -1 ? 'selected' : ''?>>Все</option>
                            <option value="0"  <?= $_GET['status'] == 0 ? 'selected' : ''?>>Незавершённые</option>
                            <option value="1"  <?= $_GET['status'] == 1 ? 'selected' : ''?>>Завершённые</option>
                        </select>
                        <button type="submit" id="apply" style="margin-right: 10px;">Применить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div id="chart_div"></div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="array" value='<?=json_encode($data)?>'>
</section>