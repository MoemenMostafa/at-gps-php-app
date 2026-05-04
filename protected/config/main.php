<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'atgps',
	'theme'=>'abound',
	'defaultController'=>'site/login',
	
	

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.EGMap.*',
		'ext.KeenActiveDataProvider',
                'ext.RelatedSearchBehavior',
		'ext.CJuiDateTimePicker.CJuiDateTimePicker',
                'ext.EExcelView',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'LinkinPark',
			// If removed, Gii defaults to "127.0.0.1" only. Edit carefully to taste.
			#'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),
    
        
	// application components
	'components'=>array(
		/*'session' => array(
			'class' => 'CDbHttpSession',
			'timeout' => 10, //Seconds
   		),*/
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'loginRequiredAjaxResponse' => 'YII_LOGIN_REQUIRED',
                        'class'=>'application.components.EWebUser',
		),
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'connectionString' => 'mysql:host=10.114.0.2;dbname=atgps',
			'emulatePrepare' => true,
			'username' => 'atgps',
			'password' => 'gps123',
			'charset' => 'utf8'
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
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
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'moemen.a1@gmail.com',
		'adminEmailPassword'=>'LinkinPark123',
		'dbHost' => '10.114.0.2',
		'mapsUrl' => 'http://maps.googleapis.com/maps/api/js?libraries=drawing&key=AIzaSyCMtIMZsa1Oq5eJhlIHVcQW_K02kIVAt5I'
	),
);

echo Yii::app()->session->timeout;