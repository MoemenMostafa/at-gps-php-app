<?php
/* @var $this DriverController */
/* @var $model Driver */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'driver-form',
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
		<?php echo $form->labelEx($model,'dob'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker', array(
		   'model' => $model,
		   'attribute' => 'dob',
		   // additional javascript options for the date picker plugin
			'options'=>array(
			'showAnim'=>'fold',
			'dateFormat'=>'yy-mm-dd',
			'changeYear'=>true,
			'changeMonth'=>true,
			'yearRange'=>'1920:2011',
			'minDate'=> '-90Y', 
			'maxDate'=> "-Y"
			),
		));
		?>
		<?php echo $form->error($model,'dob'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'mobile'); ?>
		<?php echo $form->textField($model,'mobile',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'mobile'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'ibutton'); ?>
		<?php echo $form->textField($model,'ibutton',array('size'=>20,'maxlength'=>15)); ?>
		<?php echo $form->error($model,'ibutton'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
       	<?php
			$records = Company::model()->findAll();
			$list = CHtml::listData($records, 'id', 'name');
    	?>
		<?php echo $form->dropDownList($model,'company_id',$list,array('empty' => '(Select Company)')); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->