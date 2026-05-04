<?php
/* @var $this DeviceCommandsController */
/* @var $data DeviceCommands */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('deviceType.name')); ?>:</b>
	<?php echo CHtml::encode($data->deviceType->type_en); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('command')); ?>:</b>
	<?php echo CHtml::encode($data->command); ?>
	<br />
        
        <b><?php echo CHtml::encode($data->getAttributeLabel('UserAvailable')); ?>:</b>
	<?php echo CHtml::encode($data->UserAvailable); ?>
	<br />


</div>