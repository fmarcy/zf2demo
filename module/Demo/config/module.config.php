<?php

return array(
	'router' => array(
		'routes' => array(
			'demo' => array(
				'type' => 'Literal',
				'options' => array(
					'route' => '/demo',
					'defaults' => array(
						'controller' => 'demo-index-controller',
						'action' => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'view-helper' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/view-helper',
							'defaults' => array(
								'action' => 'view-helper',
							),
						),
					),
					'controller-plugin' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/controller-plugin',
							'defaults' => array(
								'action' => 'controller-plugin',
							),
						),
					),
					'form-valid' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/form-is-valid',
							'defaults' => array(
								'action' => 'form-is-valid'
							),
						),		
					),
					'form-validation' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/form-validation-1',
							'defaults' => array(
								'controller' => 'demo-post-demo1-controller',
								'action' => 'index',
							),
						),
					),
				),
			),
		),
	),
		
	'controllers' => array(
		'invokables' => array(
			'demo-index-controller' => 'Demo\Controller\IndexController',
		),	
		'factories' => array(
			'demo-post-demo1-controller' =>'Demo\Factory\PostDemo1ControllerFactory',
		),			
	),
		
	'service_manager' => array(
		'invokables' => array(
			'demo-form-filter' => 'Demo\Form\DemoFormFilter',
		),
		'factories' => array(
			'demo-form' => 'Demo\Factory\DemoFormFactory',
		),	
	),
		
	'view_manager' => array(
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),	
	),
);