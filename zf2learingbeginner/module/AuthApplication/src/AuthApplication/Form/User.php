<?php

namespace AuthApplication\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;



class User extends Form implements InputFilterProviderInterface{
	
	protected $filter = null;
	
	public function __construct($_name){
		parent::__construct($_name);
		$this->setAttribute('method', 'post');
		$this->setAttribute('enctype','multipart/form-data');
		
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
				'name' => 'PASSWORD_VERIFY',
				'type' => 'Zend\Form\Element\Password',
				'attributes' => array(
						'placeholder' => 'Verify Password Here...',
						'required' => 'required',
				),
				'options' => array(
						'label' => 'Verify Password',
				),
		));
		
		
		$this->add(array(
				'name' => 'LASTNAME',
				'options' => array(
						'label' 	=> 'LastName',
				),
				'attributes' 	=> array(
						'type'  	=> 'text',
						'maxlength' => 255,
				),
		));
		$this->add(array(
				'name' => 'FIRSTNAME',
				'options' => array(
						'label' 	=> 'FirstName',
				),
				'attributes' 	=> array(
						'type'  	=> 'text',
						'maxlength' => 255,
				),
		));
		
		$this->add(array(
				'name' => 'EMAIL',
				'type' => 'Zend\Form\Element\Email',
				'options' => array(
						'label' 	=> 'EMAIL',
				),
				'attributes' => array(
            // These are the attributes that are passed directly to the HTML element
                'type' => 'email', // Ex: <input type="email"
                'required' => true, // Ex: <input required="true"
                'placeholder' => 'Email Address...', // HTM5 placeholder attribute
            )
		));
		
		
		$this->add(array(
				'name' => 'PHONE',
				'options' => array(
						'label' => 'Phone number'
				),
				'attributes' => array(
						// Below: HTML5 way to specify that the input will be phone number
						'type' => 'tel',
						'required' => 'required',
						// Below: HTML5 way to specify the allowed characters
						'pattern'  => '^[\d-/]+$'
				),
		));
		
		$this->add(array(
				'type' => 'Zend\Form\Element\File',
				'name' => 'PICTURE',
				'options' => array(
						'label' => 'Your photo'
				),
				'attributes' => array(
						'required' => '',
						'id'  => 'photo'
				),
		));
		
		// This is the special code that protects our form beign submitted from automated scripts
		/*$this->add(array(
				'name' => 'csrf',
				'type' => 'Zend\Form\Element\Csrf',
		));*/
		
		// This is the submit button
		$this->add(array(
				'name' => 'submit',
				'type' => 'Zend\Form\Element\Submit',
				'attributes' => array(
						'value' => 'Submit',
						'required' => 'false',
				),
		));
		
		
		
		
    }
	
	public function getInputFilterSpecification(){
		
			$inputFilter = new InputFilter();
			$factory = new InputFactory ();
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'EMAIL',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					'validators' => array (
							array (
									'name' => 'EmailAddress',
									'options' => array (
											'messages' => array (
													'emailAddressInvalidFormat' => 'Email address format is not invalid'
											)
									)
							),
							array (
									'name' => 'NotEmpty',
									'options' => array (
											'messages' => array (
													'isEmpty' => 'Email address is required'
											)
									)
							)
					)
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'USERNAME',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					'validators' => array (
							array (
									'name' => 'NotEmpty',
									'options' => array (
											'messages' => array (
													'isEmpty' => 'Name is required'
											)
									)
							)
					)
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'PASSWORD',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					'validators' => array (
							array (
									'name' => 'NotEmpty',
									'options' => array (
											'messages' => array (
													'isEmpty' => 'Password is required'
											)
									)
							)
					)
			)));
			
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'PASSWORD_VERIFY',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					'validators' => array (
							array (
									'name' => 'identical',
									'options' => array (
											'token' => 'PASSWORD' 
									)
							)
					)
			
			) ) );
				
			
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'FIRSTNAME',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					'validators' => array (
							array (
									'name' => 'NotEmpty',
									'options' => array (
											'messages' => array (
													'isEmpty' => 'FirstName is required'
											)
									)
							)
					)
			) ) );
			
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'LASTNAME',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					'validators' => array (
							array (
									'name' => 'NotEmpty',
									'options' => array (
											'messages' => array (
													'isEmpty' => 'LastName is required'
											)
									)
							)
					)
			) ) );
				
			
			$inputFilter->add ( $factory->createInput ( array (
				
					'name' => 'PHONE',
					'filters' => array (
							array (
									'name' => 'StripTags'
							),
							array (
									'name' => 'StringTrim'
							)
					),
					
			)
			));
			
			/**
			 * 
			 * $phone = new Input('contact_phone');
		$phoneValidator = new Validator\Regex(array('pattern' => '/^\+[0-9]+ [0-9 -]+$/'));
		$phoneValidator->setMessage('Enter phone as: +<country code> nnn-nnn-nnnn');
		$phone->getFilterChain()
			  ->attachByName('StripTags')
			  ->attachByName('StringTrim');
		$phone->getValidatorChain()
			  ->addValidator($phoneValidator);
			 * 
			 * 
			 */
			
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'PICTURE',
					'required'=>'false',
					'validators' => array (
							array (
									'name' => 'filesize',
									'options' => array (
											'max' => 2097152, // 2 MB
									),
							),
							array (
									'name' => 'filemimetype',
									'options' => array (
											'mimeType' => 'image/png,image/x-png,image/jpg,image/jpeg,image/gif',
									)
							),
							array (
									'name' => 'fileimagesize',
									'options' => array (
											'maxWidth' => 200,
											'maxHeight' => 200
									)
							),
					),
					'filters' => array (
							// the filter below will save the uploaded file under
							// <app-path>/data/images/photos/<tmp_name>_<random-data>
							/*array (
									'name'    => 'filerenameupload',
									'options' => array (
											// Notice: Make sure that the folder below is existing on your system
											//         otherwise this filter will not pass and you will get strange
											//         error message reporting that the required field is empty
											'target'    => 'data/image/photos/',
											'randomize' => true,
									),
							),*/
					),
			)));	
			
		$this->filter = $inputFilter;
		return $this->filter;
	}
	
	public function setInputFilterSpecification(){
		throw new \Exception('not allowed to set new imput filter');
	}
	
}

?>