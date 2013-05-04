<?php use yii\helpers\Html; ?>

<?php echo Html::a('Create New Post', array('site/create'), array('class' => 'btn btn-primary pull-right')); ?>
<div class="clearfix"></div>
<hr />

<?php if(Yii::$app->session->hasFlash('PostDeletedError')): ?>
<div class="alert alert-error">
	There was an error deleting your post!
</div>
<?php endif; ?>

<?php if(Yii::$app->session->hasFlash('PostDeleted')): ?>
<div class="alert alert-success">
	Your post has successfully been deleted!
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
			<?php echo Html::a($post->id, array('site/read', 'id'=>$post->id)); ?>
		</td>
		<td><?php echo Html::a($post->title, array('site/read', 'id'=>$post->id)); ?></td>
		<td><?php echo $post->created; ?></td>
		<td><?php echo $post->updated; ?></td>
		<td>
			<?php echo Html::a(NULL, array('site/update', 'id'=>$post->id), array('class'=>'icon icon-edit')); ?>
			<?php echo Html::a(NULL, array('site/delete', 'id'=>$post->id), array('class'=>'icon icon-trash')); ?>
		</td>

	</tr>
	<?php endforeach; ?>
</table>