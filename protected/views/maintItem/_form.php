<?php
/* @var $this MaintItemController */
/* @var $model MaintItem */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'maint-item-form',
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
                                                    'url'=>CController::createUrl('maintItem/SelectCompany'),
                                                    'dataType'=>'json', 
                                                    'success'=>'function(data) {
                                                                            $("#MaintItem_maint_group_id").html(data.dropDownMaintGroup);
                                                                            $("#MaintItem_maint_item_brand_id").html(data.dropDownpMaintItemBrand);
                                                                    }',
                                            )

                                            ));
			
                                
                                
                                
                        }else{echo $form->dropDownList($model,'company_id',$list,array('readonly'=>true));}
			
    	?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'maint_group_id'); ?>
		<?php        
                        $records = MaintGroup::model()->search("list");   
			$list = CHtml::listData($records, 'id', 'name');
                ?>
                <?php echo $form->dropDownList($model,'maint_group_id',$list,array('empty' => '(Select Group)','disabled'=>false)); ?>

                    <a class="btn btn-mini" href='<?php echo CController::createUrl('maintgroup/create'); ?>'>Add New Group</a>

		<?php echo $form->error($model,'maint_group_id'); ?>
	</div>

        
        <div class="row">
		<?php echo $form->labelEx($model,'maint_item_brand_id'); ?>
		<?php        
                        $records = MaintItemBrand::model()->search("list");   
			$list = CHtml::listData($records, 'id', 'name');
                ?>
                <?php echo $form->dropDownList($model,'maint_item_brand_id',$list,array('empty' => '(Select Brand)','disabled'=>false)); ?>
                    <a class="btn btn-mini" href='<?php echo CController::createUrl('maintitembrand/create'); ?>'>Add New Brand</a>

		<?php echo $form->error($model,'maint_item_brand_id'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'life'); ?>
		<?php echo $form->textField($model,'life'); ?>
		<?php echo $form->error($model,'life'); ?>
	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->