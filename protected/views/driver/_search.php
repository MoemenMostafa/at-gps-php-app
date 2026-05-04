<?php
/* @var $this DriverController */
/* @var $model Driver */
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
		<?php echo $form->label($model,'mobile'); ?>
		<?php echo $form->textField($model,'mobile',array('size'=>20,'maxlength'=>20)); ?>
	</div>
    
        <div class="row">
		<?php echo $form->label($model,'ibutton'); ?>
		<?php echo $form->textField($model,'ibutton',array('size'=>20,'maxlength'=>15)); ?>
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
		<?php echo $form->labelEx($model,'Company'); ?>
       	<?php
			$records = Company::model()->findAll();
			$list = CHtml::listData($records, 'id', 'name');
    	?>
		<?php echo $form->dropDownList($model,'company_id',$list,array('empty' => '(Select Company)')); ?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->