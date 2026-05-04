<?php
/* @var $this SiteController */

//echo $this->pageTitle=Yii::app()->name;


//Get users company ID
$userCompanyId = $this->userData->company_id;
$userLevel = $this->userData->userType->level;
$userId = Yii::app()->user->id;
$userData = $this->userData;


	
Controller::renderPartial("_table", array('dataProvider'=>$dataProvider,'userData'=>$userData),false);


?>

</div>
<script>
// Set the update interval of the tabel and markers
setInterval(function(){refreshResults()},10000);
	function refreshResults(){
	$.fn.yiiGridView.update("status-grid");
}



</script>
