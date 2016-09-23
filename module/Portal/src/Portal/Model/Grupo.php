<?php

namespace Portal\Model;

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
 */
class Grupo extends Entity {
	
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
	
	public function getId(){
		return $this->id;
	}
	
	public function setGrupo($grupo){
		$this->grupo = $grupo;
	}
	
	public function getGrupo(){
		return $this->grupo;
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
