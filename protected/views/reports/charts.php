<?php
Yii::app()->getClientScript()->registerScriptFile('js/print.js');
Yii::app()->getClientScript()->registerScriptFile('js/dygraph-combined.js');
Yii::app()->getClientScript()->registerScriptFile('js/dygraph-extra.js');

/* @var $dataProvider Reports */
/* @var $this Reports */
/* @var $model Reports */
/* @var $results Reports */

$this->formName = "-charts";
$this->form= new Vehicle;

$leftAxis = $_POST['leftAxis'];
$rightAxis = $_POST['rightAxis'];
$date = $_POST['Vehicle']['dateRange'];
$device_id = $_POST['Vehicle']['id'];


//get data array from dataProvider
if ($dataProvider->totalItemCount > 0 && $_POST['Vehicle']['id']){
	
	$data = $dataProvider->getData();
			
        $array = 'X,'.str_replace("_cam","",$leftAxis).','.str_replace("_cam","",$rightAxis).'\n';
	for($i=0;$i<count($data);$i++){
			
                            $array .= reformDate($data[$i]->attributes['gps_datetime'],Yii::app()->user->timezone)." ".reformTime($data[$i]->attributes['gps_datetime'],Yii::app()->user->timezone).',';
                            $array .= $data[$i]->attributes[$leftAxis].',';
                            $array .= $data[$i]->attributes[$rightAxis];
                            $array .= '\n';
                       
		
	}
        //echo $array;
        echo "<button class=\"btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"createImg();printContent('graphImg');\"><i class=\"icon-white icon-print\"></i></button>";
?>	

        <div id="graph" style="width: 100%; height: 500px"></div>
        <div id="graphImg" style="display:none"><img id="printimg"></img></div>
<script>
   g = new Dygraph(document.getElementById("graph"),
                 // For possible data formats, see http://dygraphs.com/data.html
                 // The x-values could also be dates, e.g. "2012/03/15"
                 "<?php echo $array ?>",
                 {
                     // options go here. See http://dygraphs.com/options.html
                     legend: 'always',
                     //animatedZooms: true,
                     title: '<?php echo str_replace("_cam","",$leftAxis)." vs. ".str_replace("_cam","",$rightAxis)." ".$date." (Vehicle ".getVehicle($data[0]->attributes['device_id']).")" ?>',
                     ylabel: '<?php echo getLegend(str_replace("_cam","",$leftAxis)) ?>',
                     y2label: '<?php echo getLegend(str_replace("_cam","",$rightAxis)) ?>',
                     showRangeSelector: true,
                     rangeSelectorHeight: 50,
                     <?php echo str_replace("_cam","",$rightAxis); ?> : {
                       axis : { }
                     }
                 });

    function createImg(){
        //demoimg is a the id of the <img> element where the dygraph will be exported.
        var img = document.getElementById('printimg');

        // Create the image!
        Dygraph.Export.asPNG(g,img);
    }
    createImg()
</script>
        
        
<?php	
goto End;
noData:
?>
<h1>No data available to display. Please Select another vehicle or change time range.</h1>
<?php
End:
}else{
?>
<h1>No data available to display. Please Select another vehicle or change time range.</h1>

    
<?php
}

	
function getVehicle($device_id){
	$vehicle = Yii::app()->db->createCommand()
		->select('serial')
		->from('vehicle')
		->where('device_id=:id', array(':id'=>$device_id))
		->queryRow();
		return $vehicle['serial'];
};
        
function getLegend($unit){
        if ($unit == "engine_temp"){return "Temperature (C)";};
        if ($unit == "rpm"){return "rpm";};
        if ($unit == "speed"){return "Km/h";};
        if ($unit == "oil_press"){return "bar";};
        if ($unit == "acc_pedal"){return "%";};
        
};
	
?>
