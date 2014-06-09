<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class PostFormSearch extends Form{
	
	public function prepareElements($_category_id, $_product_id){
		parent::__construct('post_search');
		$this->setAttribute('method', 'post');
		
		$category_id= new Element\Select('CATEGORY_ID');
		$category_id->setLabel('Category')->setOptions(array('options'=>$_category_id))->setAttribute('class', 'span2')->setAttribute('id', 'CATEGORY_ID');
		
		$product_id= new Element\Select('PRODUCT_ID');
		$product_id->setLabel('Product')->setOptions(array('options'=>$_product_id))->setAttribute('class', 'span2')->setAttribute('id', 'PRODUCT_ID');
		
		$this->add($category_id)->add($product_id);
		
	}
}

?>