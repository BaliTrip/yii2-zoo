<?php

namespace worstinme\zoo\backend;

use Yii;
class Module extends \yii\base\Module
{
    public $controllerNamespace = 'worstinme\zoo\backend\controllers';

    public $itemTemplates = [
        'form',
        'user_form',
        'full',
        'teaser',
        'related',
    ];

    public function init()
    {
        parent::init();

        $this->registerTranslations();      
    }

    public function registerTranslations()
	{
	    Yii::$app->i18n->translations['backend'] = [
	        'class' => 'yii\i18n\PhpMessageSource',
	        'sourceLanguage' => 'ru-RU',
	        'basePath' => '@worstinme/zoo/messages',
	    ];
	}

    public function getElements() {

        return [
            'category'=>'Выбор категории',
            'select'=>'Список вариантов',
            'textarea'=>'Текст / Редактор',
            'textfield'=>'Текстовое поле / Строка',
            'textfield_multiple'=>'Текстовое поле / _multiple',
            'units'=>'units',
            'slug'=>'slug',
            'name'=>'name',
            'price'=>'price',
            'images'=>'images',
            'color'=>'color',
            'buy'=>'buy',
            'parsed_category'=>'parsed_category',
        ];

    }
	

	public static function t($category, $message, $params = [], $language = null)
	{
	    return Yii::t('modules/zoo/' . $category, $message, $params, $language);
	}

}