<?php
/* @var $this VehicleController */
/* @var $model Vehicle */

$this->breadcrumbs=array(
	'Vehicles'=>array('index'),
	'Export',
);


?>

<h1>Export Vehicle Data</h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'vehicle-form',
	'enableAjaxValidation'=>false,
        'action' => "export/export_data.php",
        'method' => "post",
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>
    
	<div class="row">
		<?php echo $form->labelEx($model,'company_id'); ?>
		<?php
			$userCompanyId = $this->userData->company_id;
			$criteria = new CDbCriteria();
			$criteria->addCondition("`id` = $userCompanyId");
			if ($this->userData->userType->level >= 1000){
				$records = Company::model()->findAll();
			}else{$records =  Company::model()->findAll($criteria);}
			$list = CHtml::listData($records, 'id', 'name');
			if ($this->userData->userType->level >= 1000){
			
			
			 echo $form->dropDownList($model,'company_id',$list,
				array(
				'empty' => '(Select a Company)',
				'ajax' => array(
							'type'=>'POST',
							'url'=>CController::createUrl('vehicle/dynamicvehicles'),
							'dataType'=>'json',
							//Style: CController::createUrl('currentController/methodToCall')
							//'data'=>'js:javascript statement' 
							'success'=>'function(data) {
										$("#Vehicle_id").html(data.dropDownVehicle);
									}',
						)
				//leave out the data key to pass all form values through
				)); 
				
		}else{echo $form->dropDownList($model,'company_id',$list,array('readonly'=>true));}		
				
		?>
		
		
		
		<?php echo $form->error($model,'company_id'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->labelEx($model,'id'); ?>
		<?php
			$userCompanyId = $this->userData->company_id;
			$criteria = new CDbCriteria();
			$criteria->addCondition("`company_id` = $userCompanyId");
			if ($this->userData->userType->level >= 1000){
				$records = Vehicle::model()->findAll();
			}else{$records =  Vehicle::model()->findAll($criteria);}
			$list = CHtml::listData($records, 'id', 'serial', 'name');
    	?>
        <?php echo $form->dropDownList($model,'id',$list,array('empty' => '(Select a Vehicle)'));?>
		<?php echo $form->error($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Date From'); ?>
		<input name="Vehicle[from]" id="Vehicle_from" type="date">
		
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'Date To'); ?>
		<input name="Vehicle[to]" id="Vehicle_to" type="date">
		
	</div>




	<div class="row buttons">
		<?php echo CHtml::submitButton('Export'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->