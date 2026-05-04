<?php
/* @var $this RepairsController */
/* @var $model Repairs */
$user_id = Yii::app()->user->id;
Yii::app()->getClientScript()->registerScriptFile('js/print.js');



Yii::app()->clientScript->registerScript('repairs', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('repairs-grid', {
		data: $(this).serialize()
	});
	return false;
});

$('#repair').click(function() {
          $('#repairsModal').modal('show');
           $('#myModalLabel').html('Add New Repair');
            $('input[type=\'submit\']').val('Create');
            $('#repairs-form')[0].reset();
            $('#Repairs_id').val('');
});

$('#repairs-form').submit(function(){
        if ($('input[type=\'submit\']').val() == 'Create'){
        $.post('".Yii::app()->createUrl('/repairs/ajaxCreate')."', $(this).serialize()).done(
                function(d) {
                      $('#repairsModal').modal('hide');
                      $.fn.yiiGridView.update('repairs-grid');
                  });
        }
        if ($('input[type=\'submit\']').val() == 'Update'){
        $.post('".Yii::app()->createUrl('/repairs/ajaxUpdate')."', $(this).serialize()).done(
                function(d) {
                      $('#repairsModal').modal('hide');
                      $.fn.yiiGridView.update('repairs-grid');
                  });
        }
        return false;
});

");
?>




<div style="overflow:auto">
<h1 style=" float:left">Repairs</h1>
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
            <?php echo $form->dropDownList($model,'vehicle_id',array('0'=>'No','1'=>'Yes'),array('empty' => 'All Installatoin status')); ?>

        </div>
        
    <?php $this->endWidget(); ?>
</div>
--> 

<div id='AjFlash' class="alert alert-success alert-dismissable" style="display:none"></div>
<div id='repair' class="btn">Add New Repair</div>
<?php 	echo "<button class=\"btn btn-primary  ui-button ui-widget ui-state-default ui-corner-all\" onclick=\"javascript:printContent('repairs-grid')\"><i class=\"icon-white icon-print\"></i></button>"; ?>

        <div id="repairsModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
              <h3 id="myModalLabel">Add New Repair</h3>
            </div>
            <div class="modal-body">
                    <?php
                    $this->renderPartial('_form', array('model'=>new Repairs,'action'=>'Ajax'));

                    ?>
            </div>

        </div>



<?php $this->widget('ext.groupgridview.GroupGridView', array(
	'id'=>'repairs-grid',
	'dataProvider'=>$model->search(),
        'mergeColumns' => array('vehicle.serial'), 
	//'filter'=>$model,
	'columns'=>array(
		array('header'=>'SN.',
                      'value'=>'++$row',
                      'headerHtmlOptions'=>array('style'=>'width: 25px;'),
                      'htmlOptions'=>array('style'=>'width: 25px;')
		),
                'vehicle.serial',
		'location',
                'description',
		'start_date',
                'end_date',
                'note',
                 array(
			'header'=>'Edit',
                        'class'=>'CButtonColumn',
                        'template'=>'{edit}',
                        
                        'buttons'=>array
                        (
                            'edit' => array
                            (
                                'label'=>'Update',
                                'imageUrl'=>Yii::app()->theme->baseUrl."/img/edit.png",
                                'click'=>"function(){
                                                        $.fn.yiiGridView.update('repairs-grid', {
                                                            type:'JSON',
                                                            url:$(this).attr('href'),
                                                            success:function(data) {
                                                                var obj = eval ('(' + data + ')');
                                                                
                                                                $('#myModalLabel').html('Edit Repair Record');
                                                                $('input[type=\'submit\']').val('Update');
                                                                $('#Repairs_id').val(obj.id);
                                                                $('#Repairs_vehicle_id').val(obj.vehicleId);
                                                                $('#Repairs_location').val(obj.location);
                                                                $('#Repairs_description').val(obj.description);
                                                                $('#Repairs_start_date').val(obj.startDate);
                                                                $('#Repairs_end_date').val(obj.endDate);
                                                                $('#Repairs_note').val(obj.note);
                                                                $('#repairsModal').modal('show');
                                                                $.fn.yiiGridView.update('repairs-grid');
                                                            }
                                                        })
                                                        return false;
                                                  }
                                         ",
                                'url'=>'Yii::app()->controller->createUrl("AjaxSelect",array("id"=>$data->id,"vehicleId"=>$data->vehicle_id,"location"=>$data->location,"description"=>$data->description,"startDate"=>$data->start_date,"endDate"=>$data->end_date,"note"=>$data->note))',
                                
                            )
                        ),
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
	$.fn.yiiGridView.update('repairs-grid', {
		data: $(this).serialize()
	});
	return false;
});
    $('#export-button').on('click',function() {
            $.fn.yiiGridView.export();
        });
        $.fn.yiiGridView.export = function() {
            $.fn.yiiGridView.update('repairs-grid',{ 
                success: function() {
                    $('#repairs-grid').removeClass('grid-view-loading');
                    window.location = '".$this->createUrl('exportFile')."';
                },
                data: $('.search-form form').serialize() + '&export=true'
            });
        };
");



?>
