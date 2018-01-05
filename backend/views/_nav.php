<?php

use balitrip\uikit\Nav;
use balitrip\uikit\NavBar;
use yii\helpers\Html;

$app = Yii::$app->controller->app;


$subnav = [

    ['label' => '<i class="uk-icon-plus"></i> '.Yii::t('zoo','Материал'),
        'linkOptions'=>['class'=>'uk-button-primary'],
        'url' => ['/'.Yii::$app->controller->module->id.'/items/create','app'=>$app->id],],

];

$mainnav = [
    ['label' => '<i class="uk-icon-bars"></i> '.$app->title, 
                'url' => ['/'.Yii::$app->controller->module->id.'/items/index','app'=>$app->id],], 
];

if ($this->context->module->accessRoles !== null || Yii::$app->user->can('admin') || (Yii::$app->user->can('moder') && Yii::$app->user->can('zoo_edit_category'))) {
    $subnav[] = ['label' => '<i class="uk-icon-plus"></i> '.Yii::t('zoo','Категория'),
        'linkOptions'=>['class'=>'uk-button-success'],
        'url' => ['/'.Yii::$app->controller->module->id.'/categories/update','app'=>$app->id],];

    $mainnav = array_merge($mainnav,[
        ['label' => Yii::t('zoo','Категории'),
                'url' => ['/'.Yii::$app->controller->module->id.'/categories/index','app'=>$app->id],], 
        ['label' => Yii::t('zoo','Элементы'),
            'url' => ['/'.Yii::$app->controller->module->id.'/elements/index','app'=>$app->id],], 
        ['label' => Yii::t('zoo','Шаблоны'),
            'url' => ['/'.Yii::$app->controller->module->id.'/templates/index','app'=>$app->id],], 

        ['label' => '<i class="uk-icon-cog"></i>', 
                    'url' => ['/'.Yii::$app->controller->module->id.'/default/update','app'=>$app->id],], 
    ]);
}




$mainnav[] = ['label' => '<i class="uk-icon-external-link-square"></i>', 'url'=>isset($model) && $model !== null ? $model->url : $app->url,'linkOptions'=>['target'=>'_blank']];

if (isset($items) && is_array($items) && count($items)) {
    $subnav = array_merge($items,$subnav);
}

?>
<div class="items-filters">
<?php NavBar::begin(['container'=>false,'offcanvas'=>false,'brandUrl' => false,'options'=>['class'=>'application-nav']]); ?>

    <?=Nav::widget([
        'navbar'=>true,
        'options'=>['data-uk-nav'=>true],
        'items' => $mainnav,
    ]);  ?>

    <div class="uk-navbar-flip">

        <?= Nav::widget([
            'navbar'=>true,
            'options'=>['data-uk-nav'=>true],
            'items' => $subnav,
        ]); ?>

    </div>

<?php NavBar::end(); ?>
</div>