

<?php
	  $baseUrl = Yii::app()->theme->baseUrl; 
	  $cs = Yii::app()->getClientScript();
	  $cs->registerScriptFile($baseUrl.'/js/plugins/jquery.layout.js');
	  Yii::app()->clientScript->registerCoreScript('jquery.ui');
          
	  
?>




<!-- Require the header -->
<?php require_once('map_header.php')?>

	<script type="text/javascript">
		$(document).ready(function () {
			$('body').layout({ 
						applyDefaultStyles: true, 
						north__size: 43,
						west__size: 280,
						south__size: 200,
						north__resizable : false,
						west__onresize: function () {
   							 $.fn.yiiGridView.update("status-grid");
							 google.maps.event.trigger(EGMap0, "resize"); },
						west__onopen: function () {
							 google.maps.event.trigger(EGMap0, "resize"); },
						west__onclose: function () {
							 google.maps.event.trigger(EGMap0, "resize"); },
						//south__initClosed: true ,
						fxName:     ""
						});



						
		});
		
		/*function setTableCols() {
			
			// size the header columns to match the body
			var allBodyCols = $('.items').find('tbody tr:first td');
			$('.items').find('thead tr th').each(function(index) {
				var desiredWidth = getWidth($(allBodyCols[index]));
				$(this).css({ width: desiredWidth + 'px' });

			});


			$('.items').find('tbody tr td').each(function(index) {
				var desiredWidth = getWidth($(allBodyCols[index]));
				$(this).css({ width: desiredWidth + 'px' });
			});
		

		}
		
		function getWidth(td) {
			if ($.browser.msie) { return $(td).outerWidth() - 1; }
			if ($.browser.mozilla) { return $(td).width(); }
			if ($.browser.safari) { return $(td).outerWidth(); }
			return $(td).outerWidth();
		};
		
		$('.items').ready(function () {
			setTableCols();
		})*/
	
    </script>

<DIV class="ui-layout-center"><?php echo $content; ?>
</DIV>
<DIV class="ui-layout-north"><?php require_once('tpl_navigation.php')?></DIV>
<!--<DIV class="ui-layout-south"><?php #echo $this->renderPartial('_table', array('userdata'=>$this->userData)); ?><?php #require_once('tpl_footer.php')?></DIV>-->
<DIV class="ui-layout-west">


<?php echo $this->renderPartial('_controller', array('model'=>$model)); ?>

	


</DIV>
<style>
.ui-layout-north{
	overflow: visible !important;	
}
.navbar-fixed-top{
	position: absolute !important;	
	
}
#EGMapContainer1{
	position: absolute !important;
	height:auto !important;	
	top:0;
	bottom:0;
}
.ui-layout-center{
	padding:0 !important;	
	
}
</style>



<!-- Send Command Modal -->

        <div id="SendCommandModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Send Command</h3>
            </div>
            <div class="modal-body">
                    <?php
                    $this->renderPartial('/commands/_form', array('model'=>new Commands,'action'=>'Ajax'));

                    ?>
            </div>

        </div>
        
        
            <div id="StatusCommandModal" style="width:700px;left: 44%;" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Status of Commands</h3>
            </div>
            <div class="modal-body">
                <div id="commandDataLog"> </div>

            </div>

        </div>

<!-- Landmarks Modal Add -->

<div id="LandmarksModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="LandmarksModalLabel" aria-hidden="true">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
		<h3 id="LandmarksModalLabel">Landmark</h3>
	</div>
	<div class="modal-body">
		<?php
		$this->renderPartial('/landmarks/_form', array('model'=>new Landmarks,'action'=>'Ajax'));

		?>
	</div>

</div>