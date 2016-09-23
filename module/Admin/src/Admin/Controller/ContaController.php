<?php

namespace Admin\Controller;

use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Admin\Model\Conta;
use Admin\Form\Conta as ContaForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * Controlador que gerencia as contas
 *
 * @category Admin
 * @package Controller
 * @author Manoel Filho
 */
class ContaController extends ActionController {
	public function indexAction() {
		$servico = $this->getService ( 'Session' );
		$usuario = $servico->offsetGet ( 'user' );
		
		return new ViewModel ( array (
				'contas' => $this->getEntityManager ()->getRepository ( 'Admin\Model\Conta' )->findBy ( array (
						'usuario_id' => $usuario->id
				) ) 
		) );
	}
	public function cadastrarAction() {
		$conta = new Conta ();
		$form = new ContaForm ();
		$hydrator = new DoctrineHydrator ( $this->getEntityManager (), get_class ( $conta ) );
		$form->setHydrator ( $hydrator );
		$form->bind ( $conta );
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				
				$servico = $this->getService ( 'Session' );
				$usuario = $servico->offsetGet ( 'user' );
				
				$conta->setCriacao ( new \DateTime ( "now" ) );
				$conta->setModificacao ( new \DateTime ( "now" ) );
				$conta->setUsuario_id ( $usuario->id );
				
				$this->getEntityManager ()->persist ( $conta );
				$this->getEntityManager ()->flush ();
				$this->flashMessenger ()->addSuccessMessage ( 'Conta cadastrada com sucesso' );
				return $this->redirect ()->toUrl ( '/admin/conta' );
			}
		}
		return new ViewModel ( array (
				'form' => $form 
		) );
	}
	public function editarAction() {
		$servico = $this->getService ( 'Session' );
		$usuario = $servico->offsetGet ( 'user' );
		
		$conta = new Conta ();
		
		if ($this->params ( 'id' ) > 0) {
			$conta = $this->getEntityManager ()->getRepository ( 'Admin\Model\Conta' )->findOneBy ( array (
					'usuario_id' => $usuario->id,
					'id' => $this->params ( 'id' ) 
			) );
		}
		
		$form = new ContaForm ();
		$form->setAttribute ( 'action', '' );
		$form->setHydrator ( new DoctrineHydrator ( $this->getEntityManager (), 'Admin\Model\Conta' ) );
		$form->bind ( $conta );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			
			$form->setInputFilter ( $conta->getInputFilter () );
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				$em = $this->getEntityManager ();
				
				$em->persist ( $conta );
				$em->flush ();
				
				$this->flashMessenger ()->addSuccessMessage ( 'Conta atualizada' );
				
				return $this->redirect ()->toUrl ( '/admin/conta' );
			}
		}
		
		return new ViewModel ( array (
				'form' => $form 
		) );
	}
	public function excluirAction() {
		$servico = $this->getService ( 'Session' );
		$usuario = $servico->offsetGet ( 'user' );
		$id = $this->params ( 'id' );
		if (! $id) {
			return $this->redirect ()->toUrl ( '/admin/conta' );
		}
		$conta = $this->getEntityManager ()->getRepository ( 'Admin\Model\Conta' )->findOneBy ( array (
				'usuario_id' => $usuario->id,
				'id' => $id 
		) );
		if ($conta instanceof Conta) {
			$this->getEntityManager ()->remove ( $conta );
			$this->getEntityManager ()->flush ();
			$this->flashMessenger ()->addSuccessMessage ( 'Conta e suas respectivas movimentações removidas com sucesso.' );
			return $this->redirect ()->toUrl ( '/admin/conta' );
		} else {
			$this->flashMessenger ()->addWarningMessage ( 'Conta inexistente.' );
			return $this->redirect ()->toUrl ( '/admin/conta' );
		}
	}
}