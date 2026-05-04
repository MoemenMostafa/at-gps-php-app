<?php
/* @var $this CompanyController */
/* @var $data Company */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('address')); ?>:</b>
	<?php echo CHtml::encode($data->address); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('country.name')); ?>:</b>
	<?php echo CHtml::encode($data->country->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('timezone.TimeZone')); ?>:</b>
	<?php echo CHtml::encode($data->timezone->TimeZone); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('overspeed_value')); ?>:</b>
	<?php echo CHtml::encode($data->overspeed_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rpm_value')); ?>:</b>
	<?php echo CHtml::encode($data->rpm_value); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('fueltemp_value')); ?>:</b>
	<?php echo CHtml::encode($data->fueltemp_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oilpres_value')); ?>:</b>
	<?php echo CHtml::encode($data->oilpres_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('engtemp_value')); ?>:</b>
	<?php echo CHtml::encode($data->engtemp_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fuellevel_value')); ?>:</b>
	<?php echo CHtml::encode($data->fuellevel_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fuelrate_value')); ?>:</b>
	<?php echo CHtml::encode($data->fuelrate_value); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accpedal_value')); ?>:</b>
	<?php echo CHtml::encode($data->accpedal_value); ?>
	<br />

	*/ ?>

</div>