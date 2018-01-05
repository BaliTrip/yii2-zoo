<?php

namespace balitrip\zoo\backend;

use Yii;
use balitrip\zoo\helpers\AppHelper;
use yii\helpers\Inflector;

class Module extends \yii\base\Module
{
    public $accessRoles;

    public $controllerNamespace = 'balitrip\zoo\backend\controllers';

    public $layout = '@balitrip/zoo/backend/views/layouts/backend';

    public function init()
    {
        $this->registerTranslations();
    }

    public function registerTranslations()
	{
	    Yii::$app->i18n->translations['zoo'] = [
	        'class' => 'yii\i18n\PhpMessageSource',
	        'sourceLanguage' => 'ru-RU',
	        'basePath' => '@balitrip/zoo/messages',
	    ];

	    foreach ($this->elements as $key=>$element) {
            Yii::$app->i18n->translations['zoo/'.$key] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'ru-RU',
                'basePath' => '@balitrip/zoo/elements/'.$key.'/messages',
                'fileMap' => [
                    'zoo/'.$key => 'element.php',
                ],
            ];
        }

	}

    public function getElements() {

        $files = AppHelper::findDirectories(Yii::getAlias('@balitrip/zoo/elements'));

        $files = array_unique(array_merge($files, AppHelper::findDirectories(Yii::getAlias(Yii::$app->zoo->elementsPath))));

        $elements = [];

        foreach ($files as $file) {
            $elements[$file] = Inflector::camel2words($file);
        }

        return $elements;

    }

	public static function t($category, $message, $params = [], $language = null)
	{
	    return Yii::t('modules/zoo/' . $category, $message, $params, $language);
	}

}