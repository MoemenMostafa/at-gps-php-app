<?php
/* @var $this CompanyController */
/* @var $model Company */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'company-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'country'); ?>
       	<?php
			$records = Country::model()->findAll();
			$list = CHtml::listData($records, 'id', 'name');
    	?>
		<?php echo $form->dropDownList($model,'country_id',$list,array('empty' => '(Select Country)')); ?>
		<?php echo $form->error($model,'country.name'); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'timezone'); ?>
       	<?php
			$records = Timezone::model()->findAll();
			$list = CHtml::listData($records, 'id', 'Timezone');
    	?>
		<?php echo $form->dropDownList($model,'timezone_id',$list,array('empty' => '(Select Time Zone)')); ?>
		<?php echo $form->error($model,'timezone.name'); ?>
	</div>
        <div class="row">
		<?php echo $form->labelEx($model,'geofence'); ?>
			<?php echo $form->dropDownList($model,'geofence',array('0' => 'Off','1' => 'On')); ?>
		<?php echo $form->error($model,'geofence'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'overspeed_value'); ?>
		<?php echo $form->textField($model,'overspeed_value'); ?>
		<?php echo $form->error($model,'overspeed_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'rpm_value'); ?>
		<?php echo $form->textField($model,'rpm_value'); ?>
		<?php echo $form->error($model,'rpm_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fueltemp_value'); ?>
		<?php echo $form->textField($model,'fueltemp_value'); ?>
		<?php echo $form->error($model,'fueltemp_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'oilpres_value'); ?>
		<?php echo $form->textField($model,'oilpres_value'); ?>
		<?php echo $form->error($model,'oilpres_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'engtemp_value'); ?>
		<?php echo $form->textField($model,'engtemp_value'); ?>
		<?php echo $form->error($model,'engtemp_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fuellevel_value'); ?>
		<?php echo $form->textField($model,'fuellevel_value'); ?>
		<?php echo $form->error($model,'fuellevel_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fuelrate_value'); ?>
		<?php echo $form->textField($model,'fuelrate_value'); ?>
		<?php echo $form->error($model,'fuelrate_value'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'accpedal_value'); ?>
		<?php echo $form->textField($model,'accpedal_value'); ?>
		<?php echo $form->error($model,'accpedal_value'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->