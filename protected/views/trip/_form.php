<?php
/* @var $this TripController */
/* @var $model Trip */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'trip-form',
	'enableAjaxValidation'=>false,
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
							'url'=>CController::createUrl('trip/dynamicvehicles'),
							'dataType'=>'json',
							//Style: CController::createUrl('currentController/methodToCall')
							//'data'=>'js:javascript statement' 
							'success'=>'function(data) {
										$("#Trip_vehicle_id").html(data.dropDownVehicle);
										$("#Trip_route_id").html(data.dropDownRoute);
										$("#Trip_driver_id").html(data.dropDownDriver);
									}',
						)
				//leave out the data key to pass all form values through
				)); 
				
		}else{echo $form->dropDownList($model,'company_id',$list,array('readonly'=>true));}		
				
		?>
		
		
		
		<?php echo $form->error($model,'company_id'); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'vehicle_id'); ?>
		<?php
			$records =  Vehicle::model()->search("list");
			$list = CHtml::listData($records, 'id', 'serial', 'name');
    	?>
        <?php echo $form->dropDownList($model,'vehicle_id',$list,array('empty' => '(Select a Vehicle)'));?>
		<?php echo $form->error($model,'vehicle_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'route_id'); ?>
		<?php
			$records =  Route::model()->search("list");
			$list = CHtml::listData($records, 'id', 'name');
    	?>
        <?php echo $form->dropDownList($model,'route_id',$list,array('empty' => '(Select a Route)'));?>
		<?php echo $form->error($model,'route_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'driver_id'); ?>
		<?php
			$records =  Driver::model()->search("list");
			$list = CHtml::listData($records, 'id', 'name');
    	?>
        <?php echo $form->dropDownList($model,'driver_id',$list,array('empty' => '(Select a Driver)'));?>
		<?php echo $form->error($model,'driver_id'); ?>
	</div>


	<div class="row">
		<?php echo $form->labelEx($model,'from'); ?>
		<?php 
			$this->widget('CJuiDateTimePicker',array(
				'model'=>$model, //Model object
				'attribute'=>'from', //attribute name
				'mode'=>'datetime', //use "time","date" or "datetime" (default)
				'language' => '',
				'options'=>array("dateFormat"=>'yy-mm-dd','altTimeFormat'=>'HH:mm') // jquery plugin options
			));
		?>
		<?php echo $form->error($model,'from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'to'); ?>
		<?php 
			$this->widget('CJuiDateTimePicker',array(
				'model'=>$model, //Model object
				'attribute'=>'to', //attribute name
				'mode'=>'datetime', //use "time","date" or "datetime" (default)
				'language' => '',
				'options'=>array("dateFormat"=>'yy-mm-dd','altTimeFormat'=>'HH:mm') // jquery plugin options
			));
		?>
		<?php echo $form->error($model,'to'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->