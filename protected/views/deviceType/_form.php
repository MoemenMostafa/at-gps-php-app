<?php
/* @var $this DeviceTypeController */
/* @var $model DeviceType */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'device-type-form',
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
    
    <div class="row">
		<?php echo $form->labelEx($model,'data_arrange'); ?>
            <div  style="color:gray">Select from the following fields:</br>
            device_id, gps_datetime, longitude, latitude, speed, 		direction, 	altitude, satellites, messageID, input_status, 	output_status, 	analog_input1, analog_input2, rtc_datetime, mileage, 	speed_cam, 	rpm_cam, engine_temp_cam, fuel_level_cam, fuel_rate_cam, fuel_temp_cam, oil_press_cam, acc_pedal_cam, axel_weight_cam, odometer_cam
    	</div>
		<?php echo $form->textArea($model,'data_arrange',array('style'=>'width: 80%; height: 120px;')); ?>
		<?php echo $form->error($model,'data_arrange'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'value_arrange'); ?>
          <div  style="color:gray">Example: <0>,<1>,<2>,<6>....
    </div>
		<?php echo $form->textArea($model,'value_arrange',array('style'=>'width: 80%; height: 120px;')); ?>
		<?php echo $form->error($model,'value_arrange'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->