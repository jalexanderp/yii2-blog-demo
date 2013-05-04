<?php use yii\helpers\Html; ?>

<?php $form = $this->beginWidget('yii\widgets\ActiveForm', array(
	'options' => array('class' => 'form-horizontal'),
)); ?>
	<?php echo $form->field($model, 'title')->textInput(array('class' => 'span8')); ?>
	<?php echo $form->field($model, 'content')->textArea(array('class' => 'span8')); ?>
	<div class="form-actions">
		<?php echo Html::submitButton('Submit', null, null, array('class' => 'btn btn-primary')); ?>
	</div>
<?php $this->endWidget(); ?>