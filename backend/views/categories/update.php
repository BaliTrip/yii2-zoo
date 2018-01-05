<?php

use balitrip\uikit\ActiveForm;
use balitrip\zoo\models\Categories;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;

$this->title = $model->isNewRecord ? Yii::t('zoo', 'Создание категории') : $model->name;

$this->params['breadcrumbs'][] = ['label' => Yii::t('zoo', 'Приложения'), 'url' => ['/'.Yii::$app->controller->module->id.'/default/index']];
$this->params['breadcrumbs'][] = ['label' => $app->title, 'url' => ['application', 'app' => $app->id]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('zoo', 'Категории'), 'url' => ['categories', 'app' => $app->id]];
$this->params['breadcrumbs'][] = $this->title;

$items = ArrayHelper::map(Categories::find()
    ->where(['app_id' => $model->app_id])
    ->andFilterWhere(['<>', 'id', $model->id])
    ->orderBy('lang, name')
    ->all(), 'id', function ($model) {
    return $model->name . ' / ' . strtoupper($model->lang);
});

?>

<?= $this->render('/_nav', ['model' => $model]) ?>

    <div class="uk-panel uk-panel-box">
        <h2><?= Yii::t('zoo', 'Создание категории') ?></h2>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'layout' => 'stacked', 'field_width' => 'large']); ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'alias')->textInput() ?>

        <?= $form->field($model, 'lang')->dropDownList(Yii::$app->zoo->languages, ['prompt' => 'язык категории']); ?>

        <?= $form->field($model, 'subtitle')->textInput() ?>

        <?= $form->field($model, 'parent_id')
            ->dropDownList($app->catlist, ['prompt' => Yii::t('zoo', 'Корневая категория')]); ?>

        <?= $form->field($model, 'image')->widget(\mihaildev\elfinder\InputFile::className(), [
            'language' => 'ru',
            'controller' => 'elfinder',
            'template' => '<div class="uk-form-row">{input}{button}</div>',
            'options' => ['class' => 'uk-from-controls'],
            'buttonOptions' => ['class' => 'uk-button uk-button-primary'],
            'multiple' => false       // возможность выбора нескольких файлов
        ]); ?>

        <?= $form->field($model, 'preview')->widget(\mihaildev\elfinder\InputFile::className(), [
            'language' => 'ru',
            'controller' => 'elfinder',
            'template' => '<div class="uk-form-row">{input}{button}</div>',
            'options' => ['class' => 'uk-from-controls'],
            'buttonOptions' => ['class' => 'uk-button uk-button-primary'],
            'multiple' => false       // возможность выбора нескольких файлов
        ]); ?>

        <?= $form->field($model, 'state')->checkbox(); ?>

        <hr>

        <?= $form->field($model, 'intro')->widget(\mihaildev\ckeditor\CKEditor::className(), [
            'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions(['elfinder', 'path' => '/'], [
                'preset' => 'standart',
                'allowedContent' => true,
                'height' => '200px',
                'toolbar' => Yii::$app->zoo->cke_editor_toolbar,
                'contentsCss' => Yii::$app->zoo->cke_editor_css,
            ]),
        ]); ?>

        <?= $form->field($model, 'content')->widget(\mihaildev\ckeditor\CKEditor::className(), [
            'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions(['elfinder', 'path' => '/'], [
                'preset' => 'standart',
                'allowedContent' => true,
                'height' => '200px',
                'toolbar' => Yii::$app->zoo->cke_editor_toolbar,
                'contentsCss' => Yii::$app->zoo->cke_editor_css,
            ]),
        ]); ?>

        <?= $form->field($model, 'quote')->widget(\mihaildev\ckeditor\CKEditor::className(), [
            'editorOptions' => \mihaildev\elfinder\ElFinder::ckeditorOptions(['elfinder', 'path' => '/'], [
                'preset' => 'standart',
                'allowedContent' => true,
                'height' => '200px',
                'toolbar' => Yii::$app->zoo->cke_editor_toolbar,
                'contentsCss' => Yii::$app->zoo->cke_editor_css,
            ]),
        ]); ?>

        <hr>

        <?= $form->field($model, 'alternateIds')->widget(\balitrip\zoo\helpers\Select2Widget::className(), [
            'options' => [
                'multiple' => true,
                'placeholder' => 'Choose alternates'
            ],
            'settings' => [
                'width' => '100%',
            ],
            'items' => $items,
        ]); ?>

        <?= $form->field($model, 'metaTitle')->textInput(['maxlength' => true, 'class' => 'uk-width-1-1']) ?>

        <?= $form->field($model, 'metaDescription')->textarea(['rows' => 2, 'class' => 'uk-width-1-1']) ?>

        <?= $form->field($model, 'metaKeywords')->textInput(['maxlength' => true, 'class' => 'uk-width-1-1']) ?>

        <div class="uk-form-row uk-margin-large-top">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('zoo', 'Создать') : Yii::t('zoo', 'Сохранить'), ['class' => 'uk-button uk-button-success uk-button-large']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

<?php

$url = Url::to(['alias-create']);

$script = <<< JS

$('body')

.on('change','#categories-name',function(){ 
    $.post('$url',{name:$('#categories-name').val()},function(data){ 
        if ($('#categories-alias').val()) { 
            UIkit.modal.confirm('Replace alias? '+data.alias, function(){ 
                $('#categories-alias').val(data.alias) 
            }); 
        } else $('#categories-alias').val(data.alias)
    })
})

JS;

$this->registerJs($script, \yii\web\View::POS_READY);