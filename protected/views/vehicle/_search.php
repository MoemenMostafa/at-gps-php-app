<?php
/* @var $this VehicleController */
/* @var $model Vehicle */
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
		<?php echo $form->label($model,'device_id'); ?>
		<?php echo $form->textField($model,'device_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'serial'); ?>
		<?php echo $form->textField($model,'serial'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'colour'); ?>
		<?php echo $form->textField($model,'colour',array('size'=>45,'maxlength'=>45)); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'vehicle_type_id'); ?>
		<?php
			$records = VehicleType::model()->findAll();
			$list = CHtml::listData($records, 'id', 'type_en');
    	?>
        <?php echo $form->dropDownList($model,'vehicle_type_id',$list,array('empty' => '(Select Type)')); ?>
		<?php echo $form->error($model,'vehicle_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php
			$records = Company::model()->findAll();
			$list = CHtml::listData($records, 'id', 'name');
    	?>
        <?php echo $form->dropDownList($model,'company_id',$list,array('empty' => '(Select a Company)')); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->