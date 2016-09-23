<?php

namespace Portal\Form;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\Form\Form;
use Portal\Form\UsuarioFieldset;
use Zend\Form\Element\Submit;
use DoctrineModule\Form\Element\ObjectSelect;
use DoctrineModule\Form\Element\ObjectMultiCheckbox;

class UsuarioForm extends Form {
	public function __construct(ObjectManager $objectManager) {
		parent::__construct ( 'usuario' );
		
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'class', 'usuario' );
		$this->setAttribute ( 'action', '/portal/usuario/cadastrar' );
		
		$this->add ( array (
				'name' => 'id',
				'attributes' => array (
						'type' => 'hidden' 
				) 
		) );
		
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
				'name' => 'senha',
				'options' => array (
						'label' => 'Senha' 
				),
				'attributes' => array (
						'maxlength' => 6,
						'class' => 'form-control',
						'id' => 'inputSenha',
						'placeholder' => 'Senha' 
				) 
		) );
		
		$this->add ( array (
				'type' => 'text',
				'name' => 'nome',
				'options' => array (
						'label' => 'Nome' 
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputNome',
						'placeholder' => 'Nome' 
				) 
		) );
		
		$this->add ( array (
				'type' => 'Select',
				'name' => 'sexo',
				'options' => array (
						'disable_inarray_validator' => true,
						'label' => 'Sexo',
						'empty_option' => 'Selecione',
						'value_options' => array (
								'f' => 'Feminino',
								'm' => 'Masculino' 
						) 
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'selectSexo' 
				) 
		) );
		
		$estado = new ObjectSelect ( 'estado' );
		$estado->setEmptyOption ( 'Selecione' );
		$estado->setOptions ( array (
				'object_manager' => $objectManager,
				'target_class' => 'Admin\Model\Estado',
				'property' => 'estado',
				'is_method' => true,
				'label' => 'Estado' 
		) );
		$estado->setAttributes ( array (
				'class' => 'form-control',
				'id' => 'selectEstado' 
		) );
		
		$municipio = new ObjectSelect ( 'municipio' );
		$municipio->setEmptyOption ( 'Selecione' );
		$municipio->setOptions ( array (
				'disable_inarray_validator' => true,
				'object_manager' => $objectManager,
				'target_class' => 'Admin\Model\Municipio',
				'property' => 'municipio',
				'is_method' => true,
				'label' => 'Município',
				'find_method' => array (
						'name' => 'findBy',
						'params' => array (
								'criteria' => array (
										'estado' => 0 
								) 
						) 
				) 
		) );
		$municipio->setAttributes ( array (
				'class' => 'form-control',
				'id' => 'selectMunicipio' 
		) );
		
		$this->add ( $estado );
		$this->add ( $municipio );
		
		$grupos = new ObjectMultiCheckbox ( 'grupos' );
		$grupos->setLabel ( 'Categorias' );
		$grupos->setOptions ( array (
				'disable_inarray_validator' => true,
				'object_manager' => $objectManager,
				'target_class' => 'Portal\Model\Grupo',
				'property' => 'grupo',
				'is_method' => true 
		) );
		
		$this->add ( $grupos );
		
		$botao = new Submit ();
		$botao->setAttribute ( 'name', 'submit' );
		$botao->setAttribute ( 'value', 'Cadastrar' );
		$botao->setAttribute ( 'id', 'submitbutton' );
		$botao->setAttribute ( 'class', 'btn btn-primary' );
		$this->add ( $botao );
	}
}