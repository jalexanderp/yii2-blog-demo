<?php use yii\helpers\Html; ?>
<div class="pull-right btn-group">
	<?php echo Html::a('Update', array('site/update', 'id' => $post->id), array('class' => 'btn btn-primary')); ?>
	<?php echo Html::a('Delete', array('site/delete', 'id' => $post->id), array('class' => 'btn btn-danger')); ?>
</div>

<h1><?php echo Html::encode($post->title); ?></h1>
<p><?php echo Html::encode($post->content); ?></p>
<hr />
<time>Created On: <?php echo Html::encode($post->created); ?></time><br />
<time>Updated On: <?php echo Html::encode($post->updated); ?></time>