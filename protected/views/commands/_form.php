<?php
/* @var $this CommandsController */
/* @var $model Commands */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'commands-form',
	'enableAjaxValidation'=>false,
        'action'=>Yii::app()->createUrl('/commands/create'),
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
                                'url'=>CController::createUrl('commands/selectVehicle'),
                                'dataType'=>'json', 
                                'success'=>'function(data) {
                                                        
                                                        $("#Vehicle_id").html(data.dropDownVehicle);
                                                        $("#DeviceType_type_en").val(data.device_type);
                                                        $("#Commands_device_commands_id").html(data.dropDownCommand);
                                                        $("#Commands_device_commands_id").removeAttr("disabled");
                                                        
                                                }',
                        )
                
                
                )); ?>
            <?php echo $form->error($model,'device_id'); ?>
	</div>
        
        <div class="row">
            <?php echo $form->labelEx($model,'Vehicle_no'); ?>
            <?php
                $records = Vehicle::model()->search("list",true);
                $list = CHtml::listData($records, 'id', 'serial');          
            ?> 
            <?php echo $form->dropDownList(vehicle::model(),'id',$list,array(
                'empty' => '(Select a Vehicle)',
                'ajax' => array(
                                'type'=>'POST',
                                'url'=>CController::createUrl('commands/selectDevice'),
                                'dataType'=>'json', 
                                'success'=>'function(data) {
                                                        $("#Commands_device_id").html(data.dropDownDevice);
                                                        $("#DeviceType_type_en").val(data.device_type);
                                                        $("#Commands_device_commands_id").html(data.dropDownCommand);
                                                        $("#Commands_device_commands_id").removeAttr("disabled");
                                                }',
                        )
                
                
                
                
                )); ?>

	</div>
        
           
            
        
        <div class="row">
		<?php echo $form->labelEx(DeviceType::model(),'type_en'); ?>
                
		<?php echo $form->textField(DeviceType::model(),'type_en',array('readOnly'=>true)) ?>
		<?php echo $form->error(DeviceType::model(),'type_en'); ?>
            
	</div>


        <div class="row">
		<?php echo $form->labelEx($model,'device_commands_id'); ?>
		<?php

                        $records = DeviceCommands::model()->search();
			$list = CHtml::listData($records, 'id', 'name');
                ?>
                <?php echo $form->dropDownList($model,'device_commands_id',$list,array('empty' => '(Select Command)','disabled'=>true)); ?>
                    <?php if (Yii::app()->user->level >=1000) : ;?>
                    <a class="btn btn-mini" href='<?php echo CController::createUrl('deviceCommands/create'); ?>'>Add New Command</a>
                    <?php endif; ?>
		<?php echo $form->error($model,'device_commands_id'); ?>
	</div>
        
       

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Send' : 'Send',array("class"=>"btn btn-primary")); ?>
	</div>

<?php $this->endWidget(); ?>


        
        
        
</div><!-- form -->