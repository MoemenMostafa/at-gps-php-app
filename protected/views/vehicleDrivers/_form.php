<?php
/* @var $this VehicleDriversController */
/* @var $model VehicleDrivers */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-drivers-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
		<?php echo $form->labelEx($model,'vehicle_id'); ?>
       	<?php
			$records = Vehicle::model()->findAll();
			$list = CHtml::listData($records, 'id', 'serial','name');
    	?>
		<?php echo $form->dropDownList($model,'vehicle_id',$list,array('empty' => '(Select vehicle)')); ?>
		<?php echo $form->error($model,'vehicle_id'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'driver_id'); ?>
       	<?php
			$records = Driver::model()->findAll();
			$list = CHtml::listData($records, 'id', 'name');
    	?>
		<?php echo $form->dropDownList($model,'driver_id',$list,array('empty' => '(Select Driver)')); ?>
		<?php echo $form->error($model,'driver_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'from'); ?>
		<?php echo $form->textField($model,'from'); ?>
		<?php echo $form->error($model,'from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to'); ?>
		<?php echo $form->textField($model,'to'); ?>
		<?php echo $form->error($model,'to'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->