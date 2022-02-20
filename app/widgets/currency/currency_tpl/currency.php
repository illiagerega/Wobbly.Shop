<div class="header-item__button">
   <span class="header-item__label">Валюта:</span>
   <span class="header-item__title"><?=$this->currency['code'];?></span>
</div>
<?php $count = count($this->currencies); if($count > 1): ?>
	<ul>	
		<?php foreach($this->currencies as $k => $v): ?>
   		<?php if($k != $this->currency['code']): ?>
				<li><a class="header-item__currency"><?=$k;?></a></li>
			<?php endif; ?>
		<?php endforeach; ?>
	</ul>	
<?php endif; ?>