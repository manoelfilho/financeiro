<?php

namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Grupo
 *
 * @ORM\Entity
 * @ORM\Table(name="grupos")
 *
 * @property integer $id
 * @property string $grupo
 * @property date $criacao
 * @property date $modificacao
 */
class Grupo extends Entity {
	protected $inputFilter;
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $grupo;
	
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
	 * Retorna o nome do grupo
	 */
	public function getGrupo() {
		return $this->grupo;
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
	 * Seta o nome do grupo
	 */
	public function setGrupo($valor) {
		$this->grupo = $valor;
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
					'name' => 'grupo',
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
