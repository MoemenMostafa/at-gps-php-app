<?php
/* @var $this CommandsController */
/* @var $data Commands */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('device_commands_id')); ?>:</b>
	<?php echo CHtml::encode($data->device_commands_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('device_id')); ?>:</b>
	<?php echo CHtml::encode($data->device_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
	<?php echo CHtml::encode($data->status); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('response')); ?>:</b>
	<?php echo CHtml::encode($data->response); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_recorded')); ?>:</b>
	<?php echo CHtml::encode($data->date_recorded); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_sent')); ?>:</b>
	<?php echo CHtml::encode($data->date_sent); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('date_response')); ?>:</b>
	<?php echo CHtml::encode($data->date_response); ?>
	<br />

	*/ ?>

</div>