<?php
/* @var $this MaintSetupController */
/* @var $model MaintSetup */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'maint-setup-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

        <fieldset>
        <legend>Filter:</legend>
        </fieldset>
        <div class="row">
		<?php echo $form->labelEx(MaintItem::model(),'company_id'); ?>
		<?php
			$userCompanyId = $this->userData->company_id;
			$criteria = new CDbCriteria();
			$criteria->addCondition("`id` = $userCompanyId");
			if ($this->userData->userType->level >= 1000){
				$records = Company::model()->findAll();
			}else{$records =  Company::model()->findAll($criteria);}
			$list = CHtml::listData($records, 'id', 'name');
			if ($this->userData->userType->level >= 1000){
				echo $form->dropDownList(MaintItem::model(),'company_id',$list,
                                        array(
                                            'empty' => '(Select a Company)',
                                            'ajax' => array(
                                                    'type'=>'POST',
                                                    'url'=>CController::createUrl('maintItem/SelectCompany'),
                                                    'dataType'=>'json', 
                                                    'success'=>'function(data) {
                                                                            $("#MaintGroup_id").html(data.dropDownMaintGroup);
                                                                            $("#MaintItemBrand_id").html(data.dropDownpMaintItemBrand);
                                                                    }',
                                            )

                                            ));
			
                                
                                
                                
                        }else{echo $form->dropDownList(MaintItem::model(),'company_id',$list,array('readonly'=>true));}
			
    	?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>
        
        
        
        <div class="row">
		<?php echo $form->labelEx(MaintGroup::model(),'Item Group'); ?>
		<?php        
                        $records = MaintGroup::model()->search("list");   
			$list = CHtml::listData($records, 'id', 'name');
                ?>
                <?php echo $form->dropDownList(MaintGroup::model(),'id',$list,
                            array(
                                'empty' => '(Select Group)',
                                'disabled'=>false,
                                'ajax' => array(
                                        'type'=>'POST',
                                        'url'=>CController::createUrl('maintItem/SelectCompany'),
                                        'dataType'=>'json', 
                                        'success'=>'function(data) {
                                                                $("#MaintItemBrand_id").html(data.dropDownpMaintItemBrand);
                                                        }',
                                )

                                ));?>

		<?php echo $form->error(MaintGroup::model(),'id'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx(MaintItemBrand::model(),'Item Brand'); ?>
		<?php        
                        $records = MaintItemBrand::model()->search("list");   
			$list = CHtml::listData($records, 'id', 'name');
                ?>
                <?php echo $form->dropDownList(MaintItemBrand::model(),'id',$list,
                            array(
                                'empty' => '(Select Brand)',
                                'disabled'=>false,
                                'ajax' => array(
                                        'type'=>'POST',
                                        'url'=>CController::createUrl('maintGroup/SelectBrand'),
                                        'dataType'=>'json', 
                                        'success'=>'function(data) {
                                                                $("#MaintSetup_maint_item_id").html(data.dropDownMaintItem);
                                                        }',)
                                )); ?>
                    <a class="btn btn-mini" href='<?php echo CController::createUrl('maintitembrand/create'); ?>'>Add New Brand</a>

		<?php echo $form->error($model,'maint_item_brand_id'); ?>
	</div>
        <hr>
                
        <div class="row">
		<?php echo $form->labelEx($model,'maint_item_id'); ?>
		<?php        
                        $records = MaintItem::model()->search("list");   
			$list = CHtml::listData($records, 'id', 'name');
                ?>
                <?php echo $form->dropDownList($model,'maint_item_id',$list,array('empty' => '(Select Item)','disabled'=>false)); ?>
                    <a class="btn btn-mini" href='<?php echo CController::createUrl('maintitem/create'); ?>'>Add New Item</a>

		<?php echo $form->error($model,'maint_item_id'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'vehicle_id'); ?>
		<?php        
                        $records = Vehicle::model()->search("list", true);   
			$list = CHtml::listData($records, 'id', 'serial');
                ?>
            
                <?php echo $form->dropDownList($model,'vehicle_id',$list,
                        array(
                            'empty' => '(Select Item)',
                            'disabled'=>false,
                            'ajax' => array(
                                        'type'=>'POST',
                                        'url'=>CController::createUrl('maintSetup/SelectVehicle'),
                                        'dataType'=>'', 
                                        'success'=>'function(data) {
                                                                $("#MaintSetup_odometerKM").val(data);
                                                        }',)
                            )); ?>

		<?php echo $form->error($model,'vehicle_id'); ?>
	</div>



	<div class="row">
		<?php echo $form->labelEx($model,'date'); ?>
		<?php echo $form->dateField($model,'date'); ?>
		<?php echo $form->error($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'odometerKM'); ?>
		<?php echo $form->numberField($model,'odometerKM'); ?>
		<?php echo $form->error($model,'odometerKM'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->