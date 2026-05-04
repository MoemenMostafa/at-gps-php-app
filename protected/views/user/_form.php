<?php
/* @var $this UserController */
/* @var $model User */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->emailField($model,'email',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'newpassword'); ?>
		<?php echo $form->passwordField($model,'password',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>
        
        
	<div class="row">
		<?php echo $form->labelEx($model,'repeatpassword'); ?>
		<?php echo $form->passwordField($model,'repeatpassword',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'repeatpassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fullname'); ?>
		<?php echo $form->textField($model,'fullname',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'fullname'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<!--<div class="row">
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
		<?php echo $form->labelEx($model,'user_type_id'); ?>
		<?php
			$userLevel = $this->userData->userType->level;
			$criteria = new CDbCriteria();
			$criteria->addCondition("`level` <= $userLevel");
			$records = UserType::model()->findAll($criteria);
			$list = CHtml::listData($records, 'id', 'name');
    	?>
        <?php echo $form->dropDownList($model,'user_type_id',$list,array('empty' => '(Select a user type)')); ?>
		<?php echo $form->error($model,'user_type_id'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->