<?php

namespace Admin\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Core\Model\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\ManyToOne;
use Admin\Model\Conta;
use Admin\Model\Categoria;

/**
 * Movimentacao
 *
 * @ORM\Entity
 * @ORM\Table(name="movimentacoes")
 */
class Movimentacao extends Entity {
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
	 * @ORM\Column(type="datetime")
	 */
	protected $criacao;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $modificacao;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Model\Conta")
	 */
	protected $conta;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Admin\Model\Categoria")
	 */
	protected $categoria;
	
	/**
	 * @ORM\Column(type="datetime")
	 */
	protected $data;
	/**
	 * @ORM\Column(type="string")
	 */
	protected $historico;
	/**
	 * @ORM\Column(type="string")
	 */
	protected $documento;
	/**
	 * @ORM\Column(type="decimal")
	 */
	protected $valor;
	/**
	 * @ORM\Column(type="string")
	 */
	protected $rubrica;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $atividade;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $favorecido;
	
	/**
	 * @ORM\Column(type="string")
	 */
	protected $descricao;
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
					'name' => 'historico',
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
					'name' => 'documento',
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
					'name' => 'rubrica',
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
					'name' => 'atividade',
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
					'name' => 'descricao',
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
					'name' => 'data_',
					'required' => true,
					'validators' => array (
							array (
									'name' => 'date',
									'options' => array (
											'format' => 'd/m/Y' 
									) 
							) 
					) 
			) ) );
			
			$this->inputFilter = $inputFilter;
		}
		
		return $this->inputFilter;
	}
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new \Exception ( "Não usado!" );
	}
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getUsuarioId() {
		return $this->usuario_id;
	}
	public function setUsuario_id($usuario_id) {
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
	public function getConta() {
		return $this->conta;
	}
	public function setConta(Conta $conta) {
		$this->conta = $conta;
	}
	public function getCategoria() {
		return $this->categoria;
	}
	public function setCategoria(Categoria $categoria) {
		$this->categoria = $categoria;
	}
	public function getData() {
		return $this->data;
	}
	public function setData($data) {
		$this->data = $data;
	}
	public function getHistorico() {
		return $this->historico;
	}
	public function setHistorico($historico) {
		$this->historico = $historico;
	}
	public function getDocumento() {
		return $this->documento;
	}
	public function setDocumento($documento) {
		$this->documento = $documento;
	}
	public function getValor() {
		return $this->valor;
	}
	public function setValor($valor) {
		$this->valor = $valor;
	}
	public function getRubrica() {
		return $this->rubrica;
	}
	public function setRubrica($rubrica) {
		$this->rubrica = $rubrica;
	}
	public function getAtividade() {
		return $this->atividade;
	}
	public function setAtividade($atividade) {
		$this->atividade = $atividade;
	}
	public function getFavorecido() {
		return $this->favorecido;
	}
	public function setFavorecido($favorecido) {
		$this->favorecido = $favorecido;
	}
	public function getDescricao() {
		return $this->descricao;
	}
	public function setDescricao($descricao) {
		$this->descricao = $descricao;
	}
}
