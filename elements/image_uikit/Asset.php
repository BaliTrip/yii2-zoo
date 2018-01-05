<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace balitrip\zoo\elements\image_uikit;

use yii\web\AssetBundle;

class Asset extends AssetBundle
{
    public $sourcePath = '@balitrip/zoo/elements/image_uikit';
    public $css = [
        'style.css',
    ];
    public $js = [
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'balitrip\uikit\UikitAsset',
    ];
}
