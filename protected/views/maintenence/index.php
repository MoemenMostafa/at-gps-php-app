<?php
/* @var $this MaintenenceController */
/* @var $model Maintenence */
$user_id = Yii::app()->user->id;




Yii::app()->clientScript->registerScript('maint', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('maintenence-grid', {
		data: $(this).serialize()
	});
	return false;
});

$('#setupItem').click(function() {
          $('#setupItemModal').modal('show');
});

$('#maint-setup-form').submit(function(){
        $.post('".Yii::app()->createUrl('/maintsetup/ajaxCreate')."', $(this).serialize()).done(
                function(d) {
                      $('#setupItemModal').modal('hide');
                      $.fn.yiiGridView.update('maintenence-grid');
                  });
        return false;
});

");
?>




<div style="overflow:auto">
<h1 style=" float:left">Maintenence</h1>
<h5 style=" float:left;color:gray"> (Beta) </h5>
</div>

<!--
<div class="search-form">
	<?php $form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
        'id'=>'filter',
    )); ?>
    
        <div class="row">
            <?php echo $form->dropDownList($model,'installed',array('0'=>'No','1'=>'Yes'),array('empty' => 'All Installatoin status')); ?>

        </div>
        
    <?php $this->endWidget(); ?>
</div>
-->

<div id='AjFlash' class="alert alert-success alert-dismissable" style="display:none"></div>
<div id='setupItem' class="btn">Setup New Item</div>

        <div id="setupItemModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Setup new Item</h3>
            </div>
            <div class="modal-body">
                    <?php
                    $this->renderPartial('/maintSetup/_form', array('model'=>new MaintSetup,'action'=>'Ajax'));

                    ?>
            </div>

        </div>


<?php $this->widget('ext.groupgridview.GroupGridView', array(
	'id'=>'maintenence-grid',
	'dataProvider'=>$model->search(),
        'mergeColumns' => array('vehicle.serial'), 
	//'filter'=>$model,
	'columns'=>array(
		//'id',
                'vehicle.serial',
		'maintItem.maintGroup.name',
                'ItemSpan',
		#'maintItem.life',
           #'vehicle.odometer',
            #'odometer',
		'date',
                'KmToMaint',
                //'installed',


            
            array(
			'header'=>'Installed',
                        'class'=>'CButtonColumn',
                        'template'=>'{installed} {uninstalled}',
                        
                        'buttons'=>array
                        (
                            'installed' => array
                            (
                                'visible'=>'$data->installed',
                                'label'=>'Finished',
                                'imageUrl'=>Yii::app()->theme->baseUrl."/img/right.png",
                                'click'=>"function(){
                                                        $.fn.yiiGridView.update('maintenence-grid', {
                                                            type:'JSON',
                                                            url:$(this).attr('href'),
                                                            success:function(data) {
                                                                var obj = eval ('(' + data + ')');
                                                                
                                                                var d = new Date();
                                                                var year = d.getFullYear();
                                                                var month = d.getMonth() +1;
                                                                if(month <= 9)
                                                                    month = '0'+month;

                                                                var day= d.getDate();
                                                                if(day <= 9)
                                                                    day = '0'+day;

                                                                var now = year +'-'+ month  +'-'+ day;
                                                                
                                                                console.log(now);
                                                                $('#MaintSetup_maint_item_id').val(obj.itemId);
                                                                $('#MaintSetup_vehicle_id').val(obj.vehicleId);
                                                                $('#MaintSetup_date').val(now);
                                                                $('#MaintSetup_vehicle_id').trigger('change');
                                                                $('#setupItemModal').modal('show');
                                                                $.fn.yiiGridView.update('maintenence-grid');
                                                            }
                                                        })
                                                        return false;
                                                  }
                                         ",
                                'url'=>'Yii::app()->controller->createUrl("AjaxSelect",array("itemId"=>$data->maint_item_id,"vehicleId"=>$data->vehicle_id,"date"=>$data->date))',
                                
                            ),
                            'uninstalled' => array
                            (
                                'visible'=>'!$data->installed',
                                'label'=>'Finished',
                                'imageUrl'=>Yii::app()->theme->baseUrl."/img/wrong.png",
                                /*'click'=>"function(){
                                                        $.fn.yiiGridView.update('maintenence-grid', {
                                                            type:'POST',
                                                            url:$(this).attr('href'),
                                                            success:function(data) {
                                                                  $('#AjFlash').html(data).fadeIn().animate({opacity: 1.0}, 3000).fadeOut('slow');

                                                                  $.fn.yiiGridView.update('maintenence-grid');
                                                            }
                                                        })
                                                        return false;
                                                  }
                                         ",
                                'url'=>'Yii::app()->controller->createUrl("ajaxUpdate",array("id"=>$data->primarykey,"action"=>1,"vehicle"=>$data->vehicle->serial))',
                                 
                                 */
                                
                            ),
                        )
		),
            		array(
                        'header'=>'Delete',
			'class'=>'CButtonColumn',
                        'template'=>'{delete}',
                        'deleteButtonImageUrl'=> Yii::app()->theme->baseUrl."/img/delete.png",
                        ),
	),
)); 




Yii::app()->clientScript->registerScript('search', "
$('.search-form form').change(function(){
	$.fn.yiiGridView.update('maintenence-grid', {
		data: $(this).serialize()
	});
	return false;
});
");



?>

