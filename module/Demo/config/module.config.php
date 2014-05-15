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
				),
			),
		),
	),
		
	'controllers' => array(
		'invokables' => array(
			'demo-index-controller' => 'Demo\Controller\IndexController',
		),				
	),
		
	'view_manager' => array(
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),	
	),
);