<div class="uk-form-row row<?=$row['class']?' '.$row['class']:''?>">
	<?=!empty($row['name'])?'<h2>'.$row['name'].'</h2>':''?>
	<div class="uk-grid">	
	<?php $k=0; foreach ($row['items'] as $items): ?>
		<?php if (count($items)): ?>
			<?php if ($k==0): $k=1;?>
			<div class="uk-width-2-3">	
			<?php else: $k = 0; ?>
			<div class="uk-width-1-3">
			<?php endif ?>
			
				<?php foreach ($items as $attribute)
					echo $this->render('/items/_element',['model'=>$model,'attribute'=>$attribute['name'],
						'params'=>isset($attribute['params']) ? $attribute['params'] : null,'form'=>$form]) ?>
			</div>
		<?php endif ?>
	<?php endforeach ?>
	</div>
</div>