<?php

namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Doctrine\ORM\Mapping as ORM;
use Admin\Model\Estado;
use Core\Model\Entity;

/**
 * Municipio
 *
 * @ORM\Entity
 * @ORM\Table(name="municipios")
 *
 * @property string $id
 * @property datetime $criacao
 * @property datetime $modificacao
 * @property string $municipio
 * @property Estado $estado
 * @property integer $ibge
 * @property integer $populacao
 * @property integer $prioridade
 * @property decimal $maximo_repasse
 */
class Municipio extends Entity {
	
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
	protected $municipio;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Model\Estado")
	 */
	protected $estado;
	

	public function setId($valor) {
		$this->id = $valor;
	}
	public function setCriacao($valor) {
		$this->criacao = $valor;
	}
	public function setModificacao($valor) {
		$this->modificacao = $valor;
	}
	public function setMunicipio($valor) {
		$this->municipio = $valor;
	}
	public function setEstado(Estado $valor) {
		$this->estado = $valor;
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
	public function getMunicipio() {
		return $this->municipio;
	}
	public function getEstado() {
		return $this->estado;
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
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
}
