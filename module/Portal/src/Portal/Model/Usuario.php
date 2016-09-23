<?php

namespace Portal\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\JoinColumn;
use Admin\Model\Estado;
use Admin\Model\Municipio;
use Portal\Model\Grupo;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Usuario
 *
 * @ORM\Entity
 * @ORM\Table(name="usuarios")
 *
 * @property integer $id
 * @property datetime $criacao
 * @property datetime $modificacao
 * @property string $nome
 * @property string $sexo
 * @property string $email
 * @property string $senha
 * @property string $categoria
 * @property string $codigo_mudanca
 */
class Usuario extends Entity {
	protected $inputFilter;
	
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
	protected $nome;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $sexo;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Model\Estado")
	 */
	protected $estado;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Model\Municipio")
	 */
	protected $municipio;
	
	/**
	 * @ManyToMany(targetEntity="Portal\Model\Grupo")
	 * @JoinTable(name="usuarios_grupos",
	 * joinColumns={@JoinColumn(name="usuario_id", referencedColumnName="id")},
	 * inverseJoinColumns={@JoinColumn(name="grupo_id", referencedColumnName="id")}
	 * )
	 */
	protected $grupos;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $email;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $senha;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $categoria;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $codigo_mudanca;
	public function __construct() {
		$this->grupos = new ArrayCollection ();
	}
	public function setId($valor) {
		$this->id = $valor;
	}
	public function setCriacao($valor) {
		$this->criacao = $valor;
	}
	public function setModificacao($valor) {
		$this->modificacao = $valor;
	}
	public function setNome($valor) {
		$this->nome = $valor;
	}
	public function setSexo($valor) {
		$this->sexo = $valor;
	}
	public function setEstado(Estado $valor) {
		$this->estado = $valor;
	}
	public function setMunicipio(Municipio $valor) {
		$this->municipio = $valor;
	}
	public function setEmail($valor) {
		$this->email = $valor;
	}
	public function setSenha($valor) {
		$this->senha = $valor;
	}
	public function setCategoria($valor) {
		$this->categoria = $valor;
	}
	public function setCodigo_mudanca($valor) {
		$this->codigo_mudanca = $valor;
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
	public function getNome() {
		return $this->nome;
	}
	public function getSexo() {
		return $this->sexo;
	}
	public function getEstado() {
		return $this->estado;
	}
	public function getMunicipio() {
		return $this->municipio;
	}
	public function getEmail() {
		return $this->email;
	}
	public function getSenha() {
		return $this->senha;
	}
	public function getCategoria() {
		return $this->categoria;
	}
	public function getCodigo_mudanca() {
		return $this->codigo_mudanca;
	}
	public function getGrupos() {
		return $this->grupos;
	}
	public function addGrupos(Collection $grupos) {
		foreach ( $grupos as $grupo ) {
			$this->grupos->add ( $grupo );
		}
	}
	public function removeGrupos(Collection $grupos) {
		foreach ( $grupos as $grupo ) {
			$this->grupos->removeElement ( $grupo );
		}
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
					'name' => 'nome',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'sexo',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'email',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) ) );
			
			$inputFilter->add ( $factory->createInput ( array (
					'name' => 'senha',
					'required' => true,
					'filters' => array (
							array (
									'name' => 'StripTags' 
							),
							array (
									'name' => 'StringTrim' 
							) 
					) 
			) ) );
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
}
