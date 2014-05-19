<?php

namespace Demo\Model;

use Zend\Db\Adapter\Adapter as DbAdapter;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;

class CompanyTable
{
	protected $tableGateway;
	const TABLE_NAME = 'company';
	
	public function __construct(DbAdapter $dbAdapter)
	{
		$this->tableGateway = new TableGateway(self::TABLE_NAME, $dbAdapter);
	}
	
	public function findAllOrderedByName()
	{
		$select = new Select;
		$select->from(self::TABLE_NAME)
			->order('NAME ASC');
		
		return $this->tableGateway->selectWith($select)->toArray();
	}
	
	public function insert(array $data)
	{
		$this->tableGateway->insert($data);
	}
}