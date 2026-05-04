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

$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
$from = trim($dateRange[0]);
if(!$from)$from=date("d/m/Y",strtotime("-1 day"));
$to = trim($dateRange[1]);
if(!$to)$to=date("d/m/Y");
$driverId = $_POST['Driver']['id'];
$leftAxis = $_POST['leftAxis'];
$rightAxis = $_POST['rightAxis'];

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
		<?php echo $form->labelEx(Driver::model(),'Driver Name'); ?>
                <?php
                    $records =  Driver::model()->search('list', true);
                    $list = CHtml::listData($records, 'id', 'name');
                ?>
       
    
		<?php echo $form->dropDownList(Driver::model(),'id',$list,array('empty' => 'All',
			'options'=>array($driverId=>array('selected'=>'selected'))
		)); ?>
		<?php echo $form->error(Driver::model(),'name'); ?>
	</div>
    
        <div class="">

            <label>Date Range</label>
                            <?php 
            $this->widget('ext.EDateRangePicker.EDateRangePicker',array(
                'id'=>'dateRange',
                'name'=>'Vehicle[dateRange]',
                'value'=>$from." - ".$to,
                'options'=>array('arrows'=>false,'dateFormat'=>'dd/mm/yy'),
                'htmlOptions'=>array('class'=>'inputClass'),
                ));
            ?>
         </div>
         
         
    <br>
     
	<div class="buttons">
    <label></label>
		<?php echo CHtml::submitButton('View Report',array("data-loading-text"=>"Loading...","class"=>"btn btn-large btn-block btn-primary")); ?>
	</div>
    
    

<?php $this->endWidget(); ?>

<?php $this->endWidget(); ?>

</div><!-- form -->