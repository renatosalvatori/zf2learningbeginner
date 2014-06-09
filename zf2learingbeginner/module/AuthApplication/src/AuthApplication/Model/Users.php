<?php
namespace AuthApplication\Model;

use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\TableGateway\Feature;
use Zend\Db\Sql;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;
use Zend\Db\Sql\Expression;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;
use Zend\Db\ResultSet\ResultSet;
use AuthApplication\Model\Entity\User;

class Users extends AbstractTableGateway{
	
	const DEFAULT_ROLE_REGISTER = 'member';
	
	public function __construct()
	{
		$this->table = 'USERS';
		$this->featureSet = new Feature\FeatureSet();
		$this->featureSet->addFeature(new Feature\GlobalAdapterFeature());
		
		$resultset = new ResultSet();
		$resultset->setArrayObjectPrototype(new User());
		$this->setResultSetPrototype($resultset);
		$this->initialize();
	}
	
	public function setResultSetPrototype(\Zend\Db\ResultSet\ResultSet $resulset){
		$this->resultSetPrototype = $resulset;
	}
	
	
	public function registerUser(\AuthApplication\Model\Entity\User $user){
		$picture= $user->PICTURE;
		if(is_array($picture)){
			$user->PICTURE=$picture["name"];
		}
		
		$user->PASSWORD = md5($user->PASSWORD);
		$user->ROLE = self::DEFAULT_ROLE_REGISTER;
		parent::insert($user->getArrayCopy());
	}
	
	public function editUser(\AuthApplication\Model\Entity\User $user, $where){
		$picture= $user->PICTURE;
		if(is_array($picture)){
			$user->PICTURE=$picture["name"];
		}
		$data = $user->getArrayCopy();
		unset($data['USERNAME']);
		unset($data['PASSWORD']);
		unset($data['ROLE']);
		unset($data['ID']);
		parent::update($data, $where);
	}
	
	public function updateUserPassword(\AuthApplication\Model\Entity\User $user, $where){
		$data = $user->getArrayCopy();
		unset($data['USERNAME']);
		unset($data['LASTNAME']);
		unset($data['FIRSTNAME']);
		unset($data['EMAIL']);
		unset($data['PHONE']);
		unset($data['PICTURE']);
		unset($data['ROLE']);
		unset($data['ID']);
		$data['PASSWORD'] = md5($user->PASSWORD);
		parent::update($data, $where);
		
	}
	
	public function getUserById($_id){
		$sql= new \Zend\Db\Sql\Sql($this->getAdapter());
		$select = $sql->select();
		$select->from($this->table);
		$where = new Where();
		$where->equalTo("ID", $_id);
		$select->where($where);
		return $this->selectWith($select);
		 
	}
}

?>