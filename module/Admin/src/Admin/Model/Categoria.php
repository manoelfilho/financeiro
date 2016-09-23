<?php

namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categoria
 *
 * @ORM\Entity
 * @ORM\Table(name="categorias")
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property datetime $criacao
 * @property datetime $modificacao
 * @property string $categoria
 *
 */
class Categoria extends Entity {
	protected $inputFilter;
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer");
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;
	/**
	 * @ORM\Column(type="integer");
	 */
	protected $usuario_id;
	/**
	 * @ORM\Column(type="datetime");
	 */
	protected $criacao;
	
	/**
	 * @ORM\Column(type="datetime");
	 */
	protected $modificacao;
	
	/**
	 * @ORM\Column(type="string");
	 */
	protected $categoria;
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getUsuarioId() {
		return $this->usuario_id;
	}
	public function setUsuarioId($usuario_id) {
		$this->usuario_id = $usuario_id;
	}
	public function getCriacao() {
		return $this->criacao;
	}
	public function setCriacao($criacao) {
		$this->criacao = $criacao;
	}
	public function getModificacao() {
		return $this->modificacao;
	}
	public function setModificacao($modificacao) {
		$this->modificacao = $modificacao;
	}
	public function getCategoria() {
		return $this->categoria;
	}
	public function setCategoria($categoria) {
		$this->categoria = $categoria;
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
					'name' => 'categoria',
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
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
}
