<?php

namespace Demo\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Demo\Controller\PostDemo1Controller;

class PostDemo1ControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $controllerManager)
	{
		// Le service manager récupère les dépendances (ici le formulaire)
		$serviceManager = $controllerManager->getServiceLocator();
		$demoForm = $serviceManager->get('demo-form');
		
		// ... et les injecte dans le controller
		return new PostDemo1Controller($demoForm);
	}
}