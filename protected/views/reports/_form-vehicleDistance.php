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

if ($_POST['Vehicle']){
    $from = $_POST['Vehicle']['from'];
    $to = $_POST['Vehicle']['to'];
}

$vehicleId = $_POST['Vehicle']['id'];

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
       
    
		<?php echo $form->dropDownList(Vehicle::model(),'id',$list,array('',
			'options'=>array($vehicleId=>array('selected'=>'selected'))
		)); ?>
		<?php echo $form->error(Vehicle::model(),'serial'); ?>
	</div>
    
        <div class="">

            <label>From</label>
            <?php 
            if ($from) {
                $value = $from;
            } else {
                $value = date('Y/m/d', strtotime("-1 days")). ' 12:00 am';
            }           
            $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
                'id'=>'from',
                'language'=> 'en',
                'name'=>'Vehicle[from]',
                'value'=>$value,
                'options'   => array(
                                'dateFormat' => 'yy/mm/dd',
                                //'timeFormat' => '',
                            ),
                ));
            ?>
         </div>

    <div class="">

        <label>To</label>
        <?php
        if ($to) {
            $value = $to;
        } else {
            $value = date('Y/m/d', time()). ' 11:59 pm';
        }
        $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
            'id'=>'to',
            'language'=> 'en',
            'name'=>'Vehicle[to]',
            'value'=>$value,
            'options'   => array(
                'dateFormat' => 'yy/mm/dd',
                //'timeFormat' => '',
            ),
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