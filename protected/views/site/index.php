<?php use yii\helpers\Html; ?>

<?php echo Html::a('Create New Post', array('site/create'), array('class' => 'btn btn-primary pull-right')); ?>
<div class="clearfix"></div>
<hr />

<?php if(Yii::$app->session->hasFlash('error')): ?>
<div class="alert alert-error">
	<?php echo Yii::$app->session->getFlash('error'); ?>
</div>
<?php endif; ?>

<?php if(Yii::$app->session->hasFlash('success')): ?>
<div class="alert alert-success">
	<?php echo Yii::$app->session->getFlash('success'); ?>
</div>
<?php endif; ?>

<table class="table table-striped table-hover">
	<tr>
		<td>#</td>
		<td>Title</td>
		<td>Created</td>
		<td>Updated</td>
		<td>Options</td>
	</tr>
	<?php foreach ($data as $post): ?>
	<tr>
		<td>
			<?php echo Html::a(Html::encode($post->id), array('site/read', 'id'=>$post->id)); ?>
		</td>
		<td><?php echo Html::a(Html::encode($post->title), array('site/read', 'id'=>$post->id)); ?></td>
		<td><?php echo Html::encode($post->created); ?></td>
		<td><?php echo Html::encode($post->updated); ?></td>
		<td>
			<?php echo Html::a(NULL, array('site/update', 'id'=>$post->id), array('class'=>'icon icon-edit')); ?>
			<?php echo Html::a(NULL, array('site/delete', 'id'=>$post->id), array('class'=>'icon icon-trash')); ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>