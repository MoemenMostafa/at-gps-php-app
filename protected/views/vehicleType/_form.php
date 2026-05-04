<?php
/* @var $this VehicleTypeController */
/* @var $model VehicleType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-type-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'type_ar'); ?>
		<?php echo $form->textField($model,'type_ar',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'type_ar'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type_en'); ?>
		<?php echo $form->textField($model,'type_en',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'type_en'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->