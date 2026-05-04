<?php
/* @var $this DeviceController */
/* @var $model Device */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'device-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'device_type_id'); ?>
       	<?php
			$records = DeviceType::model()->findAll();
			$list = CHtml::listData($records, 'id', 'type_en');
    	?>
		<?php echo $form->dropDownList($model,'device_type_id',$list,array('empty' => '(Select Device Type)')); ?>
		<?php echo $form->error($model,'device_type_id'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'Company'); ?>
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