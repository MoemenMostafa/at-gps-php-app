<style>
    #reports select{
        width:70% !important; 
    }
    #reports input{
        width:70% !important; 
    }
    
    
</style>

<?php
/* @var $this VehicleDriversController */
/* @var $model Vehicle */
/* @var $form CActiveForm */

global $deviceId;

$speedLimit = $_POST['Vehicle']['speedLimit'];
if(!$speedLimit)$speedLimit=90;

$stopDistance = $_POST['Vehicle']['stopDistance'];
if(!$stopDistance)$stopDistance=500;

$stopTime = $_POST['Vehicle']['stopTime'];
if(!$stopTime)$stopTime=10;

$from = $_POST['Vehicle']['dateFrom'];
if(!$from)$from=date("d/m/Y",strtotime("-1 day"));
$to = $_POST['Vehicle']['dateTo'];
if(!$to)$to=date("d/m/Y");
$Vehicle = $_POST['Vehicle']['serial'];


?>

<div class="form">



<?php 

		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Report Options',
		));


			$form=$this->beginWidget('CActiveForm', array(
				'id'=>'Reports',
				'enableAjaxValidation'=>false,
			)); 

?>



    <div class="">
		<?php echo $form->labelEx(Vehicle::model(),'serial'); ?>
       	<?php
                $records =  Vehicle::model()->search('list', true);
                $list = CHtml::listData($records, 'id', 'serial', 'name');
    	?>
       
    
		<?php echo $form->dropDownList(Vehicle::model(),'id',$list,array('empty' => '(Select Vehicle)',
			'options'=>array($deviceId=>array('selected'=>'selected'))
		)); ?>
		<?php echo $form->error(Vehicle::model(),'serial'); ?>
	</div>
    
        <div class="">
    
    <label>Date Range</label>
		<!-- <?php 
        // $this->widget('ext.EDateRangePicker.EDateRangePicker',array(
        //     'id'=>'dateRange',
        //     'name'=>'Vehicle[dateRange]',
        //     'value'=>$from." - ".$to,
        //     'options'=>array('arrows'=>false,'dateFormat'=>'dd/mm/yy'),
        //     'htmlOptions'=>array('class'=>'inputClass'),
        //     ));
        ?> -->
		<!-- <?php 
		// echo CHtml::textField('Vehicle[dateRange]',$from." - ".$to,
		//  array('id'=>'dateRange')); 
		?> -->
		<input id="dateFrom" type="text" value="<?php echo $from; ?>" name="Vehicle[dateFrom]">
		<input id="dateTo" type="text" value="<?php echo $to; ?>" name="Vehicle[dateTo]">
		<input id="dateRange" type="hidden" value="<?php echo $from." - ".$to ?>" name="Vehicle[dateRange]">
     </div>
    
    <div class="">
		<label>Speed Limit</label>
		<?php echo CHtml::textField('Vehicle[speedLimit]',$speedLimit,
		 array('id'=>'amt')
		); ?>
        Km/h
		<?php
        $this->widget('zii.widgets.jui.CJuiSlider', array(
            'value'=>$speedLimit,
			'options'=>array(
				'min'=>60,
				'max'=>120,
				'step'=>5,
				'slide'=>'js:function(event, ui) { $("#amt").val(ui.value);}',
			),
        ));
        ?>

    </div>
    

     
    <div class="">
		<label>Stop Distance</label>
		<?php echo CHtml::textField('Vehicle[stopDistance]',$stopDistance,
		 array('id'=>'stopDistance')
		); ?>
        meter
		<?php
        $this->widget('zii.widgets.jui.CJuiSlider', array(
            'value'=>$stopDistance,
			'options'=>array(
				'min'=>50,
				'max'=>1000,
				'step'=>50,
				'slide'=>'js:function(event, ui) { $("#stopDistance").val(ui.value);}',
			),
        ));
        ?>

    </div>
    
        <div class="">
		<label>Stop Time</label>
		<?php echo CHtml::textField('Vehicle[stopTime]',$stopTime,
		 array('id'=>'stopTime')
		); ?>
        min.
		<?php
        $this->widget('zii.widgets.jui.CJuiSlider', array(
            'value'=>$stopTime,
			'options'=>array(
				'min'=>5,
				'max'=>60,
				'step'=>5,
				'slide'=>'js:function(event, ui) { $("#stopTime").val(ui.value);}',
			),
        ));
        ?>

    </div>
     
     
	<div class="buttons">
    <label></label>
		<?php echo CHtml::submitButton('View Report',array("data-loading-text"=>"Loading...","class"=>"btn btn-large btn-block btn-primary")); ?>
	</div>
    
    

<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->