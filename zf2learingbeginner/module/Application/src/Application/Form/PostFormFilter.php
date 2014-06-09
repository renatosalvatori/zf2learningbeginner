<?php
namespace Application\Form;

use Zend\InputFilter\Input; 
use Zend\InputFilter\InputFilter;
use Zend\Validator;
use Zend\Filter;

class PostFormFilter extends InputFilter{
	
	public function prepareFilters(){
		
		$content = new Input('CONTENT');
		$content->getValidatorChain()->addValidator(new Validator\StringLength(array('min'=>0,'max'=>30)));
		$content->getFilterChain()->attachByName('StripTags');
		$content->setRequired(true);
		$content->SetErrorMessage("Campo 'CONTENT' accetta al massimo 30 caratteri");
		
		$title = new Input('TITLE');
		$content->getFilterChain()->attachByName('StripTags');
		$content->setRequired(true);
		
		$inputFilter= new InputFilter();
		$inputFilter->add($content)
		->add($title);
		
		return $inputFilter;
		
	}
}

?>