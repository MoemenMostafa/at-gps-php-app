<?php

	/*$baseURL=Yii::app()->getBaseUrl();
    if (Yii::app()->components['user']->loginRequiredAjaxResponse){
        Yii::app()->clientScript->registerScript('ajaxLoginRequired', '
            $(document).ready(
				function() {
					$("body").ajaxError(
						function(e,request) {
							console.log(request.status);
							if (request.status == 500) {
								console.log("done");
					    		//window.location.href = options.url;
								//window.location.reload();
								window.location.href = "'.$baseURL.'";
								// handle it as you wish
							}
						}
					);
				}
			);
        ');
    }*/
?>

<!-- Require the header -->
<?php require_once('tpl_header.php')?>

<!-- Require the navigation -->
<?php require_once('tpl_navigation.php')?>

<div class="container-fluid">				
	
    <!-- Include content pages -->
	<?php echo $content; ?>

</div><!--/.fluid-container-->

<!-- Require the footer -->
<?php require_once('tpl_footer.php')?>
