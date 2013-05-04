<?php use yii\helpers\Html as Html; ?>
<!doctype html>
<html lang="<?php \Yii::$app->language?>">
	<head>
		<meta charset="utf-8" />
		<title><?php echo Html::encode(\Yii::$app->name); ?></title>
		<link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/css/bootstrap-combined.min.css" rel="stylesheet">
		<script src="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.1/js/bootstrap.min.js"></script>
	</head>
	<body>
  		<div class="container">
  			<div class="navbar navbar-inverse">
  				<div class="container">
	 				<div class="navbar-inner">
	    				<a class="brand" href="/"><?php echo Html::encode(\Yii::$app->name); ?></a>
					</div>
				</div>
			</div>
    		<div class="content">
				<?php echo $content?>
			</div>
  		</div>
	</body>
</html>