<?php
/* @var $this SiteController */

//echo $this->pageTitle=Yii::app()->name;


//Get users company ID
$userCompanyId = $this->userData->company_id;
$userLevel = $this->userData->userType->level;
$userId = Yii::app()->user->id;
$userData = $this->userData;


/****************************************/
/** data provider for the page END HERE**/
/****************************************/

/****************************************/
/** 	 View Display Starts HERE      **/
/****************************************/
?>


<?php
    if ($_GET['twoscreens'] != 1 && $_GET['table'] != 1){
?> 
	

<?php
    if ($userCompanyId == 3 || $userCompanyId == 10){
?>

<!-- <style>
    div#payment-due {
        z-index: 99;
        position: fixed;
        background: red;
        color: white;
        padding: 10px;
        font-size: 1.2em;
        line-height: 1.5em;
        margin: 10px;
        box-shadow: black -10px -10px;
    }
</style>
<div id="payment-due">
        Dear Customer,<br><br>
        Please note that your subscription renewal is due before 31.03.2025.<br> 
        Please contact Advanced Technology to arrange payment to avoid any service disruption.
</div> -->

<?php
    }
?>
    
    
 
<div id="mapContainer" >
    <?php
        /************************************/
        /**     Render _map HERE           **/
        /************************************/
        Controller::renderPartial("_map", array('userCompanyId'=>$userCompanyId),false);
    ?>
</div>

<div class="span13">
    <?php 

        }elseif ($_GET['table'] != 1){

    ?>
        <div id="mapContainer" style="width:100%">
            <?php
                /*********************************/
                /** 	 Render _map HERE	**/
                /*********************************/
                Controller::renderPartial("_map", array('userCompanyId'=>$userCompanyId),false);
            ?>
            <script type="text/javascript">
                document.getElementById("mapContainer").style.height = window.innerHeight-80 + "px";
                document.getElementById("EGMapContainer1").style.height = document.getElementById("mapContainer").style.height;
            </script>
	</div>

    <?php
    }

    function getAlertStyle($status,$id,$userId){

            if($status=="0"){

            return (array(
                    "onClick"=>"toggleAlert($id,1,$userId,\"toggle\")",
                    "class"=>"css3-blink",		
                    "style"=>"background:red;color:white;text-align:center;cursor:pointer"
                    ));}
            if($status=="1"){

            return (array(
                    "onClick"=>"toggleAlert($id,0,$userId,\"toggle\")",
                    "class"=>"",
                    "style"=>"color:blue;text-decoration:underline;text-align:center;cursor:pointer"
                    ));}
    }



    ?>

</div>
<script>
    // Set the update interval of the tabel and markers
    setInterval(function(){refreshResults()},10000);
    function refreshResults(){
        markerManager(<?php echo $userCompanyId; ?>,<?php echo $userId; ?>);
        $.fn.yiiGridView.update("alert-grid");
    }
</script>

<!--
<style>
@-webkit-keyframes blinker {  
  from { opacity: 1.0; }
  to { opacity: 0.0; }
}
.css3-blink {
  -webkit-animation-name: blinker;  
  -webkit-animation-iteration-count: infinite;  
  -webkit-animation-timing-function: cubic-bezier(1.0,0,0,1.0);
  -webkit-animation-duration: 1s; 
}	
</style>
-->

