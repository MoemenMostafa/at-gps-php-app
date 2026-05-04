<?php
/* @var $this DeviceCommandsController */
/* @var $model DeviceCommands */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'device-commands-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

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
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'command'); ?>
		<?php echo $form->textArea($model,'command',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'command'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'user_available'); ?>
		<?php echo $form->dropDownList($model,'user_available',array( 0 => 'No', 1 =>'Yes')); ?>
		<?php echo $form->error($model,'user_available'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->