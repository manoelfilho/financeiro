<?php

namespace Admin\Controller;

use Zend\Paginator\Paginator;
use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Admin\Model\Categoria;
use Admin\Form\Categoria as CategoriaForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * Controlador que gerencia as categorias
 *
 * @category Admin
 * @package Controller
 * @author Manoel Filho
 */
class CategoriaController extends ActionController {
	public function indexAction() {
		$servico = $this->getService ( 'Session' );
		$usuario = $servico->offsetGet ( 'user' );
		
		return new ViewModel ( array (
				'categorias' => $this->getEntityManager ()->getRepository ( 'Admin\Model\Categoria' )->findBy ( array (
						'usuario_id' => $usuario->id 
				) ) 
		) );
	}
	public function cadastrarAction() {
		$categoria = new Categoria ();
		$form = new CategoriaForm ();
		$hydrator = new DoctrineHydrator ( $this->getEntityManager (), get_class ( $categoria ) );
		$form->setHydrator ( $hydrator );
		$form->bind ( $categoria );
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				
				$servico = $this->getService ( 'Session' );
				$usuario = $servico->offsetGet ( 'user' );
				
				$categoria->setCriacao ( new \DateTime ( "now" ) );
				$categoria->setModificacao ( new \DateTime ( "now" ) );
				$categoria->setUsuarioId ( $usuario->id );
				
				$this->getEntityManager ()->persist ( $categoria );
				$this->getEntityManager ()->flush ();
				$this->flashMessenger ()->addSuccessMessage ( 'Categoria cadastrada com sucesso' );
				return $this->redirect ()->toUrl ( '/admin/categoria' );
			}
		}
		return new ViewModel ( array (
				'form' => $form 
		) );
	}
	public function editarAction() {
		$servico = $this->getService ( 'Session' );
		$usuario = $servico->offsetGet ( 'user' );
		
		$categoria = new Categoria ();
		
		if ($this->params ( 'id' ) > 0) {
			$categoria = $this->getEntityManager ()->getRepository ( 'Admin\Model\Categoria' )->findOneBy ( array (
					'usuario_id' => $usuario->id,
					'id' => $this->params ( 'id' ) 
			) );
		}
		
		$form = new CategoriaForm ();
		$form->setAttribute ( 'action', '' );
		$form->setHydrator ( new DoctrineHydrator ( $this->getEntityManager (), 'Admin\Model\Categoria' ) );
		$form->bind ( $categoria );
		
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			
			$form->setInputFilter ( $categoria->getInputFilter () );
			$form->setData ( $request->getPost () );
			
			if ($form->isValid ()) {
				
				$categoria->setModificacao ( new \DateTime ( "now" ) );
				$em = $this->getEntityManager ();
				
				$em->persist ( $categoria );
				$em->flush ();
				
				$this->flashMessenger ()->addSuccessMessage ( 'Categoria atualizada' );
				
				return $this->redirect ()->toUrl ( '/admin/categoria' );
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
			return $this->redirect ()->toUrl ( '/admin/categoria' );
		}
		$categoria = $this->getEntityManager ()->getRepository ( 'Admin\Model\Categoria' )->findOneBy ( array (
				'usuario_id' => $usuario->id,
				'id' => $id 
		) );
		if ($categoria instanceof Categoria) {
			$this->getEntityManager ()->remove ( $categoria );
			$this->getEntityManager ()->flush ();
			$this->flashMessenger ()->addSuccessMessage ( 'Categoria removida com sucesso.' );
			return $this->redirect ()->toUrl ( '/admin/categoria' );
		} else {
			$this->flashMessenger ()->addWarningMessage ( 'Categoria inexistente.' );
			return $this->redirect ()->toUrl ( '/admin/categoria' );
		}
	}
}