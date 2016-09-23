<?php

namespace Portal;

return array (
		'router' => array (
				'routes' => array (
						'home' => array (
								'type' => 'Segment',
								'options' => array (
										'route' => '/[page/:page]',
										'defaults' => array (
												'controller' => 'Portal\Controller\Index',
												'action' => 'index',
												'module' => 'portal' 
										) 
								) 
						),
						'application' => array (
								'type' => 'Literal',
								'options' => array (
										'route' => '/portal',
										'defaults' => array (
												'controller' => 'Index',
												'action' => 'index',
												'__NAMESPACE__' => 'Portal\Controller',
												'module' => 'portal' 
										) 
								),
								'may_terminate' => true,
								'child_routes' => array (
										'default' => array (
												'type' => 'Segment',
												'options' => array (
														'route' => '/[:controller[/:action]]',
														'constraints' => array (
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action' => '[a-zA-Z][a-zA-Z0-9_-]*' 
														),
														'defaults' => array () 
												),
												'child_routes' => array ( // permite mandar dados pela url
														'wildcard' => array (
																'type' => 'Wildcard' 
														) 
												) 
										) 
								) 
						) 
				) 
		),
		'controllers' => array (
				'invokables' => array (
						'Portal\Controller\Index' => 'Portal\Controller\IndexController',
						'Portal\Controller\Usuario' => 'Portal\Controller\UsuarioController' 
				) 
		),
		'view_manager' => array (
				'display_not_found_reason' => true,
				'display_exceptions' => true,
				'doctype' => 'HTML5',
				'not_found_template' => 'error/404',
				'exception_template' => 'error/index',
				'template_map' => array (
						'layout/layout' => __DIR__ . '/../view/layout/site.phtml',
						'error/404' => __DIR__ . '/../view/error/404.phtml',
						'error/index' => __DIR__ . '/../view/error/index.phtml' 
				),
				'template_path_stack' => array (
						'portal' => __DIR__ . '/../view' 
				) 
		),
		// Configurações do doctrine para este módulo Portal
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
