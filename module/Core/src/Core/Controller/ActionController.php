<?php

namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Core\Db\TableGateway;

class ActionController extends AbstractActionController {
	
	/**
	 * Retorna um Entitymanager
	 * 
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	public function getEntityManager() {
		if (null === $this->em) {
			$this->em = $this->getServiceLocator ()->get ( 'doctrine.entitymanager.orm_default' );
		}
		return $this->em;
	}
	
	/**
	 * Retorna um TableGateway
	 *
	 * @param string $table        	
	 * @return TableGateway
	 */
	protected function getTable($table) {
		$sm = $this->getServiceLocator ();
		$dbAdapter = $sm->get ( 'DbAdapter' );
		$tableGateway = new TableGateway ( $dbAdapter, $table, new $table () );
		$tableGateway->initialize ();
		
		return $tableGateway;
	}
	
	/**
	 * Retorna um Serviço
	 *
	 * @param string $service        	
	 * @return Service
	 */
	protected function getService($service) {
		return $this->getServiceLocator ()->get ( $service );
	}
}