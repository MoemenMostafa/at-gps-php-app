<?php
/* @var $this CommandsController */
/* @var $model Commands */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'device_commands_id'); ?>
		<?php echo $form->textField($model,'device_commands_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'device_id'); ?>
		<?php echo $form->textField($model,'device_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->textField($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'response'); ?>
		<?php echo $form->textField($model,'response',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_recorded'); ?>
		<?php echo $form->textField($model,'date_recorded'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_sent'); ?>
		<?php echo $form->textField($model,'date_sent'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'date_response'); ?>
		<?php echo $form->textField($model,'date_response'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->