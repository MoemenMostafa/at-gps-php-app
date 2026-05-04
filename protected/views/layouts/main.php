<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en"  />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div><!-- header -->

	<div id="mainmenu">
		<?php $this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				//array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Login', 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest),
				array('label'=>'Map', 'url'=>array('/map'),'active'=>$this->id=='map'?true:false, 'visible'=>!Yii::app()->user->isGuest),
				array('label'=>'About Us', 'url'=>array('/site/page', 'view'=>'about')),
				array('label'=>'Contact', 'url'=>array('/site/contact')),
				array('label'=>'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest)
			),
		)); ?>
	</div><!-- adminmenu -->
    <div id="adminmenu">
		<?php 
		if ($this->userData->userType->level >=1000){
		$this->widget('zii.widgets.CMenu',array(
			'items'=>array(
				//array('label'=>'Home', 'url'=>array('/site/index')),
				array('label'=>'Users', 'url'=>array('/user'),'active'=>$this->id=='user'?true:false),
				array('label'=>'User Types', 'url'=>array('/userType'),'active'=>$this->id=='userType'?true:false),
				array('label'=>'Companies', 'url'=>array('/company'),'active'=>$this->id=='company'?true:false),
				array('label'=>'Vehicles', 'url'=>array('/vehicle'),'active'=>$this->id=='vehicle'?true:false),
				array('label'=>'Vehicle Types', 'url'=>array('/vehicleType'),'active'=>$this->id=='vehicleType'?true:false),
				array('label'=>'Devices', 'url'=>array('/device'),'active'=>$this->id=='device'?true:false),
				array('label'=>'Device Types', 'url'=>array('/deviceType'),'active'=>$this->id=='deviceType'?true:false),
				array('label'=>'Drivers', 'url'=>array('/driver'),'active'=>$this->id=='driver'?true:false),
				array('label'=>'Vehicle Driver', 'url'=>array('/vehicleDrivers'),'active'=>$this->id=='vehicleDrivers'?true:false),
			),
		)); 
		}
		?>
	</div><!-- adminmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by ATgps Egypt.<br/>
		All Rights Reserved.<br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
