<?php
/* @var $this DeviceController */
/* @var $data Device */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('server_ip')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->server_ip), array('view', 'server_ip'=>$data->server_ip)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('server_port')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->server_port), array('view', 'server_port'=>$data->server_port)); ?>
	<br />


	<b><?php echo CHtml::encode($data->getAttributeLabel('device_type_id')); ?>:</b>
	<?php echo CHtml::encode($data->deviceType->type_en); ?>
	<br />
    
    <b><?php echo CHtml::encode($data->getAttributeLabel('Company')); ?>:</b>
	<?php echo CHtml::encode($data->company->name); ?>
	<br />
    



</div>