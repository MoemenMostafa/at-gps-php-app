<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>

  <div class="row-fluid">
	<div class="span3">
		<div class="sidebar-nav">
	<h2>Admin Menu</h2>
		<?php
		
		
		include("_menu.php"); 
		
                if ($subItemsAdmin){
                    $this->widget('zii.widgets.CMenu', array(
                            //'type'=>'list',
                            'encodeLabel'=>false,
                            'items'=>

                                    $subItemsAdmin,
                    ));
                }
                
                //$this->widget('ext.menu.EMenu', array('items' => $items));

/*
	$this->widget('ext.AjaxMenu',array(
	  'items'=>array( 
		  array('label'=>'Users', 'url'=>array('/user'), 'linkOptions' => array('id' => 'idname'), 'ajax' => false),
		  array('label'=>'Drivers', 'url'=>array('/driver' , 'view'=>'admin'), 'ajax' => array('update' => '#content')),
		  array('label'=>'Routes', 'url'=>array('/trip')),
	  ),
	  'optionalIndex'=>true,
	  'ajax'=>array(
		  'update' => '#page',
	  ),
	  'randomID'=>true,
	));
*/	
		?>
 		</div>
            </div>
    <div id="content" class="span9">
 

    
    <?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
			'homeLink'=>CHtml::link('Dashboard'),
			'htmlOptions'=>array('class'=>'breadcrumb')
        )); ?><!-- breadcrumbs -->
    <?php endif?>
    
    <div class="horizontalBar-nav">
    		  <?php $this->widget('zii.widgets.CMenu', array(
			/*'type'=>'list',*/
			'encodeLabel'=>false,
			'items'=>array(
				// Include the operations menu
				array('label'=>'<i class="icon-white icon-wrench"></i>','items'=>$this->menu),
				#array('label'=>'<i class="icon icon-search"></i> About this theme <span class="label label-important pull-right">HOT</span>', 'url'=>'http://www.webapplicationthemes.com/abound-yii-framework-theme/'),
				#array('label'=>'<i class="icon icon-envelope"></i> Messages <span class="badge badge-success pull-right">12</span>', 'url'=>'#'),
				
			),
			));?>
    </div>
    
    <!-- Include content pages -->
    <?php echo $content; ?>

	</div><!--/span-->
  </div><!--/row-->


<?php $this->endContent(); ?>