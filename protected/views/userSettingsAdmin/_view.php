<?php
/* @var $this UserSettingsAdminController */
/* @var $data UserSettingsAdmin */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id0.name')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id0->fullname), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('geofence')); ?>:</b>
	<?php echo CHtml::encode($data->geofence=1? "On" : "Off"); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('overspeed')); ?>:</b>
	<?php echo CHtml::encode($data->overspeed=1? "On" : "Off"); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rpm')); ?>:</b>
	<?php echo CHtml::encode($data->rpm=1? "On" : "Off"); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fueltemp')); ?>:</b>
	<?php echo CHtml::encode($data->fueltemp=1? "On" : "Off"); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('oilpres')); ?>:</b>
	<?php echo CHtml::encode($data->oilpres=1? "On" : "Off"); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('engtemp')); ?>:</b>
	<?php echo CHtml::encode($data->engtemp=1? "On" : "Off"); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fuellevel')); ?>:</b>
	<?php echo CHtml::encode($data->fuellevel=1? "On" : "Off"); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fuelrate')); ?>:</b>
	<?php echo CHtml::encode($data->fuelrate=1? "On" : "Off"); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('accpedal')); ?>:</b>
	<?php echo CHtml::encode($data->accpedal=1? "On" : "Off"); ?>
	<br />


</div>