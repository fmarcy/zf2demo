<?php

namespace Demo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Demo\Model\CompanyTable;

class TableGatewayDemoController extends AbstractActionController
{
	protected $companyTable;
	
	public function __construct(CompanyTable $companyTable)
	{
		$this->companyTable = $companyTable;
	}
	
	public function indexAction()
	{
		$companies = $this->companyTable->findAllOrderedByName();
		
		return compact('companies');
	}
	
	public function insertCompanyAction()
	{ 
		$company = array('name' => $this->params('name'));
		
		$this->companyTable->insert($company);
		
		return $this->redirect()->toRoute('demo/tablegateway');
	}
}