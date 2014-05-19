<?php

namespace Demo\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Demo\Model\CompanyTable;

class CompanyTableFactory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbAdapter = $serviceLocator->get('db-adapter');
		
		return new CompanyTable($dbAdapter);
	}
}