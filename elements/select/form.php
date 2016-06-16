<?php

use yii\helpers\Html;

$this->registerJs($model->addValidators($this,$attribute), 5);

?>

<?= Html::activeLabel($model, $attribute, ['class'=>'uk-form-label']); ?>

<div class="uk-from-controls">
	<?= Html::activeDropDownList($model, $attribute, $element->variants, ['option' => 'value']); ?>
	<div class="uk-form-help-block uk-text-danger"></div>
</div>
