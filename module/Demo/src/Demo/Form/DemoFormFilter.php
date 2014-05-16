<?php

namespace Demo\Form;

use Zend\InputFilter\InputFilter;
use Zend\Validator\Between;

class DemoFormFilter extends InputFilter
{
	public function __construct()
	{
		$this->add(array(
			'name' => 'number',
			'required' => false,
			'validators' => array(
				array(
					'name' => 'Between',
					'options' => array(
						'min' => 1,
						'max' => 10,
						'messages' => array(
							Between::NOT_BETWEEN => "%value% n'est pas entre %min% et %max%",
						),
					),
				),
			),
		));
	}
}