<?php

namespace Demo\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class CompanyTable2 extends TableGateway
{
	const TABLE_NAME = 'company';
	
	public function findAllOrderedByName()
	{
		$select = new Select;
		$select->from(self::TABLE_NAME)
			->order('NAME ASC');
		
		return $this->selectWith($select)->toArray();
	}
	
	public function add($data)
	{
		return $this->insert($data);
	}
}