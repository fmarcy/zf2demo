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
					'form-validation-1' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/form-validation-1',
							'defaults' => array(
								'controller' => 'demo-post-demo1-controller',
								'action' => 'index',
							),
						),
					),
					'form-validation-2' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/form-validation-2',
							'defaults' => array(
								'controller' => 'demo-post-demo2-controller',
								'action' => 'index',
							),
						),
					),
					'tablegateway' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/tablegateway',
							'defaults' => array(
								'controller' => 'demo-tablegateway-controller',
								'action' => 'index',
							),
						),
					),
					'tablegateway-insert-company' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/tablegateway/insert-company/:name',
							'defaults' => array(
								'controller' => 'demo-tablegateway-controller',
								'action' => 'insert-company',
							),
						),
					),
					'ffmpeg' => array(
						'type' => 'Segment',
						'options' => array(
							'route' => '/ffmpeg',
							'defaults' => array(
								'controller' => 'demo-ffmpeg-controller',
								'action' => 'index',
							),
						),
					),
					'doc' => array(
						'type' => 'Literal',
						'options' => array(
							'route' => '/liens-doc',
							'defaults' => array(
								'action' => 'liens-doc',
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
			'demo-post-demo2-controller' => 'Demo\Controller\PostDemo2Controller',
		),	
		'factories' => array(
			'demo-post-demo1-controller' =>'Demo\Factory\PostDemo1ControllerFactory',
			'demo-tablegateway-controller' => 'Demo\Factory\TableGatewayDemoControllerFactory',
			'demo-ffmpeg-controller' => 'Demo\Factory\FfmpegControllerFactory',
		),			
	),
		
	'service_manager' => array(
		'invokables' => array(
			'demo-form-filter' => 'Demo\Form\DemoFormFilter',
		),
		'factories' => array(
			'demo-form' => 'Demo\Factory\DemoFormFactory',
			'company-table' => 'Demo\Factory\CompanyTableFactory',
			'company-table2' => 'Demo\Factory\CompanyTable2Factory',
		),	
	),
		
	'view_manager' => array(
		'template_path_stack' => array(
			__DIR__ . '/../view',
		),	
	),
);