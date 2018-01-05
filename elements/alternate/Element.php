<?php

namespace balitrip\zoo\elements\alternate;

use Yii;

class Element extends \balitrip\zoo\elements\BaseElementBehavior
{

    public function rules($attributes)
    {
        return [
            [$attributes, 'safe'],
            //[$attributes,'required'],
        ];
    }

    public $multiple = true;

    public $value_field = 'value_string';

    public function LoadAttributesFromElements($attribute)
    {
        $value = [];

        foreach ($this->owner->itemsElements as $element) {
            if ($element->element == $attribute) {

                if ($element->value_string !== null)

                    $value[] = [
                        'id' => $element->id,
                        'value_text' => $element->value_text,
                        'value_int' => $element->value_int,
                        'value_string' => $element->value_string,
                        'value_float' => $element->value_float,
                    ];
            }
        }

        return $this->owner->values[$attribute] = $value;
    }

    public function getAlternates() {
        return \balitrip\zoo\models\Items::find()->where(['id'=>$this->getValue('alternate')])->all();
    }

    public function setValue($attribute, $value)
    {

        /*if (!isset($this->owner->values[$attribute])) {
            $this->loadAttributesFromElements($attribute);
        }*/

        $va = [];

        if (is_array($value)) {

            foreach ($value as $key => $v) {


                if ($v !== null) {

                    $a = [
                        'value_text' => null,
                        'value_int' => null,
                        'value_string' => null,
                        'value_float' => null,
                    ];

                    $a[$this->value_field] = $v;

                    $va[] = $a;
                }
            }

        }

        $this->owner->values[$attribute] = $va;

        return true;
    }

}