<?php

namespace balitrip\zoo\elements\parsed_category;

use Yii;
use app\modules\admin\models\ParserCategories;

class Element extends \balitrip\zoo\elements\textfield_multiple\Element
{


	public function getValue($attribute) {

		if (isset($this->owner->isSearch) && $this->owner->isSearch) {
			return parent::getValue($attribute);
		}
		else {

			if (!isset($this->owner->values[$attribute])) {
    			$this->loadAttributesFromElements($attribute);
	    	}

	    	$new_values = [];

	    	foreach ($this->owner->values[$attribute] as $v) {

	    		$value = $v['value_string'];
	    			
	    		$category = ParserCategories::find()->where(['source_id'=>$value])->one();

				if ($category !== null) {
					$value = $category->name;
					if ($category->parent !== null) {
						$value = $category->parent->name.' / '.$value;
						if ($category->parent->parent !== null) {
							$value = $category->parent->parent->name.' / '.$value;
						}
					}
				}

				$new_values[] = $value;
	    	}

	    	asort($new_values);

	    	return $new_values;
		}
    }
}