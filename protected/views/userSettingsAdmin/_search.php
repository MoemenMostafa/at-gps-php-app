<?php
/* @var $this UserSettingsAdminController */
/* @var $model UserSettingsAdmin */
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
		<?php echo $form->label($model,'geofence'); ?>
		<?php echo $form->textField($model,'geofence'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'overspeed'); ?>
		<?php echo $form->textField($model,'overspeed'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rpm'); ?>
		<?php echo $form->textField($model,'rpm'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fueltemp'); ?>
		<?php echo $form->textField($model,'fueltemp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oilpres'); ?>
		<?php echo $form->textField($model,'oilpres'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'engtemp'); ?>
		<?php echo $form->textField($model,'engtemp'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fuellevel'); ?>
		<?php echo $form->textField($model,'fuellevel'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fuelrate'); ?>
		<?php echo $form->textField($model,'fuelrate'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accpedal'); ?>
		<?php echo $form->textField($model,'accpedal'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->