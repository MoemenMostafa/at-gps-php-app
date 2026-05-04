<?php
/* @var $this VehicleController */
/* @var $model Vehicle */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    
	<div class="row">
            <?php echo $form->labelEx($model,'device_id'); ?>
            <?php
                $records = Device::model()->listDevices();
                $list = CHtml::listData($records, 'id', 'id');          
            ?> 
            <?php echo $form->dropDownList($model,'device_id',$list,array(
                'empty' => '(Select a Device)',
                'ajax' => array(
                                'type'=>'POST',
                                'url'=>CController::createUrl('commands/dynamicvehicles'),
                                'dataType'=>'json', 
                                'success'=>'function(data) {
                                                        $("#Trip_vehicle_id").html(data.dropDownVehicle);
                                                        $("#Trip_route_id").html(data.dropDownRoute);
                                                        $("#Trip_driver_id").html(data.dropDownDriver);
                                                }',
                        )
        
            )); ?>
            <?php echo $form->error($model,'device_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'serial'); ?>
		<?php echo $form->textField($model,'serial'); ?>
		<?php echo $form->error($model,'serial'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'model'); ?>
		<?php echo $form->textField($model,'model',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'model'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'colour'); ?>
		<?php echo $form->textField($model,'colour',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'colour'); ?>
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
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->