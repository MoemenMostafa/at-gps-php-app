<?php
/* @var $this LandmarksController */
/* @var $model Landmarks */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'landmarks-form',
	'enableAjaxValidation'=>false,
	'action'=>Yii::app()->createUrl('/landmarks/create')
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

<!--	<div class="row">-->
<!--		--><?php //echo $form->labelEx($model,'icon'); ?>
<!--		--><?php //echo $form->textField($model,'icon'); ?>
<!--		--><?php //echo $form->error($model,'icon'); ?>
<!--	</div>-->

	<div class="row">
		<?php echo $form->labelEx($model,'icon'); ?>
		<?php
		$list = array();
		$landmarks = array("Bank","Car Wash","Cafe","Mosque","Oil","Parking","Prayer","Service","Restaurant","Supermarket","Phone","Theater","Tires","WC","Tools","Tunnel","Underground","University","Warehouse","Maintenance","Hospital","Gas Station","Factory","Embassy","Court","Airport");
		for ($i=0;$i<=25;$i++){

			array_push($list,$landmarks[$i]);
		}
		?>
		<?php echo $form->dropDownList($model,'icon',$list,array('empty' => '(Select Icon)')); ?>
		<?php echo $form->error($model,'icon'); ?>
		<img id="icon_view" src="" />
	</div>

	<script>
		$("#Landmarks_icon").change(function(event){$("#icon_view").attr('src','images/icons/landmarks/LandMark'+$("#Landmarks_icon").val()+'.png')});
	</script>

	<div class="row">
		<?php echo $form->hiddenField($model,'lat'); ?>
	</div>

	<div class="row">
		<?php echo $form->hiddenField($model,'long'); ?>
	</div>
	<div class="row">
		<?php echo $form->hiddenField($model,'id'); ?>
	</div>

	<div class="row">
		<input type="hidden" name="action" id="landmark-action" />
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Save' : 'Update',array("class"=>"btn btn-primary")); ?>
		<?php echo CHtml::button('Delete',array("class"=>"btn btn-primary","id"=>"landmark-delete")); ?>
	</div>
	<script>
		$('#landmark-delete').click(function(){
			$('#landmark-action').val('delete');
			$('#landmarks-form').submit();
		});

	</script>

<?php $this->endWidget(); ?>

</div><!-- form -->