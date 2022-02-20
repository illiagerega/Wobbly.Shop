$(document).ready( function () {
    $('#productTable').DataTable({
        "bLengthChange": false,
        "searching": false,
        "responsive": true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    modifier: {
                        search: 'applied',
                        order: 'applied'
                    }
                }
            },
            'colvis'
        ],
        columnDefs: [
            {
                targets: [3, 5,6,7,9, 10],
                visible: false
            }
        ]
    });

    $('#orderTable').DataTable({
        "bLengthChange": false,
        "searching": false,
        "responsive": true,
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excel',
                exportOptions: {
                    modifier: {
                        search: 'applied',
                        order: 'applied'
                    }
                }
            }
        ]

    });

    $( "#datepicker1" ).datepicker({
        "dateFormat": "yy-mm-dd"
    });
    $( "#datepicker2" ).datepicker({
        "dateFormat": "yy-mm-dd"
    });
} );

$('.delete').click(function(){
    var res = confirm('Подтвердите действие');
    if(!res) return false;
});
$('#date_from').datepicker({
    "dateFormat": "yy-mm-dd"
});
$('#date_to').datepicker({
    "dateFormat": "yy-mm-dd"
});
$('.del-item').on('click', function(){
    var res = confirm('Подтвердите действие');
    if(!res) return false;
    var $this = $(this),
        id = $this.data('id'),
        src = $this.data('src');
    $.ajax({
        url: adminpath + '/product/delete-gallery',
        data: {id: id, src: src},
        type: 'POST',
        beforeSend: function(){
            $this.closest('.file-upload').find('.overlay').css({'display':'block'});
        },
        success: function(res){
            setTimeout(function(){
                $this.closest('.file-upload').find('.overlay').css({'display':'none'});
                if(res == 1){
                    $this.fadeOut();
                }
            }, 1000);
        },
        error: function(){
            setTimeout(function(){
                $this.closest('.file-upload').find('.overlay').css({'display':'none'});
                alert('Ошибка');
            }, 1000);
        }
    });
});

$('.sidebar-menu a').each(function(){
    var location = window.location.protocol + '//' + window.location.host + window.location.pathname;
    var link = this.href;
    if(link == location){
        $(this).parent().addClass('active');
        $(this).closest('.treeview').addClass('active');
    }
});

// CKEDITOR.replace('editor1');
$( '#editor1' ).ckeditor();

$('#reset-filter').click(function(){
    $('#filter input[type=radio]').prop('checked', false);
    return false;
});

$(".select2").select2({
    placeholder: "Начните вводить наименование товара",
    //minimumInputLength: 2,
    cache: true,
    ajax: {
        url: adminpath + "/product/related-product",
        delay: 250,
        dataType: 'json',
        data: function (params) {
            return {
                q: params.term,
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data.items
            };
        }
    }
});

if($('div').is('#single')){
    var buttonSingle = $("#single"),
        buttonMulti = $("#multi"),
        file;
}

if(buttonSingle){
    new AjaxUpload(buttonSingle, {
        action: adminpath + buttonSingle.data('url') + "?upload=1",
        data: {name: buttonSingle.data('name')},
        name: buttonSingle.data('name'),
        onSubmit: function(file, ext){
            if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))){
                alert('Ошибка! Разрешены только картинки');
                return false;
            }
            buttonSingle.closest('.file-upload').find('.overlay').css({'display':'block'});

        },
        onComplete: function(file, response){
            setTimeout(function(){
                buttonSingle.closest('.file-upload').find('.overlay').css({'display':'none'});

                response = JSON.parse(response);
                if(buttonSingle.data('form-name') != undefined){
                    $('.' + buttonSingle.data('name')).html('<img src="/images/' + response.file + '" style="max-height: 150px;"><input type="hidden" name="'+ buttonSingle.data('form-name') +'" value="' + response.file + '">');
                }else{
                    $('.' + buttonSingle.data('name')).html('<img src="/images/' + response.file + '" style="max-height: 150px;">');
                }
                
            }, 1000);
        }
    });
}

if(buttonMulti){
    new AjaxUpload(buttonMulti, {
        action: adminpath + buttonMulti.data('url') + "?upload=1",
        data: {name: buttonMulti.data('name')},
        name: buttonMulti.data('name'),
        onSubmit: function(file, ext){
            if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))){
                alert('Ошибка! Разрешены только картинки');
                return false;
            }
            buttonMulti.closest('.file-upload').find('.overlay').css({'display':'block'});

        },
        onComplete: function(file, response){
            setTimeout(function(){
                buttonMulti.closest('.file-upload').find('.overlay').css({'display':'none'});

                response = JSON.parse(response);
                $('.' + buttonMulti.data('name')).append('<img src="/images/' + response.file + '" style="max-height: 150px;">');
            }, 1000);
        }
    });
}

$('#add').on('submit', function(){
     if(!isNumeric( $('#category_id').val() )){
         alert('Выберите категорию');
         return false;
     }
});

$('#edit_ttn').on('dblclick', function () {
    if($(this).children()[0].nodeName != 'INPUT') {
        let value = this.innerText;
        let input = $("<input type='text' id='edit_ttn_input'>").val(value);
        $(this).html(input);
    }
});
$('#edit_ttn').keypress(function (e) {
    let key = e.which;
    if(key == 13)  // the enter key code
    {
        let value = $("#edit_ttn_input").val();
        let id = $("#edit_order_id").text();
        $.ajax({
            url: adminpath + '/order/ttn',
            data: {ttn: value, id: id},
            type: 'GET',
            success: function(res){
                let text = $("<text></text>").text(value);
                $("#edit_ttn").html(text);
            }
        });
    }
});

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
diagram();
function diagram(){
    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawLineColors);

    function drawLineColors() {
        var data = new google.visualization.DataTable();
        //data.addColumn('number', 'X');
        data.addColumn('date', 'Days');
        data.addColumn('number', 'Незавершённые');
        data.addColumn('number', 'Завершённые');

        // data.addRows([
        //     [0, 0, 0],    [1, 10, 1],   [2, 23, 2],  [3, 17, 3],   [4, 18, 10],  [5, 9, 5],
        //     [6, 11, 3],   [7, 27, 19],  [8, 33, 25],  [9, 40, 32],  [10, 32, 24], [11, 35, 27],
        //     [12, 30, 22], [13, 40, 32], [14, 42, 34], [15, 47, 39], [16, 44, 36], [17, 48, 40],
        //     [18, 52, 44], [19, 54, 46], [20, 42, 34], [21, 55, 47], [22, 56, 48], [23, 57, 49],
        //     [24, 60, 52], [25, 50, 42], [26, 52, 44], [27, 51, 43], [28, 49, 41], [29, 53, 45],
        //     [30, 55, 47], [31, 60, 52], [32, 61, 53], [33, 59, 51], [34, 62, 54], [35, 65, 57],
        //     [36, 62, 54], [37, 58, 50], [38, 55, 47], [39, 61, 53], [40, 64, 56], [41, 65, 57]
        // ]);
        let info = [];
        let array = JSON.parse($('#array').val());
        for(key in array){
            info.push([new Date(key), array[key][0], array[key][1]]);
        }
        data.addRows(info);
        var options = {
            hAxis: {
                format: 'dd.M',
                maxValue: new Date(),
                title: 'Дата'
            },
            vAxis: {
                title: 'Количество',
                format: '#',
                minValue: 0,
                maxValue: 15
            },
            colors: ['#a52714', '#097138'],
            height: 400
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
}