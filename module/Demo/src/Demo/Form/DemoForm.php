<?php

namespace Demo\Form;

use Zend\Form\Form;

class DemoForm extends Form
{
	public function __construct()
	{
		parent::__construct('demo_form');
		
		$this->setAttributes(array(
			'method' => 'post',
			'class' => 'form-horizontal',
			'role' => 'form',
		));
		
		$this->add(array(
			'type' => 'Text',
			'name' => 'number',
			'options' => array(
				'label' => 'Chiffre :',
				'label_attributes' => array(
					'class' => 'col-sm-2 control-label',
				),
			),	
			'attributes' => array(
				'type' => 'text',
				'placeholder' => 'Entier entre 1 et 10',
				'class' => 'form-control',
			),
			'filters' => array(
				
			)
		));
		
		$this->add(array(
			'type' => 'Csrf',
			'name' => 'csrf',
			'options' => array(
				'label' => 'Token :',
				'label_attributes' => array(
					'class' => 'col-sm-2 control-label',
				),
				'csrf_options' => array(
					'message' => 'Protection CSRF !',
				),
			),	
			'attributes' => array(
				'type' => 'text',
				'class' => 'form-control',
			),
		));
		
		$this->add(array(
			'type' => 'Button',
			'name' => 'submit',
			'options' => array(
				'label' => 'Valider',
			),
			'attributes' => array(
				'type' => 'submit',
				'value' => 'Valider',
				'class' => 'btn btn-primary',
			),
		));
	}
}