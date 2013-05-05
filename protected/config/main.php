<?php
return array(
	'id' => 'webapp',
	'name' => 'My Web Application',
	'components' => array(
		// uncomment the following to use a MySQL database
		'db' => array(
			'class' => 'yii\db\Connection',
			'dsn' => 'mysql:host=home.erianna.net;dbname=yii2',
			'username' => 'yii2',
			'password' => 'uzLBVdphDZHbWEYV',
		),
		'cache' => array(
			'class' => 'yii\caching\DummyCache',
		)
	),
);
