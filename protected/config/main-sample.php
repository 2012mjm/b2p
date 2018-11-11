<?php

Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Bia2projeh',
	'theme'=>'bootstrap',
	'defaultController'=>'main',
	'timezone'=>'Asia/Tehran',
	'sourceLanguage'=>'en_us',
	'language'=>'fa_ir',
	'charset'=>'UTF-8',
	
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.infrastructures.*',

		// shopping cart
		'ext.shoppingCart.*',

		'application.services.*',

		'application.services.user.*',
		'application.services.product.*',
		'application.services.credit.*',
		'application.services.report.*',
		'application.services.ticket.*',

		'application.services.admin.setting.*',
		'application.services.admin.user.*',
		'application.services.admin.product.*',
		'application.services.admin.category.*',
		'application.services.admin.subcategory.*',
		'application.services.admin.page.*',
		
		'application.extensions.eFileCloaker.*',
		'application.extensions.helpers.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
                'bootstrap.gii',
            ),
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginUrl'=>array('/user/login'),
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'page/<key:.*?>'=>'page/index',
		
				'basket/add/<id:\d+>'=>'product/addShoppingCart',
				'basket/remove/<id:\d+>'=>'product/removeShoppingCart',
				'basket'=>'product/shoppingCart',
				'buy'=>'product/buy',
				'tracking'=>'product/trackingCode',

				// category
				'category/<id:\d+>/<subId:\d+>/<title:[\w\-]+>'=>'product/category',
				'category/<id:\d+>/<title:[\w\-]+>'=>'product/category',
		
				'category/<id:\d+>/<subId:\d+>'=>'product/category',
				'category/<id:\d+>'=>'product/category',

				// tag
				'tag/<id:\d+>/<title:[\w\-]+>'=>'product/tag',
				'tag/<id:\d+>'=>'product/tag',

				// author
				'author/<username:[\w\-]+>/<name:[\w\-]+>'=>'product/author',
				'author/<username:[\w\-]+>'=>'product/author',
		
				// search 
				'search'=>'product/search',
		
				// product 
				'product/<id:\d+>/<title:[\w\-]+>'=>'product/view',
				'product/<id:\d+>'=>'product/view',
		
				// download 
				'download/<key:[\w\-]+>'=>'main/download',

				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
			'urlSuffix'=>'.html',
			'showScriptName'=>false,
			'caseSensitive'=>false,
		),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=bia2projeh',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'tablePrefix' => 'b2p_',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'main/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'bootstrap'=>array(
			'class'=>'bootstrap.components.Bootstrap',
		),
		'setting'=> array(
			'class' => 'Settings',
		),
		'jdate' => array(
			'class' => 'ext.jdate.JDateTime',
			'convert' => false,
			'jalali' => true,
			'timezone' => 'Asia/Tehran',
		),
		'pNumber' => array(
			'class' => 'ext.pNumber.PNumber',
		),
		'format'=>array(
			'class'=>'JFormatter',
		),
		'shoppingCart' => array(
			'class' => 'EShoppingCart',
			'refresh' => false,
		),
		'image'=>array(
			'class'=>'ext.image.CImageComponent',
			// GD or ImageMagick
			'driver'=>'GD',
			// ImageMagick setup path
			//'params'=>array('directory'=>'/opt/local/bin'),
		),
	),
);