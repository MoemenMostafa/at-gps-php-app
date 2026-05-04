<div>
    <div id="mapControl">
	<?php //echo  Yii::app()->user->timezone; ?>
	<?php //echo  date("Y/m/d H:i:s",time()) 
        
             $user_id = Yii::app()->user->id;
            // Include the client scripts
            $baseUrl = Yii::app()->baseUrl; 
            Yii::app()->clientScript->registerScriptFile($baseUrl.'/js/ajaxAlertStatus.js');
        
        ?>
	</div>
    <div>
    <div style="min-height: 30px;margin:5px;">
		<?php
			$form=$this->beginWidget('CActiveForm', array(
				'id'=>'Vehicles',
				'enableAjaxValidation'=>false,
				'htmlOptions'=>array('style'=>'float:left;margin:0')
			)); 

		?>
		<?php echo $form->labelEx(Vehicle::model(),'Vehicle ', array('style'=>'display:inline'))?>
       	<?php
                        $records =  Vehicle::model()->search("list",true);
			$list = CHtml::listData($records, 'device_id', 'serial', 'name');
    	?>
       
    
		<?php echo $form->dropDownList(Vehicle::model(),'device_id',$list,
			array(
			'id' => 'vehicleSelector',
			'empty' => 'All',
			'style'=>'width:100px',
			'onchange' => 'if(this.value){setMarkerFocus(this.value,13);}else{showAllMarkers();}',
			//'onclick' => 'if(this.value){setMarkerFocus(this.value,13);}else{showAllMarkers();}',
			//'options' =>array('1010000001'=>array("style"=>"color:red"))
		)); ?>
        
        <?php $this->endWidget(); ?>
        
      
            <div class="btn-group" id="controlButtons" style="display:none;">
                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                  Action
                  <span class="caret"></span>
                </a>
                <ul class="dropdown-menu pull-right">    
                    <li  id="lock" style="display:none"><a role="menuitem" tabindex="-1" href="#">Lock</a></li>
                    <li id="unlock" style="display:none"><a role="menuitem" tabindex="-1" href="#">Unlock</a></li>
                    <li  id="trace" style="display:none"><a role="menuitem" tabindex="-1" href="#">Trace</a></li>
                    <li  id="stopTracing" style="display:none"><a role="menuitem" tabindex="-1" href="#">Stop Tracing</a></li>
                    <li role="presentation" class="divider"></li>
                    <li id='sendCommand' ><a role="menuitem" tabindex="-1" href="#">Send Command</a></li>
                    <li id='commandStatus'><a role="menuitem" tabindex="-1" href="#">Commands Status</a></li>
                </ul>
             </div>

        </div>
        <div id="vehicleInfo" style="width:100%"></div>
       
        
  
        <div id="alerts" style="width:100%">
            
        <?php
                
                $data = Alert::model()->search(15)->getData();
                
                for($i=0;$i<count($data);$i++){
			
                            //print_r($data[$i]->attributes['value']);
  
                       
		
                }
                
                $this->beginWidget('zii.widgets.CPortlet', array(
				'title'=>'Last 15 min. Sound Alerts:',
                                'contentCssClass'=>'portlet-content-nopadding',
			)); 
                    $this->widget('zii.widgets.grid.CGridView', array(
                    'id'=>'alert-grid',
                    'dataProvider'=>Alert::model()->search(15),
                    'summaryText'=>'{count} Alerts',
                    //'filter'=>$model,
                    'columns'=>array(
                            array(
					"name" => 'vehicle.serial',
					"type" => "raw",
					'value' => 'CHtml::tag("a",array("onclick"=>"javascript:changeSelector(".$data->vehicle->device_id.")","id"=>"focus".$data->vehicle->device_id,"style"=>"cursor:pointer"),$data->vehicle->serial)',

				),
                            'AlertType',
                            'value',
                            'max_value',
                            array(
                                    "header" => "Silent",
                                    "type" => "raw",
                                    'value' => 'CHtml::checkBox("status",$data->Status,array("value"=>"$data->id","onclick"=>"javascript:toggleStatus($data->id,$data->status,'.$user_id.')"));',
                            ),
                    ),
            )); 
                    
                    $this->endWidget();
                    
                    ?>
		
        </div>
	</div>
    
    </div>
<script>


$(document).ready(function() {
	$('#trace').click(function() {
	  deviceId = $('#vehicleSelector').val()
	  if  (deviceId > 0 ){
		  setMarkerTrace(deviceId);
		  //alert(deviceId);
		  $('#trace').attr('style','display:none');
		  $('#stopTracing').attr('style','display:block');
	  }
	});
	$('#stopTracing').click(function() {
		  stopTracing();
		  $('#stopTracing').attr('style','display:none');
		  $('#trace').attr('style','display:block');
	});
	$('#lock').click(function() {
	  deviceId = $('#vehicleSelector').val()
	  if  (deviceId > 0 ){
		  setMarkerFocus(deviceId,13);
		  //alert(deviceId);
		  $('#lock').attr('style','display:none');
		  $('#unlock').attr('style','display:block');
	  }
	});
	$('#unlock').click(function() {
		  loseMarkerFocus();
		  $('#unlock').attr('style','display:none');
		  $('#lock').attr('style','display:block');
	}); 
        

    $( "#commands-form" ).on( "submit", function( event ) {
      event.preventDefault();
      $.post('<?php echo Yii::app()->createUrl('/commands/createAjax') ?>', $(this).serialize()).done(
              function(d) {
                    $('#SendCommandModal').modal('hide');
                    $("#commandStatus").trigger('click');
                });

    });

    $( "#landmarks-form" ).on( "submit", function( event ) {
        event.preventDefault();

        $.post('<?php echo Yii::app()->createUrl('/landmarks/createAjax') ?>', $(this).serialize()).done(
            function(d) {
                $('#LandmarksModal').modal('hide');
                getLandmarks();
            });

    });



    $('#sendCommand').click(function() {
                  $('#SendCommandModal').modal('show');
                  $('#Commands_device_id').val($('#vehicleSelector').val());
                  $('#Commands_device_id').trigger('change');
        });
    $('#commandStatus').click(function() {
              getCommandDataLog();
              $('#StatusCommandModal').modal('show');
              commandInterval = setInterval(function(){getCommandDataLog();},5000);

    });

    $("#StatusCommandModal").on("hide", function () {
      clearInterval(commandInterval);
    });

    $('<audio id="alertAudio" controls loop><source src="../sound/alarm_1.ogg" type="audio/ogg"><source src="../sound/alarm_1.mp3" type="audio/mpeg"></audio>').appendTo('body');
    playAlarm = false;
    setInterval(checkAlarm,10000);
    function checkAlarm(){

        $.post('<?php echo Yii::app()->createUrl('/alert/ajaxCheckAlarm'); ?>').done(

                    function(d) {
                        //console.log("Alert: "+d);
                        if (d === "true" & playAlarm === false){
                           playAlarm = true;
                           $('#alertAudio')[0].play();
                           $('#alert-grid').yiiGridView.update('alert-grid');
                        };
                        if (d === "" & playAlarm === true){
                           playAlarm = false;
                           $('#alertAudio')[0].pause();
                        }
                    });

    }


    function getCommandDataLog(){
        var vehicleId = $('#vehicleSelector').val();
        $.post('<?php echo Yii::app()->createUrl('/commands/dataLogAjax') ?>', { vehicleID: vehicleId}).done(
               function(d) {
                    console.log(d);
                    $('#commandDataLog').html(d);
                });
    }
        
        


        
});

</script>