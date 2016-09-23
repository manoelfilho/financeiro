<?php

/**
 * Entity class
 */
namespace Core\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Exception\InvalidArgumentException;

abstract class Entity implements InputFilterAwareInterface {
	protected $primaryKeyField = 'id';
	protected $tableName;
	protected $inputFilter = null;
	public function getTableName() {
		return $this->tableName;
	}
	public function __set($key, $value) {
		$this->$key = $this->valid ( $key, $value );
	}
	public function __get($key) {
		return $this->$key;
	}
	public function setData($data) {
		foreach ( $data as $key => $value ) {
			$this->__set ( $key, $value );
		}
	}
	public function getData() {
		$data = get_object_vars ( $this );
		unset ( $data ['inputFilter'] );
		unset ( $data ['tableName'] );
		unset ( $data ['primaryKeyField'] );
		return array_filter ( $data );
	}
	public function exchangeArray($data) {
		$this->setData ( $data );
	}
	public function getArrayCopy() {
		return $this->getData ();
	}
	public function setInputFilter(InputFilterInterface $inputFilter) {
		throw new EntityException ( "Not used" );
	}
	public function getInputFilter() {
	}
	protected function valid($key, $value) {
		if (! $this->getInputFilter ())
			return $value;
		
		try {
			$filter = $this->getInputFilter ()->get ( $key );
		} catch ( InvalidArgumentException $e ) {
			// não existe filtro para esse campo
			return $value;
		}
		
		$filter->setValue ( $value );
		if (! $filter->isValid ())
			throw new EntityException ( "Input inválido: $key = $value" );
		
		return $filter->getValue ( $key );
	}
	public function toArray() {
		return $this->getData ();
	}
}