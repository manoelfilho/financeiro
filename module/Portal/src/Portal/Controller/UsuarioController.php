<?php

namespace Portal\Controller;

use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Admin\Model\Estado;
use Admin\Model\Municipio;
use Portal\Model\Usuario;
use Portal\Form\UsuarioForm as UsuarioForm;
use Portal\Form\Login as LoginForm;
use EmailZF2\Controller\Plugin\Mailer;
use Core\Controller\ActionController;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

/**
 * Controlador que gerencia os usuários
 *
 * @category Portal
 * @package Controller
 * @author Manoel Filho
 */
class UsuarioController extends ActionController {
	/**
	 *
	 * @var Doctrine\ORM\EntityManager
	 */
	protected $em;
	/**
	 * Seta o Entity Manager
	 */
	public function setEntityManager(EntityManager $em) {
		$this->em = $em;
	}
	/**
	 * Retorna o Entity Manager
	 */
	public function getEntityManager() {
		if (null === $this->em) {
			$this->em = $this->getServiceLocator ()->get ( 'Doctrine\ORM\EntityManager' );
		}
		return $this->em;
	}
	/**
	 * Exibe a tela de login
	 */
	public function indexAction() {
		$servico = $this->getService ( 'Session' );
		if (! $servico->offsetGet ( 'user' )) {
			$form = new LoginForm ( $this->getEntityManager () );
			return new ViewModel ( array (
					'form' => $form 
			) );
		} else {
			return $this->redirect ()->toRoute ( 'admin' );
		}
	}
	/**
	 * Exibe a tela do perfil do usuário
	 */
	public function perfilAction() {
		$servico = $this->getService ( 'Session' );
		$usuario = $servico->offsetGet ( 'user' );
		$contato = $this->getEntityManager ()->find ( 'Portal\Model\Usuario', $usuario->id );
		
		return new ViewModel ( array (
				'contato' => $contato 
		) );
	}
	/**
	 * Faz o login do usuário
	 */
	public function loginAction() {
		$request = $this->getRequest ();
		if (! $request->isPost ()) {
			throw new \Exception ( 'Acesso inválido' );
		}
		$data = $request->getPost ();
		$service = $this->getService ( 'Admin\Service\Auth' );
		$auth = $service->authenticate ( array (
				'username' => $data ['email'],
				'password' => $data ['password'] 
		) );
		return $this->redirect ()->toUrl ( 'perfil' );
	}
	/**
	 * Desconecta o usuário
	 *
	 * @return void
	 */
	public function logoutAction() {
		$service = $this->getService ( 'Admin\Service\Auth' );
		$auth = $service->logout ();
		
		return $this->redirect ()->toUrl ( '/' );
	}
	/**
	 * Faz o cadastro do usuário
	 */
	public function cadastrarAction() {
		$usuario = new Usuario ();
		$metodo = "adicionar";
		$form = new UsuarioForm ( $this->getEntityManager () );
		$hydrator = new DoctrineHydrator ( $this->getEntityManager (), get_class ( $usuario ) );
		$form->setHydrator ( $hydrator );
		$form->bind ( $usuario );
		
		$request = $this->getRequest ();
		
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				if ($this->verificaremailAction ( $usuario->getEmail () )) {
					$this->flashMessenger ()->addErrorMessage ( 'Não foi possível fazer o cadastro. O endereço eletrônico informado já está cadastrado!' );
					return $this->redirect ()->toUrl ( '/portal/usuario/cadastrar' );
				} else {
					if ($metodo == "adicionar") {
						$this->getEntityManager ()->persist ( $usuario );
						$msg = 'Usuário cadastrado com sucesso!';
					} else {
						$msg = 'Usuário atualizado!';
					}
					// criptografa a senha
					$senha = md5 ( $usuario->getSenha () );
					$usuario->setSenha ( $senha );
					// salva as datas
					$usuario->setCriacao ( new \DateTime ( "now" ) );
					$usuario->setModificacao ( new \DateTime ( "now" ) );
					// salva a categoria
					$usuario->setCategoria ( 'permissao1' );
					$this->getEntityManager ()->flush ();
					$this->flashMessenger ()->addSuccessMessage ( $msg );
					return $this->redirect ()->toUrl ( '/portal/usuario' );
				}
			}
		}
		
		return array (
				'form' => $form 
		);
	}
	/**
	 * Edita o usuário
	 */
	public function editarAction() {
		$servico = $this->getService ( 'Session' );
		$login = $servico->offsetGet ( 'user' );
		$id = $login->id;
		$usuario = $this->getEntityManager ()->find ( 'Portal\Model\Usuario', $id );
		$usuario->setSenha ( '' );
		$form = new UsuarioForm ( $this->getEntityManager () );
		$form->setAttribute ( 'action', '/portal/usuario/editar' );
		$options_municipio = array (
				'find_method' => array (
						'name' => 'findBy',
						'params' => array (
								'criteria' => array (
										'estado' => $usuario->getEstado () 
								) 
						) 
				) 
		);
		$form->get ( 'municipio' )->setOptions ( $options_municipio );
		$hydrator = new DoctrineHydrator ( $this->getEntityManager (), get_class ( $usuario ) );
		$form->setHydrator ( $hydrator );
		$form->bind ( $usuario );
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$form->setData ( $request->getPost () );
			if ($form->isValid ()) {
				// criptografa a senha
				$senha = md5 ( $usuario->getSenha () );
				$usuario->setSenha ( $senha );
				// salva a data de modificacao
				$usuario->setModificacao ( new \DateTime ( "now" ) );
				$this->getEntityManager ()->flush ();
				$this->flashMessenger ()->addSuccessMessage ( 'Dados atualizados!' );
				return $this->redirect ()->toUrl ( '/portal/usuario/perfil' );
			}
		}
		return array (
				'form' => $form,
				'usuario' => $usuario 
		);
	}
	
	/**
	 * Retorna a lista de municípios através de uma chamada ajax
	 */
	public function listarmunicipiosAction() {
		$request = $this->getRequest ();
		$estado = $this->params ()->fromPost ( 'estado' );
		
		if ($request->isPost ()) {
			$visao = new ViewModel ( array (
					'municipios' => $this->getEntityManager ()->getRepository ( 'Admin\Model\Municipio' )->findBy ( array (
							'estado' => $estado 
					), array (
							'municipio' => 'ASC' 
					) ) 
			) );
			$visao->setTerminal ( true );
			return $visao;
		} else {
			return $this->redirect ()->toRoute ( 'home' );
		}
	}
	/**
	 * Verifica a existência do mesmo endereço na base de dados
	 * Faz a verificação no próprio processo de cadastro com ajax ou ao tentar salvar
	 */
	public function verificaremailAction($email = NULL) {
		if (! $email) {
			$email = $this->params ()->fromPost ( 'email' );
			$request = $this->getRequest ();
			if ($request->isPost ()) {
				$visao = new ViewModel ( array (
						'contato' => $this->getEntityManager ()->getRepository ( 'Portal\Model\Usuario' )->findBy ( array (
								'email' => $email 
						) ) 
				) );
				$visao->setTerminal ( true );
				return $visao;
			} else {
				return $this->redirect ()->toRoute ( 'home' );
			}
		} else {
			$contato = $this->getEntityManager ()->getRepository ( 'Portal\Model\Usuario' )->findBy ( array (
					'email' => $email 
			) );
			if ($contato) {
				return true;
			} else {
				return false;
			}
		}
	}
	/**
	 * Verifica a existência do mesmo CPF na base de dados
	 * Faz a verificação no próprio processo de cadastro com ajax ou ao tentar salvar
	 */
	public function verificarcpfAction($cpf = NULL) {
		if (! $cpf) {
			$request = $this->getRequest ();
			$cpf = $this->params ()->fromPost ( 'cpf' );
			if ($request->isPost ()) {
				$visao = new ViewModel ( array (
						'contato' => $this->getEntityManager ()->getRepository ( 'Portal\Model\Usuario' )->findBy ( array (
								'cpf' => $cpf 
						) ) 
				) );
				$visao->setTerminal ( true );
				return $visao;
			} else {
				return $this->redirect ()->toRoute ( 'home' );
			}
		} else {
			$contato = $this->getEntityManager ()->getRepository ( 'Portal\Model\Usuario' )->findBy ( array (
					'cpf' => $cpf 
			) );
			if ($contato) {
				return true;
			} else {
				return false;
			}
		}
	}
	/**
	 * Exibe tela de recuperação de senha e recebe dados para recuperação
	 */
	public function recuperarsenhaAction() {
		$request = $this->getRequest ();
		if ($request->isPost ()) {
			$email = $this->params ()->fromPost ( 'email' );
			
			$contato = $this->getEntityManager ()->getRepository ( 'Portal\Model\Usuario' )->findOneBy ( array (
					'email' => $email 
			) );
			
			if ($contato) {
				
				// se econtrar o endereço eletrônico salva o código na base de dados para recuperação de senha
				// depois encaminha mensagem com procedimento para cadastro de nova senha
				
				// hash com email
				$hash = md5 ( $contato->getEmail () );
				$hash .= date ( 'Hms' );
				
				// seta o hash
				$contato->setCodigo_mudanca ( $hash );
				
				// mensagem
				$mensagem = "<p>Recebemos o pedido de recuperação de senha no Sistema Financeiro. Clique no link abaixo para definir uma nova senha.</p>";
				$mensagem .= "<p><a href=\"http://" . $_SERVER ['SERVER_NAME'] . "/portal/usuario/redefinirsenha?codVerificacao=" . $hash . "\">http://" . $_SERVER ['SERVER_NAME'] . "/portal/usuario/redefinisenha?codVerificacao=" . $hash . "</a></p>";
				
				$this->emailAction ( $contato, 'Undime - Mudança de senha', $mensagem );
				
				$this->getEntityManager ()->persist ( $contato );
				$this->getEntityManager ()->flush ();
				
				$this->flashMessenger ()->addSuccessMessage ( 'Siga as instruções de redefinição encaminhadas para seu endereco eletrônico' );
				return $this->redirect ()->toUrl ( '/portal/usuario' );
			} else {
				$this->flashMessenger ()->addErrorMessage ( 'Este endereço não está cadastrado' );
				return $this->redirect ()->toUrl ( '/portal/usuario/recuperarsenha' );
				return new ViewModel ();
			}
		}
	}
	/**
	 * Envia e-mail com parâmetros Objeto Contato, String Assunto e String Mensagem
	 */
	public function emailAction(Usuario $contato, $assunto, $mensagem) {
		
	}
	/**
	 * Exibe tela com campos para nova senha de cadastro.
	 * Verifica se o link tem o código de mudança
	 */
	public function redefinirsenhaAction() {
		if ($this->getRequest ()->isGet ()) {
			$codVerificacao = $this->params ()->fromQuery ( 'codVerificacao' );
			$contato = $this->getEntityManager ()->getRepository ( 'Portal\Model\Usuario' )->findOneBy ( array (
					'codigo_mudanca' => $codVerificacao 
			) );
			if ($contato) {
				return new ViewModel ( array (
						'hash' => $codVerificacao 
				) );
			} else {
				return $this->redirect ()->toRoute ( 'home' );
			}
		} else {
			return $this->redirect ()->toRoute ( 'home' );
		}
	}
	/**
	 * Recebe dados do formulário com nova senha e faz a mudança
	 */
	public function mudarsenhaAction() {
		if ($this->getRequest ()->isPost ()) {
			$codVerificacao = $this->params ()->fromPost ( 'codVerificacao' );
			$novaSenha = $this->params ()->fromPost ( 'senha' );
			
			if ($codVerificacao) {
				
				$contato = $this->getEntityManager ()->getRepository ( 'Portal\Model\Usuario' )->findOneBy ( array (
						'codigo_mudanca' => $codVerificacao 
				) );
				
				$contato->setSenha ( md5 ( $novaSenha ) );
				$contato->setCodigo_mudanca ( null );
				
				$this->getEntityManager ()->persist ( $contato );
				$this->getEntityManager ()->flush ();
				
				$this->flashMessenger ()->addSuccessMessage ( 'Senha redefinida com sucesso! Você pode acessar o sistema novamente com a nova senha.' );
				$this->redirect ()->toUrl ( '/portal/usuario' );
			} else {
				return $this->redirect ()->toRoute ( 'home' );
			}
		} else {
			return $this->redirect ()->toRoute ( 'home' );
		}
	}
}