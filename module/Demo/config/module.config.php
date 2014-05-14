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