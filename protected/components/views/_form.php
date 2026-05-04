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
		<?php echo $form->labelEx($model,'device_id'); ?>
       	<?php
			$records = Device::model()->findAll();
			$list = CHtml::listData($records, 'id', 'id');
    	?>
		<?php echo $form->dropDownList($model,'device_id',$list,array('empty' => '(Select Device)')); ?>
		<?php echo $form->error($model,'device_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('View'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->