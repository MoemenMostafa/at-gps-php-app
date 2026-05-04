<?php
/* @var $this RepairsController */
/* @var $model Repairs */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'repairs-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

        <?php echo $form->hiddenField($model,'id'); ?>
        
        <div class="row">
		<?php echo $form->labelEx($model,'vehicle_id'); ?>
		<?php        
                        $records = Vehicle::model()->search("list", true);   
			$list = CHtml::listData($records, 'id', 'serial');
                ?>
            
                <?php echo $form->dropDownList($model,'vehicle_id',$list);

                        echo $form->error($model,'vehicle_id'); 
                ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'location'); ?>
		<?php echo $form->textField($model,'location'); ?>
		<?php echo $form->error($model,'location'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description'); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'start_date'); ?>
		<?php echo $form->dateField($model,'start_date'); ?>
		<?php echo $form->error($model,'start_date'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'end_date'); ?>
		<?php echo $form->dateField($model,'end_date'); ?>
		<?php echo $form->error($model,'end_date'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'note'); ?>
		<?php echo $form->textArea($model,'note'); ?>
		<?php echo $form->error($model,'note'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->