<?php

namespace balitrip\zoo\widgets\models;

use Yii;
use balitrip\zoo\backend\models\Menu as M;

class Menu extends \yii\base\Model
{
    public $menu;
    public $class;
    public $navbar;

    public static function getName() {
        return 'Menu';
    }

    public static function getDescription() {
        return 'Widget that renders menu';
    }

    public static function getFormView() {
        return '@balitrip/zoo/widgets/forms/menu';
    }

    public function rules()
    {
        return [
            ['menu','required'],
            [['menu','class'],'string','max'=>255],
            [['navbar'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'menu' => 'Menu'
        ];
    }

    public function getMenuList() {
        return M::find()->select(['menu'])->distinct()->indexBy('menu')->column();
    }

}
