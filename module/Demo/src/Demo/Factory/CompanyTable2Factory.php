<?php

namespace Demo\Factory;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Demo\Model\CompanyTable2;

class CompanyTable2Factory implements FactoryInterface
{
	public function createService(ServiceLocatorInterface $serviceLocator)
	{
		$dbAdapter = $serviceLocator->get('db-adapter');
		
		return new CompanyTable2(CompanyTable2::TABLE_NAME, $dbAdapter);
	}
}
