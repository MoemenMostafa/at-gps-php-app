<style>
    #reports select{
        width:70% !important; 
    }
    #reports input{
        width:70% !important; 
    }
    
    
</style>

<?php
$distance = Yii::app()->request->getParam('distance');
$from = Yii::app()->request->getParam('from') ? Yii::app()->request->getParam('from') : getFirstOfDay(time());
$to = Yii::app()->request->getParam('to')? Yii::app()->request->getParam('to') : setTimeZone(time(),Yii::app()->user->timezone);
$filterTrips = Yii::app()->request->getParam('filterTrips');
$filterMaintenance = Yii::app()->request->getParam('filterMaintenance');

?>

<div class="form">



    <?php 

		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>'Report Options',
		));


			$form=$this->beginWidget('CActiveForm', array(
				'id'=>'Reports',
				'enableAjaxValidation'=>false,
                'method' => 'get',
                'action' => $this->createUrl('reports/vehiclesLessThanOdo'),
			));

    ?>


    <div class="">
        <label>Distance</label>
        <?php
        echo CHtml::dropDownList('distance', $distance,
            array(50 => '<50 Km', 100 => '<100 Km'));
        ?>
    </div>

    <div class="">
        <label>Filter Trips</label>
        <?php
        echo CHtml::dropDownList('filterTrips', $filterTrips,
            array(1 => 'Yes', null => 'No'));
        ?>
    </div>

    <div class="">
        <label>Exclude Maintenance</label>
        <?php
        echo CHtml::dropDownList('filterMaintenance', $filterMaintenance,
            array(null => 'Yes'));
        ?>
    </div>

    <div class="">

        <label>From</label>
        <?php
        $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
            'id'=>'from',
            'language'=> 'en',
            'name'=>'from',
            'value'=>$from,
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
        $this->widget('ext.CJuiDateTimePicker.CJuiDateTimePicker',array(
            'id'=>'to',
            'language'=> 'en',
            'name'=>'to',
            'value'=>$to,
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