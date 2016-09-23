<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\View\Helper\Placeholder;

class Conta extends Form {
	public function __construct() {
		parent::__construct ( 'conta' );
		
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'class', 'conta' );
		$this->setAttribute ( 'action', '/admin/conta/cadastrar' );
		
		$this->add ( array (
				'name' => 'id',
				'attributes' => array (
						'type' => 'hidden' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'conta',
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputConta',
						'placeholder' => 'Conta',
						'type' => 'text' 
				),
				'options' => array (
						'label' => 'Conta' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'banco',
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputBanco',
						'placeholder' => 'Banco',
						'type' => 'text' 
				),
				'options' => array (
						'label' => 'Banco' 
				) 
		) );
		
		$this->add ( array (
				'name' => 'saldo',
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputSaldo',
						'placeholder' => 'Saldo',
						'type' => 'text' 
				),
				'options' => array (
						'label' => 'Saldo' 
				),
				'validators' => array (
						array (
								'name' => 'digits' 
						) 
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