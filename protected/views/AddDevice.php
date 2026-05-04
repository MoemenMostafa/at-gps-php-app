<?php
/* @var $this DeviceController */
/* @var $model Device */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'device-AddDevice-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'modem_ID'); ?>
		<?php echo $form->textField($model,'modem_ID'); ?>
		<?php echo $form->error($model,'modem_ID'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'device_type_id'); ?>
		<?php echo $form->textField($model,'device_type_id'); ?>
		<?php echo $form->error($model,'device_type_id'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('Submit'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->