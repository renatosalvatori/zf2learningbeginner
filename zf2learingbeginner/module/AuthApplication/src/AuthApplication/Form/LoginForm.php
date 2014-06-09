<?php
namespace AuthApplication\Form;
use Zend\Form\Form as Form;
use Zend\Form\Element as Element;
class LoginForm extends Form
{
	public function prepareElements()
	{
		$this->add(array(
				'name' => 'USERNAME',
				'options' => array(
						'label' 	=> 'Username',
				),
				'attributes' 	=> array(
						'type'  	=> 'text',
						'maxlength' => 64,
				),
		));
		$this->add(array(
				'name' => 'PASSWORD',
				'options' => array(
						'label' 	=> 'Password',
				),
				'attributes' 	=> array(
						'type'  	=> 'password',
						'maxlength' => 64,
				),
		));
		
		$this->add(array(
				'name' => 'submit',
				'attributes' => array(
						'type'  => 'submit',
						'value' => 'Login',
				),
		));
	}
}
