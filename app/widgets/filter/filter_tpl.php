<style>
    #regulationPriceMin,
    #regulationPriceMax {
        width: 75px;
        border-radius: 10px 10px 10px 10px;
        outline: none;
    }
    .btnClearPriceRegulation {
        background: #c50909;
        width: 85px;
        margin-top: 5px;
        border-radius: 10px 10px 10px 10px;
        cursor: pointer;
        user-select: none;
        -moz-user-select: none;
        -webkit-user-select: none;
    }
    .btnClearPriceRegulation span {
        color: white;
        margin-left: 13%;
    }
    .arrowDropMenuFilter {
        position: absolute;
        right: 30px;
        top: 50%;
        bottom: 0;
        transform: translate(100%, -50%);
        padding-left: 5px;
        cursor: pointer;
    }
    .sky-form h4 {
        position: relative;
    }
</style>
<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
<section  class="sky-form">
    <h4>Ціна (від мін. до макс.)<i data-block-id="hideBlockFilter_1FF" class="fas fa-sort-up arrowDropMenuFilter"></i></h4>
    <div class="row1 scroll-pane" id="hideBlockFilter_1FF">
        <div class="col col-4">
            <?php
            $min = $_GET['priceMin'];
            $max = $_GET['priceMax'];

            if(!empty($min) && !empty($max)) {
                echo '<h1>Ціна (мін.)</h1>';
                echo '<input id="regulationPriceMin" type="text" value="'.$min.'"><i></i>';
            }
            else {
                echo '<h1>Ціна (мін.)</h1>';
                echo '<input id="regulationPriceMin" type="text" value="1"><i></i>';
            }
            
            if(!empty($min) && !empty($max)) {
                echo '<h1>Ціна (макс.)</h1>';
                echo '<input id="regulationPriceMax" type="text" value="'.$max.'"><i></i>';
            }
            else {
                echo '<h1>Ціна (макс.)</h1>';
                echo '<input id="regulationPriceMax" type="text" value="1000000"><i></i>';
            }
            echo '<div class="btnClearPriceRegulation"><span>Скинути</span></div>';
            ?>
                
        </div>
    </div>
</section>
<section  class="sky-form">
    <h4>Сортування по алфавіту<i data-block-id="hideBlockFilter_2FF" class="fas fa-sort-up arrowDropMenuFilter"></i></h4>
    <div class="row1 scroll-pane" id="hideBlockFilter_2FF">
        <div class="col col-4">
            <?php
                if(!empty($_GET['ABC'])) {
                    $checked = ' checked';
                }
                else $checked = null;
            ?>
            <label class="checkbox">
                <input id="inputABC" type="checkbox" name="checkbox" value="1" <?=$checked;?>><i></i>Да
            </label>             
        </div>
    </div>
</section>
<?php foreach($this->groups as $group_id => $group_item): ?>
  <section  class="sky-form">
      <h4><?=$group_item;?><i data-block-id="hideBlockFilter_<?=$group_id;?>" class="fas fa-sort-up arrowDropMenuFilter"></i></h4>
      <div class="row1 scroll-pane" id="hideBlockFilter_<?=$group_id;?>">
          <div class="col col-4">
              <?php if(isset($this->attrs[$group_id])): ?>
              <?php foreach($this->attrs[$group_id] as $attr_id => $value): ?>
                  <?php
                      if(!empty($filter) && in_array($attr_id, $filter)){
                          $checked = ' checked';
                      }else{
                          $checked = null;
                      }
                  ?>
              <label class="checkbox">
                  <input type="checkbox" name="checkbox" value="<?=$attr_id;?>" <?=$checked;?>><i></i><?=$value;?>
              </label>
              <?php endforeach; ?>
              <?php endif; ?>
          </div>
      </div>
  </section>

    
<?php endforeach; ?>

