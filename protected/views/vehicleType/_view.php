<?php
/* @var $this VehicleTypeController */
/* @var $data VehicleType */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_ar')); ?>:</b>
	<?php echo CHtml::encode($data->type_ar); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('type_en')); ?>:</b>
	<?php echo CHtml::encode($data->type_en); ?>
	<br />


</div>