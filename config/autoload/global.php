<?php
return array (
		
		// configuração do banco de dados
		'db' => array (
				'driver' => 'Pdo',
				'username' => 'root',
				'password' => 'root',
				'dsn' => 'mysql:dbname=projfinanceiro;host=localhost',
				'driver_options' => array (
						PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'' 
				) 
		),
		// configuração do service manager
		'service_manager' => array (
				'factories' => array (
						'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
						'Session' => function ($sm) {
							return new \Zend\Session\Container ( 'projfinanceiro' );
						},
						'Admin\Service\Auth' => function ($sm) {
							$dbAdapter = $sm->get ( 'DbAdapter' );
							return new Admin\Service\Auth ( $dbAdapter );
						},
						'Cache' => function ($sm) {
							$config = $sm->get ( 'Configuration' );
							$cache = StorageFactory::factory ( array (
									'adapter' => $config ['cache'] ['adapter'],
									'plugins' => array (
											'exception_handler' => array (
													'throw_exceptions' => false 
											),
											'Serializer' 
									) 
							) );
							
							return $cache;
						} 
				) 
		),
		// configuração para o uso do doctrine
		'doctrine' => array (
				'connection' => array (
						'orm_default' => array (
								'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
								'params' => array (
										'host' => 'localhost',
										'user' => 'root',
										'password' => 'root',
										'dbname' => 'projfinanceiro',
										'charset' => 'utf8' 
								) 
						) 
				), 
		),
		
		// configuração do acl
		'acl' => array (
				'roles' => array (
						'visitante' => null,
						'permissao1' => 'visitante' 
				),
				'resources' => array (
						'Portal\Controller\Index.index',
						'Portal\Controller\Usuario.index',
						'Portal\Controller\Usuario.login',
						'Portal\Controller\Usuario.perfil',
						'Portal\Controller\Usuario.logout',
						'Portal\Controller\Usuario.cadastrar',
						'Portal\Controller\Usuario.editar',
						'Portal\Controller\Usuario.listarmunicipios',
						'Portal\Controller\Usuario.verificaremail',
						'Portal\Controller\Usuario.verificarcpf',
						'Portal\Controller\Usuario.recuperarsenha',
						'Portal\Controller\Usuario.redefinirsenha',
						'Portal\Controller\Usuario.mudarsenha',
						'Admin\Controller\Index.index',
						'Admin\Controller\Conta.index',
						'Admin\Controller\Conta.cadastrar',
						'Admin\Controller\Conta.editar',
						'Admin\Controller\Conta.excluir',
						'Admin\Controller\Movimentacao.index',
						'Admin\Controller\Movimentacao.cadastrar',
						'Admin\Controller\Movimentacao.editar',
						'Admin\Controller\Movimentacao.excluir',
						'Admin\Controller\Categoria.index',
						'Admin\Controller\Categoria.cadastrar',
						'Admin\Controller\Categoria.editar',
						'Admin\Controller\Categoria.excluir'
				),
				'privilege' => array (
						'visitante' => array (
								'allow' => array (
										'Portal\Controller\Index.index',
										'Portal\Controller\Usuario.index',
										'Portal\Controller\Usuario.login',
										'Portal\Controller\Usuario.logout',
										'Portal\Controller\Usuario.cadastrar',
										'Portal\Controller\Usuario.listarmunicipios',
										'Portal\Controller\Usuario.verificaremail',
										'Portal\Controller\Usuario.verificarcpf',
										'Portal\Controller\Usuario.recuperarsenha',
										'Portal\Controller\Usuario.redefinirsenha',
										'Portal\Controller\Usuario.mudarsenha' 
								) 
						),
						'permissao1' => array (
								'allow' => array (
										'Portal\Controller\Usuario.perfil',
										'Portal\Controller\Usuario.editar',
										'Admin\Controller\Index.index',
										'Admin\Controller\Conta.index',
										'Admin\Controller\Conta.cadastrar',
										'Admin\Controller\Conta.editar',
										'Admin\Controller\Conta.excluir',
										'Admin\Controller\Movimentacao.index',
										'Admin\Controller\Movimentacao.cadastrar',
										'Admin\Controller\Movimentacao.editar',
										'Admin\Controller\Movimentacao.excluir',
										'Admin\Controller\Categoria.index',
										'Admin\Controller\Categoria.cadastrar',
										'Admin\Controller\Categoria.editar',
										'Admin\Controller\Categoria.excluir'
								) 
						) 
				) 
		) 
);