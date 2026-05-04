<?php
/* @var $this VehicleDriversController */
/* @var $model Vehicle */
/* @var $form CActiveForm */

global $deviceId;

$speedLimit = $_POST['Vehicle']['speedLimit'];
if(!$speedLimit)$speedLimit=80;


/*
$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
$from = trim($dateRange[0]);
if(!$from)$from=date("d/m/Y",strtotime("-1 day"));
$to = trim($dateRange[1]);
if(!$to)$to=date("d/m/Y");
*/

if ($_POST['Vehicle']['date']){
	$date = $_POST['Vehicle']['date'];
	$groupBy = $_POST['Vehicle']['groupBy'];
}else{
	$date = date("Y-m-d");
}
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
    
    <label>Date</label>
			<?php 
			$this->widget('CJuiDateTimePicker',array(
				'name'=>'Vehicle[date]', //attribute name
				'mode'=>'date', //use "time","date" or "datetime" (default)
				'language' => '',
				'options'=>array("dateFormat"=>'yy-mm-dd','altTimeFormat'=>'HH:mm'), // jquery plugin options
				'value'=> $date,
			));
			
		/*	
        $this->widget('ext.EDateRangePicker.EDateRangePicker',array(
            'id'=>'dateRange',
            'name'=>'Vehicle[dateRange]',
            'value'=>$from." - ".$to,
            'options'=>array('arrows'=>false,'dateFormat'=>'dd/mm/yy'),
            'htmlOptions'=>array('class'=>'inputClass'),
            ));*/
        ?>
     </div>
    
    <div class="">
		<label>Speed Limit</label>
        
		<?php
		echo CHtml::dropDownList('Vehicle[speedLimit]',  $speedLimit,array("80"=>"(80:90) (90:100) (>100)","90"=>"(90:100) (100:120) (>120)"));
        ?>
		&nbsp;Km/h
    </div>
    
    <div class="">
		<label>Group By</label>
        
		<?php
		echo CHtml::dropDownList('Vehicle[groupBy]',  $groupBy,array("vehicle"=>"Vehicle","driver"=>"Driver"));
        ?>
    </div>
    

 
     
	<div class="buttons">
    <label></label>
		<?php echo CHtml::submitButton('View Report',array("data-loading-text"=>"Loading...","class"=>"btn btn-large btn-block btn-primary")); ?>
	</div>
    
    

<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->