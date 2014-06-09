<?php
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Expression as Espressione;
use Zend\Db\TableGateway\Feature\GlobalAdapterFeature;
use Zend\Db\TableGateway\Feature\EventFeature as EventDbManager;
use Zend\Db\TableGateway\Feature\FeatureSet;


class Product extends TableGateway{
	
	public function __construct()
	{
		$this->table = 'PRODUCT';
		$this->featureSet = new FeatureSet();
		$this->featureSet->addFeature(new GlobalAdapterFeature());
		$this->initialize();
	}
	
	
	public function fetchPairs()
	{
		$sql= new \Zend\Db\Sql\Sql($this->getAdapter());
		$select = $sql->select();
		$select->from($this->table);
		$rs=$this->selectWith($select)->toArray();
		$return[0]= null;
		foreach ($rs as $row) {
			$row = array_values($row);
			$return[$row[0]] = $row[1];
		}
	
		return $return;
	}
}

?>