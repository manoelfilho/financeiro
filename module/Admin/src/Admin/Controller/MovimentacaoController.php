<?php

namespace Admin\Controller;

use Zend\Paginator\Paginator;
use Zend\Paginator\Adapter\ArrayAdapter;
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Admin\Model\Movimentacao;
use Admin\Form\Movimentacao as MovimentacaoForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * Controlador que gerencia as movimentações
 *
 * @category Admin
 * @package Controller
 * @author Manoel Filho
 */
class MovimentacaoController extends ActionController {
	public function indexAction() {
		$servico = $this->getService ( 'Session' );
		$usuario = $servico->offsetGet ( 'user' );
		$movimentacoes = $this->getEntityManager ()->getRepository ( 'Admin\Model\Movimentacao' )->findBy ( array (
				'usuario_id' => $usuario->id 
		), array (
				'data' => 'DESC' 
		) );
		$page = $this->params ()->fromRoute ( 'page' );
		$paginator = new Paginator ( new ArrayAdapter ( $movimentacoes ) );
		$paginator->setCurrentPageNumber ( $page );
		$paginator->setDefaultItemCountPerPage ( 20 );
		
		return new ViewModel ( array (
				'movimentacoes' => $paginator,
				' page' => $page 
		) );
	}
	public function cadastrarAction() {
		$servico = $this->getService ( 'Session' );
		$usuario = $servico->offsetGet ( 'user' );
		$movimentacao = new Movimentacao ();
		$form = new MovimentacaoForm ( $this->getEntityManager () );
		$opcoes_conta = array (
				'find_method' => array (
						'name' => 'findBy',
						'params' => array (
								'criteria' => array (
										'usuario_id' => $usuario->id 
								) 
						) 
				) 
		);
		$form->get ( 'conta' )->setOptions ( $opcoes_conta );
		$form->get ( 'categoria' )->setOptions ( $opcoes_conta );
		
		$hydrator = new DoctrineHydrator ( $this->getEntityManager (), get_class ( $movimentacao ) );
		$form->setHydrator ( $hydrator );
		$form->bind ( $movimentacao );
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$movimentacao->setCriacao ( new \DateTime ( "now" ) );
				$movimentacao->setModificacao ( new \DateTime ( "now" ) );
				
				$data_ = explode ( '/', $this->params ()->fromPost ( 'data_' ) );
				$data = $data_ [2] . '-' . $data_ [1] . '-' . $data_ [0];
				
				$movimentacao->setData ( new \DateTime ( $data ) );
				
				$movimentacao->setUsuario_id ( $usuario->id );
				
				$this->getEntityManager ()->persist ( $movimentacao );
				$this->getEntityManager ()->flush ();
				$this->flashMessenger ()->addSuccessMessage ( 'Movimentação cadastrada com sucesso' );
				return $this->redirect ()->toUrl ( '/admin/movimentacao' );
			}
		}
		return new ViewModel ( array (
				'form' => $form 
		) );
	}
	public function editarAction() {
		$servico = $this->getService ( 'Session' );
		$usuario = $servico->offsetGet ( 'user' );
		$movimentacao = new Movimentacao ();
		if ($this->params ( 'id' ) > 0) {
			$movimentacao = $this->getEntityManager ()->getRepository ( 'Admin\Model\Movimentacao' )->findOneBy ( array (
					'usuario_id' => $usuario->id,
					'id' => $this->params ( 'id' ) 
			) );
		}
		$form = new MovimentacaoForm ( $this->getEntityManager () );
		$form->setAttribute ( 'action', '' );
		$form->get ( 'data_' )->setAttribute ( 'value', $movimentacao->getData ()->format ( 'd/m/Y' ) );
		$opcoes_conta = array (
				'find_method' => array (
						'name' => 'findBy',
						'params' => array (
								'criteria' => array (
										'usuario_id' => $usuario->id 
								) 
						) 
				) 
		);
		$form->get ( 'conta' )->setOptions ( $opcoes_conta );
		$form->get ( 'categoria' )->setOptions ( $opcoes_conta );
		$form->setHydrator ( new DoctrineHydrator ( $this->getEntityManager (), 'Admin\Model\Movimentacao' ) );
		$form->bind ( $movimentacao );
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setInputFilter ( $movimentacao->getInputFilter () );
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				$movimentacao->setModificacao ( new \DateTime ( "now" ) );
				$data_ = explode ( '/', $this->params ()->fromPost ( 'data_' ) );
				$data = $data_ [2] . '-' . $data_ [1] . '-' . $data_ [0];
				$movimentacao->setData ( new \DateTime ( $data ) );
				$em = $this->getEntityManager ();
				$em->persist ( $movimentacao );
				$em->flush ();
				$this->flashMessenger ()->addSuccessMessage ( 'Movimentação atualizada' );
				return $this->redirect ()->toUrl ( '/admin/movimentacao' );
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
			return $this->redirect ()->toUrl ( '/admin/movimentacao' );
		}
		$movimentacao = $this->getEntityManager ()->getRepository ( 'Admin\Model\Movimentacao' )->findOneBy ( array (
				'usuario_id' => $usuario->id,
				'id' => $id 
		) );
		if ($movimentacao instanceof Movimentacao) {
			$this->getEntityManager ()->remove ( $movimentacao );
			$this->getEntityManager ()->flush ();
			$this->flashMessenger ()->addSuccessMessage ( 'Movimentação removida com sucesso.' );
			return $this->redirect ()->toUrl ( '/admin/movimentacao' );
		} else {
			$this->flashMessenger ()->addWarningMessage ( 'Movimentação inexistente.' );
			return $this->redirect ()->toUrl ( '/admin/movimentacao' );
		}
	}
}