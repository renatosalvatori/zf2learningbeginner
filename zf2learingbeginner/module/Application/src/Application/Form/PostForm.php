<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class PostForm extends Form
{
    public function __construct($category, $product)
    {
        parent::__construct('post');

        $this->setAttribute('method', 'post');
        

        $this->add(array(
            'name' => 'TITLE',
            'type'  => 'text',
            'options' => array('label' => 'Title'),
            'attributes' => array(
                'class' => 'input-xxlarge'
            )
        ));

        $this->add(array(
            'name' => 'CONTENT',
            'type'  => 'textarea',
            'options' => array('label' => 'Content'),
        	'attributes' =>array(
        			'rows'=>3,
        			'class' => 'input-xxlarge'
        	)
        ));

        $this->add(array(
            'name' => 'CATEGORY_ID',
            'type' => 'Zend\Form\Element\Select',
        		'options' => array(
        				'label' => 'Choose Category',
        				'value_options' => $category
        	)
        ));
        
        $this->add(array(
        		'name' => 'PRODUCT_ID',
        		'type' => 'Zend\Form\Element\Select',
        		'options' => array(
        				'label' => 'Choose Product',
        				'value_options' => $product
        		)
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save',
                'id' => 'submitbutton',
            ),
        ));
    }
}
