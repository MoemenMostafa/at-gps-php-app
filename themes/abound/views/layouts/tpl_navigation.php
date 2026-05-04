<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
    <div class="container">
        <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
     
          <!-- Be sure to leave the brand out there if you want it shown -->
          <!--<a class="brand" href="#">AT-GPS <small>fleet tracking system</small></a>-->
          <a class="brand" href="#" style="padding:0 !important"><img src="themes/abound/img/logo-01-small.png" title="Home" alt="AT-GPS" /></a>
			
		  <?php include("_menu.php"); ?>       
          
          <div class="nav-collapse">
			<?php $this->widget('zii.widgets.CMenu',array(
                    'htmlOptions'=>array('class'=>'pull-right nav'),
                    'submenuHtmlOptions'=>array('class'=>'dropdown-menu'),
					'itemCssClass'=>'item-test',
                    'encodeLabel'=>false,
                    'items'=>array(
						array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
						array('label'=>'Map', 'url'=>array('/map'),'active'=>$this->id=='map'?true:false, 'visible'=>!Yii::app()->user->isGuest),
						array('label'=>'Alerts', 'url'=>array('/alert/admin&ajax=alert-grid&Alert_sort=last_occurrence.desc'),'active'=>$this->id=='alert'?true:false, 'visible'=>!Yii::app()->user->isGuest),
						
 						// array('label'=>'Service <span class="caret white-caret"></span>', 'visible'=>!Yii::app()->user->isGuest,'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 'items'=>$subItemsService ),
                               
						//array('label'=>'About Us', 'url'=>array('/site/page', 'view'=>'about')),
						//array('label'=>'Contact', 'url'=>array('/site/contact')),
						array('label'=>'Reports <span class="caret white-caret"></span>', 'url'=>array('/reports'),'active'=>$this->id=='reports'?true:false,'visible'=>!Yii::app()->user->isGuest,'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 'items'=>$subItemsReports ),
                        /*array('label'=>'Gii generated', 'url'=>array('customer/index')),*/

						//array('label'=>'Settings <span class="caret white-caret"></span>', 'url'=>array('/settings'),'visible'=>!Yii::app()->user->isGuest,'url'=>'#','itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 'items'=>$subItemsSettings ),
                                                array('label'=>'Admin', 'url'=>array('/userAdmin'),'active'=>$this->id=='userAdmin'?true:false, 'visible'=>($this->userData->userType->level >=600)),
							/*array(
                            array('label'=>'My Messages <span class="badge badge-warning pull-right">26</span>', 'url'=>'#'),
							array('label'=>'My Tasks <span class="badge badge-important pull-right">112</span>', 'url'=>'#'),
							array('label'=>'My Invoices <span class="badge badge-info pull-right">12</span>', 'url'=>'#'),
							array('label'=>'Separated link', 'url'=>'#'),
							array('label'=>'One more separated link', 'url'=>'#'),
							
                        )*/
						array('label'=>'('.Yii::app()->user->name.') <img src="themes/abound/img/avatar.gif" width="40px" style="margin: -10px 0;" /> <span class="caret white-caret"></span>', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest  ,'itemOptions'=>array('class'=>'dropdown','tabindex'=>"-1"),'linkOptions'=>array('class'=>'dropdown-toggle','data-toggle'=>"dropdown"), 'items'=>$subItemsSettings ),
                    ),
                )); ?>
    	</div>
    </div>
	</div>
</div>
<!--
<div class="subnav navbar navbar-fixed-top">
    <div class="navbar-inner">
    	<div class="container">
            <form class="navbar-search pull-right" action=""><input type="text" class="search-query span2" placeholder="Search"></form>
    	</div><!-- container -->
    <!--</div><!-- navbar-inner -->
<!--</div><!-- subnav -->