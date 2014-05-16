<?php

namespace Demo\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Demo\Form\DemoForm;

class DemoFormFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceManager)
	{
		$demoForm = new DemoForm;
		$demoFormFilter = $serviceManager->get('demo-form-filter');
		$demoForm->setInputFilter($demoFormFilter);
		
		return $demoForm;
	}
}