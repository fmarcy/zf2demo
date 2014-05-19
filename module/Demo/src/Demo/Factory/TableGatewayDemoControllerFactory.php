<?php

namespace Demo\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Demo\Controller\TableGatewayDemoController;

class TableGatewayDemoControllerFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $controllerManager)
	{
		$serviceManager = $controllerManager->getServiceLocator();
		$companyTable = $serviceManager->get('company-table');
		
		return new TableGatewayDemoController($companyTable);
	}
}