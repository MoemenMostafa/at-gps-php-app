<?php
/* @var $this CompanyController */
/* @var $model Company */
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
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'country_id'); ?>
		<?php echo $form->textField($model,'country_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'timezone_id'); ?>
		<?php echo $form->textField($model,'timezone_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'overspeed_value'); ?>
		<?php echo $form->textField($model,'overspeed_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'rpm_value'); ?>
		<?php echo $form->textField($model,'rpm_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fueltemp_value'); ?>
		<?php echo $form->textField($model,'fueltemp_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'oilpres_value'); ?>
		<?php echo $form->textField($model,'oilpres_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'engtemp_value'); ?>
		<?php echo $form->textField($model,'engtemp_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fuellevel_value'); ?>
		<?php echo $form->textField($model,'fuellevel_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fuelrate_value'); ?>
		<?php echo $form->textField($model,'fuelrate_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'accpedal_value'); ?>
		<?php echo $form->textField($model,'accpedal_value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->