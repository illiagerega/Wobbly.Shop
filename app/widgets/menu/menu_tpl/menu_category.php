
    <?php if(isset($category['childs'])): ?>
            <?= $this->getMenuHtml($category['childs']);?>
    <?php endif; ?>