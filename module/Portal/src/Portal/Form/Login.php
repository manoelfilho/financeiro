<?php

namespace Portal\Form;

use Zend\Form\Form;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Select;
use Zend\View\Helper\Placeholder;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Login extends Form implements ObjectManagerAwareInterface {
	protected $objectManager;
	public function __construct(ObjectManager $objectManager) {
		$this->setObjectManager ( $objectManager );
		
		parent::__construct ( 'usuario' );
		
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'class', 'login' );
		$this->setAttribute ( 'action', '/portal/usuario/login' );
		
		$this->add ( array (
				'type' => 'text',
				'name' => 'email',
				'options' => array (
						'label' => 'Email' 
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputEmail',
						'placeholder' => 'Email' 
				) 
		) );
		
		$this->add ( array (
				'type' => 'password',
				'name' => 'password',
				'options' => array (
						'label' => 'Senha' 
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputSenha',
						'maxlength' => 6,
						'placeholder' => 'Senha' 
				) 
		) );
		
		$botao = new Submit ();
		$botao->setAttribute ( 'name', 'submit' );
		$botao->setAttribute ( 'value', 'Login' );
		$botao->setAttribute ( 'id', 'submitbutton' );
		$botao->setAttribute ( 'class', 'btn btn-primary' );
		$this->add ( $botao );
	}
	public function setObjectManager(ObjectManager $objectManager) {
		$this->objectManager = $objectManager;
		return $this;
	}
	public function getObjectManager() {
		return $this->objectManager;
	}
}