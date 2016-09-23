<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\View\Helper\Placeholder;

class Categoria extends Form {
	public function __construct() {
		parent::__construct ( 'categoria' );
		
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'class', 'categoria' );
		$this->setAttribute ( 'action', '/admin/categoria/cadastrar' );
		
		$this->add ( array (
				'name' => 'id',
				'attributes' => array (
						'type' => 'hidden' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'categoria',
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputConta',
						'placeholder' => 'Categoria',
						'type' => 'text' 
				),
				'options' => array (
						'label' => 'Categoria' 
				) 
		) );
		
		$botao = new Element\Submit ();
		$botao->setAttribute ( 'name', 'submit' );
		$botao->setAttribute ( 'value', 'Salvar' );
		$botao->setAttribute ( 'id', 'submitbutton' );
		$botao->setAttribute ( 'class', 'btn btn-success' );
		$this->add ( $botao );
	}
}