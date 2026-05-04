<?php
/* @var $this DeviceController */
/* @var $model Device */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id',array('size'=>16,'maxlength'=>16)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'device_type_id'); ?>
       	<?php
			$records = DeviceType::model()->findAll();
			$list = CHtml::listData($records, 'id', 'type_en');
    	?>
		<?php echo $form->dropDownList($model,'device_type_id',$list,array('empty' => '(Select Device Type)')); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'Company'); ?>
       	<?php
			$records = Company::model()->findAll();
			$list = CHtml::listData($records, 'id', 'name');
    	?>
		<?php echo $form->dropDownList($model,'company_id',$list,array('empty' => '(Select Company)')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->