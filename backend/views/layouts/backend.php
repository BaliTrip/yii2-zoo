<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use balitrip\uikit\Nav;
use balitrip\uikit\NavBar;
use balitrip\uikit\Alert;
use balitrip\uikit\Breadcrumbs;
use yii\helpers\ArrayHelper;

\balitrip\zoo\assets\AdminAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="admin">
<?php $this->beginBody() ?>

<?php NavBar::begin(['container'=>true,'offcanvas'=>true]); ?>
    
    <?= Nav::widget([
        'navbar'=>true,
        'options'=>['class'=>'uk-hidden-small'],
        'items' => [
            ['label' => '<i class="uk-icon-bars"></i> Приложения', 'url' => ['/zooadmin/default/index'],
                'items'=> ArrayHelper::toArray(Yii::$app->zoo->applications,[
                    'balitrip\zoo\models\Applications' => [
                        'label'=>'title',
                        'url'=>function ($app) {
                            return ['/zooadmin/items/index','app'=>$app->id];
                        },
                    ],
                ]),
            ], 
            ['label' => 'Виджеты', 'url' => ['/widgets/default/index'],],
            ['label' => 'Настройки','encodeLabels'=>false, 'url' => ['/zooadmin/config/index'],],
            ['label' => 'Файлы','encodeLabels'=>false, 'url' => ['/zooadmin/elfinder/index']],
            ['label' => 'Меню', 'url' => ['/zooadmin/menu/index']], 
            ['label' => 'Пользователи','encodeLabels'=>false, 'url' => ['/useradmin/default/index'],], 

        ],
    ]);?>
    
    <div class="uk-navbar-flip">

        <?= Nav::widget([
            'navbar'=>true,
            'options'=>['class'=>'uk-hidden-small'],
            'items' => [    
                ['label'=>'<i class="uk-icon-home"></i>','encodeLabels'=>false,'url'=>'/','linkOptions'=>['target'=>'_blank']], 
                Yii::$app->user->isGuest ?
                    ['label' => 'Войти', 'url' => ['/user/default/login'],
                        'items'=>[
                            ['label' => 'Зарегистрироваться', 'url' => ['/user/default/signup'],]
                        ]
                    ] :
                    ['label' =>Yii::$app->user->identity->username,'url' => ['/user/default/update'],
                        'items'=>[
                            ['label' => 'Выйти',
                                                    'url' => ['/user/default/logout'],
                                                    'linkOptions' => ['data-method' => 'post'],]
                        ]
                    ],
            ],
        ]); ?>

    </div>

<?php NavBar::end(); ?>

<section id="content" class="uk-container uk-container-center uk-margin-top">  
    <?= Alert::widget() ?>
    <?= Breadcrumbs::widget(['homeLink' => ['label' => 'Админка','url' => ['/zooadmin/default/index'],],'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]) ?>
    <?= $content ?>
</section>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
