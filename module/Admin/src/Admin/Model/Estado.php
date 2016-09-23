<?php

namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Estado
 *
 * @ORM\Entity
 * @ORM\Table(name="estados")
 *
 * @property integer $id
 * @property datetime $criacao
 * @property datetime $modificacao
 * @property string $sigla
 * @property string $estado
 * @property string $regiao
 */
class Estado extends Entity {
	
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $criacao;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $modificacao;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $sigla;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $estado;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $regiao;
	public function setId($valor) {
		$this->id = $valor;
	}
	public function setCriacao($valor) {
		$this->criacao = $valor;
	}
	public function setModificacao($valor) {
		$this->modificacao = $valor;
	}
	public function setSigla($valor) {
		$this->sigla = $valor;
	}
	public function setEstado($valor) {
		$this->estado = $valor;
	}
	public function setRegiao($valor) {
		$this->regiao = $valor;
	}
	public function getId() {
		return $this->id;
	}
	public function getCriacao() {
		return $this->criacao;
	}
	public function getModificacao() {
		return $this->modificacao;
	}
	public function getSigla() {
		return $this->sigla;
	}
	public function getEstado() {
		return $this->estado;
	}
	public function getRegiao() {
		return $this->regiao;
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
					'name' => 'estado',
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
											'min' => 1,
											'max' => 500 
									) 
							) 
					) 
			) ) );
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
}
