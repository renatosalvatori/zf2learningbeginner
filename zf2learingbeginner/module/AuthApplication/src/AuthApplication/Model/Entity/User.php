<?php
namespace AuthApplication\Model\Entity;

use Zend\Stdlib\ArraySerializableInterface;

class User implements ArraySerializableInterface{
	
	
	public $ID;
	public $USERNAME;
	public $PASSWORD;
	public $EMAIL;
	public $LASTNAME;
	public $FIRSTNAME;
	public $PICTURE;
	public $PHONE;
	
	public function exchangeArray(array $data){
		$this->USERNAME 	= (isset($data['USERNAME'])) ? $data['USERNAME'] : null;
		$this->LASTNAME 	= (isset($data['LASTNAME'])) ? $data['LASTNAME'] : null;
		$this->FIRSTNAME 	= (isset($data['FIRSTNAME'])) ? $data['FIRSTNAME'] : null;
		$this->EMAIL 		= (isset($data['EMAIL'])) ? $data['EMAIL'] : null;
		$this->PASSWORD 	= (isset($data['PASSWORD'])) ? $data['PASSWORD'] : null;
		$this->PICTURE 		= (isset($data['PICTURE'])) ? $data['PICTURE'] : null;
		$this->PHONE 		= (isset($data['PHONE'])) ? $data['PHONE'] : null;
	}
	
	public function getArrayCopy(){
		return get_object_vars($this);
	}
}

?>