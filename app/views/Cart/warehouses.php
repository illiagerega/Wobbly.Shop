<select class="np_warehouses_select" name="npWarehouse">
    <?php foreach ($_SESSION['np.warehouses'] as $row) { ?>
        <option value="<?=$row['Description']?>"><?=$row['Description']?></option>
    <?php } ?>
</select>