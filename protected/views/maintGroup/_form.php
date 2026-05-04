<?php
/* @var $this MaintGroupController */
/* @var $model MaintGroup */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'maint-group-form',
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
				echo $form->dropDownList($model,'company_id',$list,array('empty' => '(Select a Company)'));
			}else{echo $form->dropDownList($model,'company_id',$list,array('readonly'=>true));}
			
    	?>
		<?php echo $form->error($model,'company_id'); ?>
	</div>
        
        
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>



	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->