<?php

namespace balitrip\zoo\helpers;

use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Html;

class TemplateHelper
{
    public static $types = [
        'column-1' => ['tag'=>false],
        'column-2' => ['tag'=>'div','options'=>['data'=>['uk-grid-margin'=>""],'class'=>'uk-grid uk-grid-width-medium-1-2 uk-grid-match'],'itemTag'=>'div'],
        'column-3' => ['tag'=>'div','options'=>['class'=>'uk-grid uk-grid-width-medium-1-3'],'itemTag'=>'div'],
        'double-2-1' => ['tag'=>'div','options'=>['class'=>'uk-grid uk-grid-width-medium-2-3'],'itemTag'=>'div'],
        'double-1-2' => ['tag'=>'div','options'=>['class'=>'uk-grid uk-grid-width-medium-1-3'],'itemTag'=>'div'],
        'triple-3-1' => ['tag'=>'div','options'=>['class'=>'uk-grid uk-grid-width-medium-3-4'],'itemTag'=>'div'],
        'triple-1-3' => ['tag'=>'div','options'=>['class'=>'uk-grid uk-grid-width-medium-1-4'],'itemTag'=>'div'],
        'list' => ['tag'=>'ul','options'=>['class'=>'uk-list'],'itemTag'=>'li'],
        'space' => ['delimiter'=>"\n"],
        'comma'     => ['delimiter'=>', '],
    ];

    public static function types() {
        return array_keys(self::$types);
    }

    public static function render($model,$templateName) {

        if ($model === null) {
            throw new InvalidParamException("wrong model");
        }

        $template = $model->getTemplate($templateName);

        $html = null;

        if (is_array($template['rows']) && count($template['rows'])) {

            foreach ($template['rows'] as $position=>$row) {

                $html .= self::renderRow($model,$row,$templateName);

            }
        }

        return $html;

    }

    public static function renderPosition($model,$templateName,$position) {

        if ($model === null) {
            throw new InvalidParamException("wrong model");
        }

        $template = $model->getTemplate($templateName);

        $html = null;

        if (is_array($template['rows']) && !empty($template['rows'][$position])) {

            $html .= self::renderRow($model,$template['rows'][$position],$templateName);

        }

        return $html;
    }

    protected static function renderRow($model,$row,$templateName = null) {

        if (!empty($row['items'])) {

            $html = null;

            $items = static::renderItems($model,$row['items'],$templateName);

            if (count($items)) {

                $type = !empty($row['type']) && in_array($row['type'],self::types()) ?
                    self::$types[$row['type']] :
                    ['tag'=>null,'class'=>null,'delimiter'=>"\n"];

                if (!empty($type['tag']) && !empty($type['options']) && count($items) > 1) {
                    $html .= Html::beginTag($type['tag'],$type['options']);
                }

                foreach ($items as $elements) {

                    if (!empty($type['itemTag']) && $templateName != 'form') {
                        $html .=  Html::beginTag($type['itemTag']);
                    }

                    foreach ($elements as $element) {
                        $html .= $element;
                    }

                    if (!empty($type['itemTag']) && $templateName != 'form') {
                        $html .= Html::endTag($type['itemTag']);
                    }

                }

                if (!empty($type['tag']) && !empty($type['options']) && count($items) > 1) {
                    $html .= Html::endTag($type['tag']);
                }

            }

        }

        return $html;

    }

    protected static function renderItems($model,$items,$templateName,$array=[]) {

        if (is_array($items) && count($items)) {

            foreach ($items as $item) {

                $elements = [];

                if (!empty($item['element'])) {

                    if (($a = self::renderElement($model, $item['element'], !empty($item['params'])?$item['params']:[],$templateName)) !== null) {
                        $elements[] = $a;
                    }

                    if (!empty($item['items']) && is_array($item['items'])) {

                        foreach ($item['items'] as $it) {
                            if (!empty($it['element'])) {
                                if (($b = self::renderElement($model, $it['element'], !empty($it['params'])?$it['params']:[],$templateName)) !== null) {
                                    $elements[] = $b;
                                }
                            }
                        }

                    }

                }

                if (count($elements)) {
                    $array[] = $elements;
                }

            }

        }

        return $array;

    }

    public static function renderElement($model,$attribute,$params = [],$templateName = null) {


        if (!empty($model->elements[$attribute]) && (!empty($model->$attribute) || $templateName == 'form' || $templateName == 'submission')) {

            $element = $model->elements[$attribute];

            if ($templateName == 'form') {

                $element_view_path = '@app/views/'.$model->app->name.'/elements/'.$attribute.'_form.php';

                if (!is_file(Yii::getAlias($element_view_path))) {
                    $element_view_path = '@balitrip/zoo/elements/'.$element->type.'/form.php';
                }

                $refresh = $element->refresh ? 'refresh' : '';

                if (in_array($attribute, $model->renderedElements)) {

                    return '<div class="uk-form-row element element-'.$attribute.' '.$refresh.'">'.Yii::$app->view->render($element_view_path,[
                            'model'=>$model,
                            'attribute'=>$attribute,
                            'element'=>$element,
                            'params'=>$params,
                        ]).'</div>';

                }
                else return '<div class="uk-form-row uk-hidden element element-'.$attribute.' '.$refresh.'"></div>';

            }
            elseif ($templateName == 'submission') {

                $element_view_path = '@app/views/'.$model->app->name.'/elements/'.$attribute.'_submission.php';

                if (!is_file(Yii::getAlias($element_view_path))) {

                    $element_view_path = '@app/views/'.$model->app->name.'/elements/'.$attribute.'_form.php';

                    if (!is_file(Yii::getAlias($element_view_path))) {
                        $element_view_path = '@balitrip/zoo/elements/'.$element->type.'/form.php';
                    }
                }

                $refresh = $element->refresh ? 'refresh' : '';

                if (in_array($attribute, $model->renderedElements)) {

                    return '<div class="uk-form-row element element-'.$attribute.' '.$refresh.'">'.Yii::$app->view->render($element_view_path,[
                            'model'=>$model,
                            'attribute'=>$attribute,
                            'element'=>$element,
                            'params'=>$params,
                        ]).'</div>';

                }
                else return null;

            }
            else {

                $element_view_path = '@app/views/'.$model->app->name.'/elements/'.$attribute.'.php';

                if (!is_file(Yii::getAlias($element_view_path))) {
                    $element_view_path = '@balitrip/zoo/elements/'.$element->type.'/view.php';
                }

                $t = Yii::$app->view->render($element_view_path,[
                    'model'=>$model,
                    'attribute'=>$attribute,
                    'element'=>$element,
                    'params'=>$params,
                ]);

                return $templateName == 'blank' ? $t : '<div class="element element-'.$attribute.'">'.$t.'</div>';

            }



        }

        return null;

    }

}