<?php
/* @var $this DeviceTypeController */
/* @var $data DeviceType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_en')); ?>:</b>
	<?php echo CHtml::encode($data->type_en); ?>
	<br />

</div>