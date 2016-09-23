<?php

namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Conta
 *
 * @ORM\Entity
 * @ORM\Table(name="contas")
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property string $conta
 * @property string $banco
 * @property decimal $saldo
 * @property date $criacao
 * @property date $modificacao
 */
class Conta extends Entity {
	protected $inputFilter;
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="integer")
	 */
	protected $usuario_id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $conta;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $banco;
	
	/**
	 * @ORM\Column(type="decimal")
	 */
	protected $saldo;
	
	/**
	 * @ORM\Column(type="date")
	 */
	protected $criacao;
	
	/**
	 * @ORM\Column(type="date")
	 */
	protected $modificacao;
	
	/**
	 * Retorna o ID do grupo
	 */
	public function getId() {
		return $this->id;
	}
	/**
	 * Retorna o ID do usuário
	 */
	public function getUsuario_id() {
		return $this->usuario_id;
	}
	/**
	 * Retorna o nome da conta
	 */
	public function getConta() {
		return $this->conta;
	}
	/**
	 * Retorna o nome do banco
	 */
	public function getBanco() {
		return $this->banco;
	}
	/**
	 * Retorna o saldo inicial da conta
	 */
	public function getSaldo() {
		return $this->saldo;
	}
	/**
	 * Retorna a data de criacao
	 */
	public function getCriacao() {
		return $this->criacao;
	}
	/**
	 * Retorna a data de modificacao
	 */
	public function getModificacao() {
		return $this->modificacao;
	}
	/**
	 * Seta o ID do grupo
	 */
	public function setId($valor) {
		$this->id = $valor;
	}
	/**
	 * Seta o ID do usuário
	 */
	public function setUsuario_id($valor) {
		$this->usuario_id = $valor;
	}
	/**
	 * Seta o nome da conta
	 */
	public function setConta($valor) {
		$this->conta = $valor;
	}
	/**
	 * Seta o nome do banco
	 */
	public function setBanco($valor) {
		$this->banco = $valor;
	}
	/**
	 * Seta o valor do saldo
	 */
	public function setSaldo($valor) {
		$this->saldo = $valor;
	}
	/**
	 * Seta a data de criacao
	 */
	public function setCriacao($valor) {
		$this->criacao = $valor;
	}
	/**
	 * Seta a data de modificacao
	 */
	public function setModificacao($valor) {
		$this->modificacao = $valor;
	}
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Não usado!" );
	}
	public function getInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter ();
			
			$factory = new InputFactory ();
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'id',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'Int' 
							) 
					) 
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'conta',
					'required' => true,
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
									'name' => 'StringLength',
									'options' => array (
											'encoding' => 'UTF-8',
											'min' => 5,
											'max' => 500 
									) 
							) 
					) 
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'banco',
					'required' => false,
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
									'name' => 'StringLength',
									'options' => array (
											'encoding' => 'UTF-8',
											'min' => 1,
											'max' => 500 
									) 
							) 
					) 
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'saldo',
					'required' => false 
			) ) );
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
}
