<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\View\Helper\Placeholder;
use DoctrineModule\Form\Element\ObjectSelect;
use Doctrine\Common\Persistence\ObjectManager;
use Admin\Model\Conta;
use Admin\Model\Categoria;

class Movimentacao extends Form {
	public function __construct(ObjectManager $objectManager) {
		parent::__construct ( 'movimentacao' );
	
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'class', 'movimentacao' );
		$this->setAttribute ( 'action', '/admin/movimentacao/cadastrar' );
	
		$this->add ( array (
				'name' => 'id',
				'attributes' => array (
						'type' => 'hidden'
				)
		) );
	
		$conta = new ObjectSelect ( 'conta' );
		$conta->setEmptyOption ( 'Selecione' );
		$conta->setOptions ( array (
				'object_manager' => $objectManager,
				'target_class' => 'Admin\Model\Conta',
				'property' => 'conta',
				'is_method' => true,
				'label' => 'Conta'
		) );
		$conta->setAttributes ( array (
				'class' => 'form-control',
				'id' => 'selectConta'
		) );
		
		$this->add($conta);
		
		$categoria = new ObjectSelect ( 'categoria' );
		$categoria->setEmptyOption ( 'Selecione' );
		$categoria->setOptions ( array (
				'object_manager' => $objectManager,
				'target_class' => 'Admin\Model\Categoria',
				'property' => 'categoria',
				'is_method' => true,
				'label' => 'Categoria'
		) );
		$categoria->setAttributes ( array (
				'class' => 'form-control',
				'id' => 'selectCategoria'
		) );
		
		$this->add($categoria);
		
		$this->add ( array (
				'type' => 'text',
				'name' => 'historico',
				'options' => array (
						'label' => 'Histórico'
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputHistorico',
						'placeholder' => 'Histórico'
				)
		) );
		
		$this->add ( array (
				'type' => 'text',
				'name' => 'documento',
				'options' => array (
						'label' => 'Documento'
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputDocumento',
						'placeholder' => 'Documento'
				)
		) );
		
		$this->add ( array (
				'type' => 'text',
				'name' => 'valor',
				'options' => array (
						'label' => 'Valor'
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputValor',
						'placeholder' => 'Valor'
				)
		) );
		
		$this->add ( array (
				'type' => 'text',
				'name' => 'data_',
				'options' => array (
						'label' => 'Data'
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputData',
						'placeholder' => 'Data'
				)
		) );
		
		$this->add ( array (
				'type' => 'text',
				'name' => 'rubrica',
				'options' => array (
						'label' => 'Rúbrica'
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputRúbrica',
						'placeholder' => 'Rúbrica'
				)
		) );
		
		$this->add ( array (
				'type' => 'text',
				'name' => 'atividade',
				'options' => array (
						'label' => 'Atividade'
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputAtividade',
						'placeholder' => 'Atividade'
				)
		) );
		
		$this->add ( array (
				'type' => 'text',
				'name' => 'favorecido',
				'options' => array (
						'label' => 'Favorecido'
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputFavorecido',
						'placeholder' => 'Favorecido'
				)
		) );
		
		$this->add ( array (
				'type' => 'text',
				'name' => 'descricao',
				'options' => array (
						'label' => 'Descrição'
				),
				'attributes' => array (
						'class' => 'form-control',
						'id' => 'inputDescricao',
						'placeholder' => 'Descrição'
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