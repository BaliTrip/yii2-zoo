<?php

use worstinme\uikit\ActiveForm;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $model->isNewRecord ? Yii::t('backend','Создание элемента') : $model->title;

$this->params['breadcrumbs'][] = ['label' => Yii::t('backend','Приложения'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::$app->controller->app->title, 'url' => ['/'.Yii::$app->controller->module->id.'/items/index','app'=>Yii::$app->controller->app->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('backend','Элементы'), 'url' => ['elements','app'=>$app->id]];
$this->params['breadcrumbs'][] = $this->title;

$js = <<<JS

	$("#elements-allcategories").on("click",function(){
		console.log($(this).val());
		if ($(this).is(":checked")) {
			$('.field-elements-categories').addClass('uk-hidden')
		}
		else {
			$('.field-elements-categories').removeClass('uk-hidden')
		}
	})

JS;

$this->registerJs($js, $this::POS_READY);

?>

<div class="applications categories update">
	<div class="uk-grid uk-grid-small">
		
		<div class="uk-width-medium-5-6">

		<div class="uk-panel-box">
		
		<h2><?=$this->title?></h2>

		<?php $form = ActiveForm::begin(['id' => 'login-form','layout'=>'stacked','field_width'=>'full']); ?>    

			<div class="uk-grid">

				<div class="uk-width-medium-2-3 uk-margin">

					<?= $form->field($model, 'type')->dropdownlist(Yii::$app->controller->module->elements,['prompt'=>' ','disabled'=>'disabled'])?>

					<?= $form->field($model, 'title')->textInput(["data-aliascreate"=>"#elements-name"])  ?>

				    <?= $form->field($model, 'name')->textInput(['placeholder'=>'^[\w_]+'])  ?>

			    </div>

			    <div class="uk-width-medium-1-3 uk-margin">

				    <?= $form->field($model, 'required')->checkbox() ?>

					<?= $form->field($model, 'filter')->checkbox() ?>

					<?= $form->field($model, 'filterAdmin')->checkbox() ?>

					<?= $form->field($model, 'refresh')->checkbox() ?>

					<hr>

					<div class="uk-form-row uk-margin-large-top">
				        <?= Html::submitButton($model->isNewRecord ? Yii::t('backend','Создать') : Yii::t('backend','Сохранить'),['class'=>'uk-button uk-button-success uk-button-large']) ?>
				    </div>

			    </div>

			    <div class="uk-width-medium-1-1 uk-margin">

			    	<?=$this->render($model->settingsView,[
			    			'model'=>$model,
			    			'form'=>$form,
			    		])?>

			    </div>

				<div class="uk-width-medium-2-3 uk-margin">

					<legend>Зависимости:</legend>

					<?= $form->field($model, 'allcategories')->checkbox() ?>

					<?= $form->field($model, 'categories',['options'=>['class'=>$model->allcategories == 1?'uk-hidden':'']])->dropdownlist($app->catlist,['multiple' => 'multiple','size'=>(count($app->catlist) > 9 ? 10 : count($app->catlist)+3)]) ?>

					<legend class="uk-margin-top">Данные для формы и фильтра:</legend>

					<?= $form->field($model, 'placeholder')->textInput()  ?>
				</div>

				<div class="uk-width-medium-1-3 uk-margin">

				</div>
				

			</div>

		<?php ActiveForm::end(); ?>
		</div>
		</div>
		<div class="uk-width-medium-1-6">
			<?=$this->render('/_nav',['app'=>$app])?>
		</div>
	</div>
</div>

<?php

$alias_create_url = Url::toRoute(['/'.Yii::$app->controller->module->id.'/default/alias-create']);

$script = <<< JS

(function($){

	$("[data-aliascreate]").on('change',function(){
		var item = $(this),aliastarget = $($(this).data('aliascreate'));
		$.post('$alias_create_url',{alias:item.val(),'nodelimiter':'true'}, function(data) {
				aliastarget.val(data);
				aliastarget.trigger( "change" );
		});
	});

})(jQuery);

JS;

$this->registerJs($script,\yii\web\View::POS_END);