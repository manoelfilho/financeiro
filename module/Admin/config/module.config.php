<?php

namespace Admin;

return array (
		'controllers' => array ( // Adiciona Módulos e controllers
				'invokables' => array (
						'Admin\Controller\Index' => 'Admin\Controller\IndexController',
						'Admin\Controller\Conta' => 'Admin\Controller\ContaController',
						'Admin\Controller\Movimentacao' => 'Admin\Controller\MovimentacaoController',
						'Admin\Controller\Categoria' => 'Admin\Controller\CategoriaController' 
				) 
		),
		'router' => array (
				'routes' => array (
						'admin' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/admin',
										'defaults' => array (
												'__NAMESPACE__' => 'Admin\Controller',
												'controller' => 'Index',
												'action' => 'index',
												'module' => 'admin' 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'default' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/[:controller[/:action]][/:id][/:valor]',
														'constraints' => array (
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*' 
														),
														'defaults' => array () 
												),
												'child_routes' => array (
														'wildcard' => array (
																'type' => 'Wildcard' 
														) 
												) 
										),
										'paginator' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/[:controller[/:action]][/page/:page]',
														'constraints' => array (
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'page' => '\d+' 
														),
														'defaults' => array () 
												) 
										) 
								) 
						) 
				) 
		),
		'module_layout' => array (
				'Admin' => 'layout/admin.phtml' 
		),
		'view_manager' => array (
				'template_path_stack' => array (
						'admin' => __DIR__ . '/../view' 
				) 
		),
		
		// Configurações do doctrine para este módulo Admin
		'doctrine' => array (
				'driver' => array (
						__NAMESPACE__ . '_driver' => array (
								'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
								'cache' => 'array',
								'paths' => array (
										__DIR__ . '/../src/' . __NAMESPACE__ . '/Model' 
								) 
						),
						'orm_default' => array (
								'drivers' => array (
										__NAMESPACE__ . '\Model' => __NAMESPACE__ . '_driver' 
								) 
						) 
				) 
		) 
);