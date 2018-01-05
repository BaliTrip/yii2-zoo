<?php
/**
 * @link https://github.com/balitrip/yii2-user
 * @copyright Copyright (c) 2014 Evgeny Zakirov
 * @license http://opensource.org/licenses/MIT MIT
 */
namespace balitrip\zoo\backend\controllers;

use Yii;

use balitrip\zoo\backend\models\Applications;

use yii\base\InvalidConfigException;
use yii\web\NotFoundHttpException;

class Controller extends \yii\web\Controller
{
    private $application;

    public function render($view, $params = [])
    {
        \balitrip\zoo\assets\AdminAsset::register($this->view);
        return parent::render($view, $params);
    }

    public function getApp() {

        if ($this->application === null) 

            if (($this->application = Applications::findOne(Yii::$app->request->get('app'))) === null)

                throw new NotFoundHttpException('The requested page does not exist.');
            
        return $this->application;
    }

    public function afterAction($action, $result)
    {
        Yii::$app->getUser()->setReturnUrl(Yii::$app->request->url);
        return parent::afterAction($action, $result);
    }
}
