<?php
define('YII_DEBUG', true);

require '/opt/frameworks/php/yii2/framework/yii.php';

$config = require dirname(__FILE__).'/protected/config/main.php';
$config['basePath'] = dirname(__FILE__).'/protected';

$app = new \yii\web\Application($config);
$app->run();
