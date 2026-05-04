<?php

class MapController extends Controller
{
	
	
	


	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/map';
	
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
	
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','AjaxGetVehicleInfo'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$this->allowUser(1);
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	
	/**
	 * AJAX action to retrive vehicle information in the
         * Main map window in the leftside controler
	 */
	public function actionAjaxGetVehicleInfo()
	{
		$device_id = $_REQUEST['deviceID'];
                $dataProvider = LatestPoints::Model()->search($this->userData, true, $device_id);
                //$model=new LatestPoints;
                //$dataProvider = $model->search($this->userData, true, $device_id);
                $data = $dataProvider->getData();
                //echo $data[0]->gps_datetime."<br>";
                //echo $data[0]->phptimezone."<br>";
                //echo $data[0]->last_connection."<br>";
                if ($data[0]->gps_datetime){
                    $date= reformDateTime($data[0]->gps_datetime,$data[0]->phptimezone);
                    $status = getStatus($data[0]->gps_datetime,$data[0]->last_connection);
                }
                echo "<table  class='table table-striped table-bordered table-hover table-center table-noMargin'>
				<tr><td>Time:</td><td colspan='3'>$date</td></tr>
				<tr class='odd'><td><div title='Speed' class='speed large-icon'></div></td><td><div title='RPM' class='rpm large-icon'></div></td><td><div title='Engine Temprature' class='temp large-icon'></div></td><td><div title='Oil Pressure' class='oil large-icon'></div></td></tr>
                                <tr class='even'><td><Strong>{$data[0]->speed}</strong> Km/h</td><td><Strong>{$data[0]->rpm_cam}</Strong></td><td><Strong>{$data[0]->engine_temp_cam}</Strong> C</td><td><Strong>{$data[0]->oil_press_cam}</Strong> Bar</td></tr>
		</table>
                <table class='table table-striped table-bordered table-hover'>
                                <tr  class='odd'><td>Route:</td><td>{$data[0]->routeName}</td></tr>
				<tr  class='even'><td>Address:</td><td  style='direction:rtl;text-align:right'>{$data[0]->address}</td></tr>
                                <tr  class='odd'><td>Driver:</td><td>{$data[0]->driverName}<br>{$data[0]->driverMobile}</td></tr>
				<tr  class='even'><td>Status:</td><td><div style='{$status['style']};float:left' title='{$status['title']}'></div></td></tr>
                </table>
		"	;
		Yii::app()->end(); 
	}


}