<?php
namespace AuthApplication\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;
use Zend\Filter;

class LoginFilter
{
	public function prepareFilters()
	{
		$username = new Input('USERNAME');
		$username->getFilterChain()->attachByName('StripTags');
		$username->setRequired(TRUE);

		$password = new Input('PASSWORD');
		$password->getFilterChain()->attachByName('StripTags');
		$password->setRequired(TRUE);

		$inputFilter = new InputFilter();
		$inputFilter->add($username)
				    ->add($password);

		return $inputFilter;
	}
}
