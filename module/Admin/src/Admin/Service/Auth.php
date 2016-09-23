<?php

namespace Admin\Service;

use Core\Service\Service;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as AuthAdapter;
use Zend\Db\Sql\Select;

/**
 * Serviço utilizado para autenticação
 *
 * @category Admin
 * @package Service
 * @author Manoel Filho
 */
class Auth extends Service {
	/**
	 * Adapter usado para a autenticação
	 *
	 * @var Zend\Db\Adapter\Adapter
	 */
	private $dbAdapter;
	
	/**
	 * Construtor da classe
	 *
	 * @return void
	 */
	public function __construct($dbAdapter = null) {
		$this->dbAdapter = $dbAdapter;
	}
	
	/**
	 * Faz a autenticação dos usuários
	 *
	 * @param array $params        	
	 * @return array
	 */
	public function authenticate($params) {
		if (! isset ( $params ['username'] ) || ! isset ( $params ['password'] )) {
			throw new \Exception ( "Parâmetros inválidos" );
		}
		
		$password = md5 ( $params ['password'] );
		$auth = new AuthenticationService ();
		$authAdapter = new AuthAdapter ( $this->dbAdapter );
		$authAdapter->setTableName ( 'usuarios' )->setIdentityColumn ( 'email' )->setCredentialColumn ( 'senha' )->setIdentity ( $params ['username'] )->setCredential ( $password );
		$result = $auth->authenticate ( $authAdapter );
		
		if (! $result->isValid ()) {
			throw new \Exception ( "Login ou senha inválidos" );
		}
		
		// salva o usuário na sessão
		$session = $this->getServiceManager ()->get ( 'Session' );
		$session->offsetSet ( 'user', $authAdapter->getResultRowObject () );
		
		return true;
	}
	
	/**
	 * Faz o logout do sistema
	 *
	 * @return void
	 */
	public function logout() {
		$auth = new AuthenticationService ();
		$session = $this->getServiceManager ()->get ( 'Session' );
		$session->offsetUnset ( 'user' );
		$auth->clearIdentity ();
		return true;
	}
	
	/**
	 * Faz a autorização do usuário para acessar o recurso
	 *
	 * @return boolean
	 */
	
	public function authorize($moduleName, $controllerName, $actionName) {
		$auth = new AuthenticationService ();
		$role = 'visitante';
		if ($auth->hasIdentity ()) {
			$session = $this->getServiceManager ()->get ( 'Session' );
			$user = $session->offsetGet ( 'user' );
			$role = $user->categoria;
		}
		
		$resource = $controllerName . '.' . $actionName;
		$acl = $this->getServiceManager ()->get ( 'Core\Acl\Builder' )->build ();
		if ($acl->isAllowed ( $role, $resource )) {
			return true;
		}
		return false;
	}
}