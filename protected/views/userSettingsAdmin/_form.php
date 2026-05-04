<?php
/* @var $this UserSettingsAdminController */
/* @var $model UserSettingsAdmin */
/* @var $form CActiveForm */
?>

<div class="form">

<?php 
	$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'<h2>Alerts Settings:</h2>',
		));
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-settings-admin-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'geofence'); ?>
		<?php echo $form->dropDownList($model,'geofence',array('1'=>'On','0'=>'Off')); ?>
		<?php echo $form->error($model,'geofence'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'overspeed'); ?>
		<?php echo $form->dropDownList($model,'overspeed',array('1'=>'On','0'=>'Off')); ?>
		<?php echo $form->error($model,'overspeed'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rpm'); ?>
		<?php echo $form->dropDownList($model,'rpm',array('1'=>'On','0'=>'Off')); ?>
		<?php echo $form->error($model,'rpm'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fueltemp'); ?>
		<?php echo $form->dropDownList($model,'fueltemp',array('1'=>'On','0'=>'Off')); ?>
		<?php echo $form->error($model,'fueltemp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oilpres'); ?>
		<?php echo $form->dropDownList($model,'oilpres',array('1'=>'On','0'=>'Off')); ?>
		<?php echo $form->error($model,'oilpres'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'engtemp'); ?>
		<?php echo $form->dropDownList($model,'engtemp',array('1'=>'On','0'=>'Off')); ?>
		<?php echo $form->error($model,'engtemp'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fuellevel'); ?>
		<?php echo $form->dropDownList($model,'fuellevel',array('1'=>'On','0'=>'Off')); ?>
		<?php echo $form->error($model,'fuellevel'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fuelrate'); ?>
		<?php echo $form->dropDownList($model,'fuelrate',array('1'=>'On','0'=>'Off')); ?>
		<?php echo $form->error($model,'fuelrate'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'accpedal'); ?>
		<?php echo $form->dropDownList($model,'accpedal',array('1'=>'On','0'=>'Off')); ?>
		<?php echo $form->error($model,'accpedal'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>
<?php $this->endWidget(); ?>

</div><!-- form -->