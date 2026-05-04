<?php
/* @var $this DeviceCommandsController */
/* @var $model DeviceCommands */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>



	<div class="row">
		<?php echo $form->labelEx($model,'deviceType.type_en'); ?>
                <?php
                    $records = DeviceType::model()->findAll();
                    $list = CHtml::listData($records, 'id', 'type_en');
                ?>
		<?php echo $form->dropDownList($model,'device_type_id',$list,array('empty' => '(Select Device Type)')); ?>
		<?php echo $form->error($model,'device_type_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'command'); ?>
		<?php echo $form->textField($model,'command',array('size'=>60,'maxlength'=>255)); ?>
	</div>
    
        <div class="row">
		<?php echo $form->labelEx($model,'user_available'); ?>
		<?php echo $form->dropDownList($model,'user_available',array(''=>'All', 0 => 'No', 1 =>'Yes')); ?>
		<?php echo $form->error($model,'user_available'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->