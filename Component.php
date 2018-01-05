<?php

namespace balitrip\zoo;

use Yii;
use yii\base\InvalidConfigException;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use balitrip\zoo\models\Applications;
use balitrip\zoo\backend\models\Widgets;
use balitrip\zoo\backend\models\Config;

class Component extends \yii\base\Component { 

	public $elementsPath = '@app/components/elements';
	public $defaultLang = 'ru';
	public $frontendPath;

	public $cke_editor_toolbar = [
		['Bold', 'Italic','Underline','-','NumberedList', 'BulletedList', '-', 'Link', 'Unlink','Styles','Font','FontSize','Format','TextColor','BGColor','-','Blockquote','CreateDiv','-','Image','Table','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','Outdent','Indent','-','RemoveFormat','Source','Maximize']
	];

	public $cke_editor_css;
	public $languages = [];
	public $callbacks = [];

	private $menu;

    public function getMenu() {

		if ($this->menu === null) {
			$this->menu = new \balitrip\zoo\models\Menu;
		}

		return $this->menu;
	}

    public function findShortcodes($content) {

        $shortcode = new \balitrip\zoo\helpers\ShortcodeHelper;
        $shortcode->callbacks = $this->callbacks();

        return $shortcode->parse($content);
    }

    public function callbacks() {

        return array_merge([
            'uk-slideshow'=>['balitrip\uikit\widgets\Slideshow','widget'],
            'widget'=>['balitrip\widgets\widgets\WidgetId','widget'],
            'teaser'=>['balitrip\zoo\widgets\Teaser','widget'],
            'youtube'=>['balitrip\zoo\widgets\Youtube','widget'],
        ],$this->callbacks);
    }

	public function config($name, $default = null) {

		if (($config = Config::find()->where(['name'=>$name])->one()) !== null) {
			return $config->value;
		}

		return $default;
	}

	public function getConfigs($name, $additions = [], $after = false) {
	    $column = Config::find()->select('value')->where(['name'=>$name])->indexBy('id')->column();
	    if (count($additions) && is_array($additions)) {
	        return $after ? $column + $additions : $additions + $column;
        }
	    return $column;
    }

    public function getConfigValues($ids, $separator = ", ", $additions = []) {
        $column = Config::find()->select('value')->where(['id'=>$ids])->column();
        if (count($additions) && is_array($additions)) {
            foreach ($ids as $id) {
                if (isset($additions[$id])) {
                    $column[] = $additions[$id];
                }
            }
        }
        return implode($separator, $column);
    }

  	public function getLang() {
  	  	return Yii::$app->request->get('lang',$this->defaultLang);
    }

    public function getApplications() {
    	return Applications::find()->where(['app_alias'=>[$this->frontendPath,'@app']])->indexBy('id')->all();
    }

}