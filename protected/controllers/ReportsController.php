<?php

class ReportsController extends Controller
{
	
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $form;
	public $formName;
	
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
	
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('Abbreviated','abbreviatedNew','overSpeeding','OverSpeedingNew', 'overSpeedingAll',
					'disconnected', 'vehiclesAndDrivers', 'charts','inputStatus', 'vehiclesDistance', 'vehiclesDistanceDetails',
					'vehiclesDistanceAccumulative', 'vehicleSpeedZone', 'vehicleDistance', 'vehiclesMoreThanOdo', 'vehiclesLessThanOdo'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}
	public function actionAbbreviated()
	{
		//$model=new Reports;
		
		if($_POST['Vehicle']['id'])
		{
			global $deviceId;
			$deviceId = $_POST['Vehicle']['id'];
			$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
			$from = explode("/",$dateRange[0]);
			$from = trim($from[2]).trim($from[1]).trim($from[0])."000000";
			$to = explode("/",$dateRange[1]);
			$to = trim($to[2]).trim($to[1]).(trim($to[0]))."235959";

			$condition = "t.gps_datetime BETWEEN '$from' AND '$to'";
			
			$table = 'vehicle_points_'.$_POST['Vehicle']['id'];
		
		}else{

			$condition = "t.device_id = 'imposible'";
			$table = 'device_details';
		}
		
		
		$dataProvider=new CActiveDataProvider(Reports::model($table), array(
			'criteria'=>array(
				'with'=>array('device'=>array('joinType'=>'LEFT JOIN')),
				'condition'=> $condition,
				"order" => "t.gps_datetime ASC",
			),
			'pagination'=>false,
		));
		

		

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		$this->render('abbreviated',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
		
	}
        
        public function actionAbbreviatedNew()
	{
		//$model=new Reports;
		
		if($_POST['Vehicle']['id'])
		{
			global $deviceId;
			$deviceId = $_POST['Vehicle']['id'];
			$dateFromStr = trim($_POST['Vehicle']['dateFrom']);
			if (strpos($dateFromStr, '/') !== false) {
				$fromParts = explode("/", $dateFromStr);
				$from = trim($fromParts[2]).str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT).str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT)."000000";
			} else {
				$from = str_replace("-", "", $dateFromStr)."000000";
			}
			$dateFrom = new DateTime($from, new DateTimeZone('Africa/Cairo'));
			$dateFrom->setTimezone(new DateTimeZone('UTC'));
			$from =  $dateFrom->format('YmdHis');

			$dateToStr = trim($_POST['Vehicle']['dateTo']);
			if (strpos($dateToStr, '/') !== false) {
				$toParts = explode("/", $dateToStr);
				$to = trim($toParts[2]).str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT).str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT)."235959";
			} else {
				$to = str_replace("-", "", $dateToStr)."235959";
			}
			$dateTo = new DateTime($to, new DateTimeZone('Africa/Cairo'));
			$dateTo->setTimezone(new DateTimeZone('UTC'));
			$to =  $dateTo->format('YmdHis');

			$condition = "t.gps_datetime BETWEEN '$from' AND '$to' AND gps_datetime NOT LIKE '20______000000'";
			
			$table = 'vehicle_points_'.$_POST['Vehicle']['id'];
		
		}else{

			$condition = "t.device_id = 'imposible'";
			$table = 'device_details';
		}
		
		
		$dataProvider=new CActiveDataProvider(Reports::model($table), array(
			'criteria'=>array(
				'with'=>array('device'=>array('joinType'=>'LEFT JOIN')),
				'condition'=> $condition,
				"order" => "t.gps_datetime ASC",
			),
			'pagination'=>false,
		));
		

		

		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		$this->render('abbreviatedNew',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
		
	}



	public function actionOverSpeeding()
	{
		//$model=new Reports;
		
		if($_POST['Vehicle']['id'])
		{
			global $deviceId;
			$deviceId = $_POST['Vehicle']['id'];
			$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
			$dateFromStr = trim($dateRange[0]);
			if (strpos($dateFromStr, '/') !== false) {
				$fromParts = explode("/", $dateFromStr);
				$from = trim($fromParts[2]).str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT).str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT)."000000";
			} else {
				$from = str_replace("-", "", $dateFromStr)."000000";
			}
			
			$dateToStr = trim($dateRange[1]);
			if (strpos($dateToStr, '/') !== false) {
				$toParts = explode("/", $dateToStr);
				$toRaw = trim($toParts[2]).'-'.str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT).'-'.str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT);
			} else {
				$toRaw = $dateToStr;
			}
			$toDate = new DateTime($toRaw);
			$toDate->modify('+1 day');
			$to = $toDate->format('Ymd')."235959";

			$condition = "t.gps_datetime BETWEEN '$from' AND '$to'";
			$table = 'vehicle_points_'.$_POST['Vehicle']['id'];
		
		}else{

			$condition = "t.device_id = 'imposible'";
			$table = 'device_details';
		}

		
		
		$dataProvider=new CActiveDataProvider(Reports::model($table), array(
			'criteria'=>array(
				'with'=>array('device'=>array('joinType'=>'LEFT JOIN')),
				'condition'=> $condition,
				"order" => "t.gps_datetime ASC",
			),
			'pagination'=>false,
		));
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		$this->render('overSpeeding',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
		
	}
	
        public function actionOverSpeedingNew()
	{
		//$model=new Reports;
		
		if($_POST['Vehicle']['id'])
		{
			global $deviceId;
			$deviceId = $_POST['Vehicle']['id'];
			$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
			$dateFromStr = trim($dateRange[0]);
			if (strpos($dateFromStr, '/') !== false) {
				$fromParts = explode("/", $dateFromStr);
				$from = trim($fromParts[2]).str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT).str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT)."000000";
			} else {
				$from = str_replace("-", "", $dateFromStr)."000000";
			}
			
			$dateToStr = trim($dateRange[1]);
			if (strpos($dateToStr, '/') !== false) {
				$toParts = explode("/", $dateToStr);
				$toRaw = trim($toParts[2]).'-'.str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT).'-'.str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT);
			} else {
				$toRaw = $dateToStr;
			}
			$toDate = new DateTime($toRaw);
			$toDate->modify('+1 day');
			$to = $toDate->format('Ymd')."235959";

			$condition = "t.gps_datetime BETWEEN '$from' AND '$to'";
			$table = 'vehicle_points_'.$_POST['Vehicle']['id'];
		
		}else{

			$condition = "t.device_id = 'imposible'";
			$table = 'device_details';
		}

		
		
		$dataProvider=new CActiveDataProvider(Reports::model($table), array(
			'criteria'=>array(
				'with'=>array('device'=>array('joinType'=>'LEFT JOIN')),
				'condition'=> $condition,
				"order" => "t.gps_datetime ASC",
			),
			'pagination'=>false,
		));
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		$this->render('overSpeedingNew',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
		
	}


	public function actionInputStatus()
	{
		$model = new Vehicle();

		if (isset($_POST['Vehicle'])) {
			$vehicleId = $_POST['Vehicle']['id'];
			$dateRange = explode("-", $_POST['Vehicle']['dateRange']);
			$from = explode("/",$dateRange[0]);
			$from = trim($from[2]).trim($from[1]).trim($from[0])."000000";
			$to = explode("/",$dateRange[1]);
			$to = trim($to[2]).trim($to[1]).(strlen($to[0]+1) == 1 ? '0' : '').trim($to[0]+1)."235959";

			$table = 'vehicle_points_' . $vehicleId;

			// Check if the table exists
			$tableExists = Yii::app()->db->schema->getTable($table) !== null;

			echo "<script>";
			echo "console.log('vehicleId: " . $vehicleId . "');";
			echo "console.log('from: " . $from . "');";
			echo "console.log('to: " . $to . "');";
			echo "console.log('table: " . $table . "');";
			echo "console.log('tableExists: " . ($tableExists ? 'true' : 'false') . "');";
			echo "</script>";

			if ($tableExists) {
				// Get device type
				$deviceType = $this->getDeviceType($vehicleId);


				// 0 = input close & ignition off
				// 12 = input open & ignition off
				// 2 = input close & ignition on
				// 14 = input open & ignition on
				$criteria = new CDbCriteria();
				$criteria->condition = "EXISTS (
					SELECT 1 FROM {$table} prev
					WHERE prev.id = t.id - 1
					AND ((prev.input_status = 0 AND t.input_status = 12)
						OR (prev.input_status = 2 AND t.input_status = 14))
				)";
				$criteria->addCondition("t.gps_datetime BETWEEN $from AND $to");
				$criteria->order = 't.gps_datetime ASC';
				$dataProvider = new CActiveDataProvider(Reports::model($table), array(
					'criteria' => $criteria,
					'pagination' => false,
				));

				$this->render('inputStatus', array(
					'dataProvider' => $dataProvider,
					'model' => $model,
					'deviceType' => $deviceType,
				));
			} else {
				Yii::app()->user->setFlash('error', "No data found for the selected vehicle.");
				$this->render('inputStatus', array(
					'model' => $model,
				));
			}
		} else {
			$this->render('inputStatus', array(
				'model' => $model,
			));
		}
	}

	private function getDeviceType($vehicleId)
	{
		$vehicle = Vehicle::model()->findByPk($vehicleId);
		if ($vehicle && $vehicle->device) {
			return $vehicle->device->deviceType->type_en;
		}
		return null;
	}
        
	public function actionOverSpeedingAll()
	{
                $model = new AlertOverspeed('search');
                
		if($_POST['Vehicle']['date'])
		{
			global $deviceId;
			/*
			$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
			$from = explode("/",$dateRange[0]);
			$from = trim($from[2]).trim($from[1]).trim($from[0])."000000";
			$to = explode("/",$dateRange[1]);
			$to = trim($to[2]).trim($to[1]).trim($to[0]+1)."235959";
			*/
			
			$date = trim($_POST['Vehicle']['date']);
			if (strpos($date, '/') !== false) {
				$dateParts = explode("/", $date);
				$date = trim($dateParts[2])."-".str_pad(trim($dateParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($dateParts[0]), 2, '0', STR_PAD_LEFT);
			}
			
			$speedLimit = $_POST['Vehicle']['speedLimit'];
			if ($speedLimit == 80){$layer = "one";}
			if ($speedLimit == 90){$layer = "two";}

			//$condition = "t.`date` BETWEEN '$from' AND '$to'";
			$join = "LEFT JOIN vehicle AS v ON t.vehicle_id = v.id";
			$condition = "t.`date` = '$date' AND t.`time_$layer` > 0";
			if (Yii::app()->user->level < 1000) {
				$company_id = Yii::app()->user->company_id;
				$condition .= " AND v.company_id = $company_id";
			}
		
		if ($_POST['Vehicle']['groupBy'] == "driver"){
			$select = "group_concat(vehicle_id separator ',') as vehicle_id, driver_id, max(max_speed) as max_speed, sum(distance_one) as distance_one, sum(time_one) as time_one, sum(distance_two) as distance_two, sum(time_two) as time_two, sum(distance_three) as distance_three, sum(time_three) as time_three";
			$group = "driver_id";
			$condition .= " AND t.`driver_id` is not NULL";
		}else{
			$select="*";
			$group=NULL;	
		}
		
		
		}else{

		$condition = "t.vehicle_id = 'imposible'";
		}

		
		
		$dataProvider=new CActiveDataProvider($model, array(
			'criteria'=>array(
				'condition'=> $condition,
				'select'=> $select,
				'group'=> $group,
                                'join'=> $join,
			),
			'pagination'=>false,
		));
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		$this->render('overSpeedingAll',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
		
	}
        
        public function actionDisconnected()
	{
                $model = new LatestPoints;
                $today = date("d-m-Y");
                
                $sort = new CSort();
                $sort->attributes = array(

                            'vehicle.serial'=> array(
                                
                                'desc' => 'serial desc',
                                'asc' => 'serial',
                                'default'=>'asc',
                            ),
                            'date'=> array(
                                
                                'desc' => 'last_connection desc',
                                'asc' => 'last_connection',
                                'default'=>'asc',
                            ),
                            '*',
                      );
                
                

			global $deviceId;
			/*
			$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
			$from = explode("/",$dateRange[0]);
			$from = trim($from[2]).trim($from[1]).trim($from[0])."000000";
			$to = explode("/",$dateRange[1]);
			$to = trim($to[2]).trim($to[1]).trim($to[0]+1)."235959";
			*/
			if ($_POST['LastConnection']['date']){
			$_SESSION['disconnect_date'] = $_POST['LastConnection']['date'];
                        }
			//$condition = "t.`date` BETWEEN '$from' AND '$to'";
                        $company_id=Yii::app()->user->company_id;
                        
                        $join = "LEFT JOIN vehicle AS v ON t.device_id = v.device_id
                                 LEFT JOIN repairs AS r ON r.vehicle_id = v.id";
                        $condition = "t.`last_connection` <= '{$_SESSION['disconnect_date']}' AND v.company_id = $company_id AND (r.end_date not between '01-01-2000' and '$today' OR  r.end_date is Null)";
		
		if ($_POST['Vehicle']['groupBy'] == "driver"){
			$select = "group_concat(vehicle_id separator ',') as vehicle_id, driver_id, max(max_speed) as max_speed, sum(distance_one) as distance_one, sum(time_one) as time_one, sum(distance_two) as distance_two, sum(time_two) as time_two, sum(distance_three) as distance_three, sum(time_three) as time_three";
			$group = "driver_id";
			$condition .= " AND t.`driver_id` is not NULL";
		}else{
			$select="*";
			$group=NULL;	
		}
		
		

		
		
		$dataProvider=new CActiveDataProvider($model, array(
			'criteria'=>array(
				'condition'=> $condition,
				'select'=> $select,
				'group'=> $group,
                                'join'=> $join,
			),
			'pagination'=>false,
                        'sort' => $sort
		));
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		$this->render('disconnected',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
		
	}
        
        public function actionVehiclesAndDrivers()
	{
                $model = new Vehicle('search');
                $today = date("d-m-Y");
                
                $sort = new CSort();
                
                

			global $deviceId;
                        
                        $select = "t.*, d.name as driverName, d.mobile as driverMobile";
                        $join = "LEFT JOIN trip AS tr ON t.id = tr.vehicle_id
                                 LEFT JOIN driver AS d ON tr.driver_id = d.id";
		
		if ($_POST['Vehicle']['groupBy'] == "driver"){
                        $order = "d.name ASC";
			$group=NULL;
		}else{
                        $order ="t.serial+0, t.serial+0 <>0 DESC, t.serial";
			$group=NULL;	
		}
		
		

		
		
		$dataProvider=new CActiveDataProvider($model, array(
			'criteria'=>array(
				'select'=> $select,
				'group'=> $group,
                                'join'=> $join,
                                'order' => $order,
			),
			'pagination'=>false,
                        'sort' => $sort
		));
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		$this->render('vehiclesAndDrivers',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
		
	}
        public function actionCharts()
	{
		//$model=new Reports;
		
		if($_POST['Vehicle']['id'])
		{
			global $deviceId;
			$deviceId = $_POST['Vehicle']['id'];
			$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
			$from = explode("/",$dateRange[0]);
			$from = trim($from[2]).trim($from[1]).trim($from[0])."000000";
			$to = explode("/",$dateRange[1]);
			$to = trim($to[2]).trim($to[1]).trim($to[0]+1)."235959";

			$condition = "t.gps_datetime BETWEEN '$from' AND '$to'";
			$table = 'vehicle_points_'.$_POST['Vehicle']['id'];
		
		}else{

			$condition = "t.device_id = 'imposible'";
			$table = 'device_details';
		}

		
		
		$dataProvider=new CActiveDataProvider(Reports::model($table), array(
			'criteria'=>array(
				'with'=>array('device'=>array('joinType'=>'LEFT JOIN')),
				'condition'=> $condition,
				"order" => "t.gps_datetime ASC",
			),
			'pagination'=>false,
		));
		
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		
		$this->render('charts',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
		
	}
        public function actionVehiclesDistance()
	{
		$model=new VehicleOdometerSnaps;
		

		global $deviceId;
		$vehicleId = $_POST['Vehicle']['id'];
		$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
		$fromParts = explode("/",trim($dateRange[0]));
		$from = trim($fromParts[2])."-".str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT);

		$toParts = explode("/",trim($dateRange[1]));
		$to = trim($toParts[2])."-".str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT);


		$datetimeRange['from'] = $from;
		$datetimeRange['to'] = $to;
  
		$dataProvider = VehicleOdometerSnaps::model()->search($vehicleId, $datetimeRange);
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
                
                if ($_GET['export']){
                    $vehicleId = $_GET['vehicleId'];
                    $dateRange = explode("-",$_GET['dateRange']);
                    $from = explode("/",$dateRange[0]);
                    $from = trim($from[2])."/".trim($from[1])."/".trim($from[0]);
                    $to = explode("/",$dateRange[1]);
                    $to = trim($to[2])."/".trim($to[1])."/".trim($to[0]);
                    $datetimeRange['from'] = $from;
                    $datetimeRange['to'] = $to;
                    
                     Yii::import('ext.ECSVExport');
                     // CActiveDataProvider
                    $csv = new ECSVExport(VehicleOdometerSnaps::model()->search($vehicleId, $datetimeRange));
                    //$csv->setOutputFile($this->outputFile);
                    $csv->setHeader('serial', 'Vehicle');
                    $csv->setHeader('dist', 'Distance');
                    $csv->setExclude('vehicle_id');
                    $content = $csv->toCSV();                   
                    Yii::app()->getRequest()->sendFile("vehicle-distance-". time().".csv", $content, "text/csv", false);
                    exit();
                }
                
                
		$this->render('vehiclesDistance',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));
		
	}
        
        public function actionVehiclesDistanceDetails()
	{
		$model=new VehicleOdometerSnaps;
		

		global $deviceId;
		$vehicleId = $_POST['Vehicle']['id'];
		$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
		$fromParts = explode("/",trim($dateRange[0]));
		$from = trim($fromParts[2])."-".str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT);
		$toParts = explode("/",trim($dateRange[1]));
		$to = trim($toParts[2])."-".str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT);
                $datetimeRange['from'] = $from;
                $datetimeRange['to'] = $to;
  
		$dataProvider = VehicleOdometerSnaps::model()->searchDetails($vehicleId, $datetimeRange);
                //If there is a selection
                if($_POST['Vehicle']['dateRange']){
                    
                    // Get all dates between selected range
                    $datesArray = VehicleOdometerSnaps::model()->createDateRangeArray($datetimeRange['from'],$datetimeRange['to']);
                    
                    // Create a columns array to push all generated date columns 
                    // dynamicaly and send it as variable in render function
                    $columnsArray = array();
                    array_push($columnsArray, array(
                                        'header'=>'SN.',
					'value'=>'++$row',
				));
                    array_push($columnsArray, array(
					"header" => "Vehicle",
			   		'value'=>'getVehicle($data->vehicle_id)',
				));
                    foreach ($datesArray as $key => $date){
                        array_push($columnsArray, array(
                                            "header" => "$date",
                                            "value"=>'$data->date'.$key,
                                    ));
                    }
                    array_push($columnsArray, array(
					"header" => "Distance",
			   		'value'=>'$data->dist',
				));
                }
                
                
                // renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
                
                if ($_GET['export']){
                    $vehicleId = $_GET['vehicleId'];
                    $dateRange = explode("-",$_GET['dateRange']);
                    $fromParts = explode("/",trim($dateRange[0]));
                    $from = trim($fromParts[2])."-".str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT);
                    $toParts = explode("/",trim($dateRange[1]));
                    $to = trim($toParts[2])."-".str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT);
                    $datetimeRange['from'] = $from;
                    $datetimeRange['to'] = $to;
                    
                     Yii::import('ext.ECSVExport');
                     // CActiveDataProvider
                    $csv = new ECSVExport(VehicleOdometerSnaps::model()->searchDetails($vehicleId, $datetimeRange));
                    // Get all dates between selected range
                    $datesArray = VehicleOdometerSnaps::model()->createDateRangeArray($datetimeRange['from'],$datetimeRange['to']);

                    $csv->setHeader('serial', 'Vehicle');
                    foreach ($datesArray as $key => $date){
                        $csv->setHeader('date'.$key, $date);
                    }
                    $csv->setHeader('dist', 'Distance');
                    $csv->setExclude('vehicle_id');
                    $content = $csv->toCSV();                   
                    Yii::app()->getRequest()->sendFile("vehicle-distance-". time().".csv", $content, "text/csv", false);
                    exit();
                }
                if ($_GET['export_separate_vehicles']){
                    $vehicleId = $_GET['vehicleId'];
                    $dateRange = explode("-",$_GET['dateRange']);
                    $fromParts = explode("/",trim($dateRange[0]));
                    $from = trim($fromParts[2])."-".str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT);
                    $toParts = explode("/",trim($dateRange[1]));
                    $to = trim($toParts[2])."-".str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT);
                    $datetimeRange['from'] = $from;
                    $datetimeRange['to'] = $to;

                     Yii::import('ext.ECSVExport');
                     // CActiveDataProvider
                    $csv = new ECSVExport(VehicleOdometerSnaps::model()->searchDetailsAsSeparateVehicles($vehicleId, $datetimeRange));
                    // Get all dates between selected range
                    $datesArray = VehicleOdometerSnaps::model()->createDateRangeArray($datetimeRange['from'],$datetimeRange['to']);

                    $csv->setHeader('serial', 'Vehicle');
                    foreach ($datesArray as $key => $date){
                        $csv->setHeader('date'.$key, $date);
                    }
                    $csv->setHeader('dist', 'Distance');
                    $csv->setExclude('vehicle_id');
                    $content = $csv->toCSV();
                    Yii::app()->getRequest()->sendFile("vehicle-distance-". time().".csv", $content, "text/csv", false);
                    exit();
                }
                
                
		$this->render('vehiclesDistanceDetails',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
                        'columnsArray'=>$columnsArray,
		));
		
	}
        
        public function actionVehiclesDistanceAccumulative()
	{
		$model=new VehicleOdometerSnaps;
		

		global $deviceId;
		$vehicleId = $_POST['Vehicle']['id'];
		$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
		$fromParts = explode("/",trim($dateRange[0]));
		$from = trim($fromParts[2])."-".str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT);
		$toParts = explode("/",trim($dateRange[1]));
		$to = trim($toParts[2])."-".str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT);
                $datetimeRange['from'] = $from;
                $datetimeRange['to'] = $to;
  
		$dataProvider = VehicleOdometerSnaps::model()->searchAccumulative($vehicleId, $datetimeRange);
                //If there is a selection
                if($_POST['Vehicle']['dateRange']){
                    
                    // Get all dates between selected range
                    $datesArray = VehicleOdometerSnaps::model()->createDateRangeArray($datetimeRange['from'],$datetimeRange['to']);
                    
                    // Create a columns array to push all generated date columns 
                    // dynamicaly and send it as variable in render function
                    $columnsArray = array();
                    array_push($columnsArray, array(
                                        'header'=>'SN.',
					'value'=>'++$row',
				));
                    array_push($columnsArray, array(
					"header" => "Vehicle",
			   		'value'=>'getVehicle($data->vehicle_id)',
				));
                    foreach ($datesArray as $key => $date){
                        array_push($columnsArray, array(
                                            "header" => "$date",
                                            "value"=>'$data->date'.$key,
                                    ));
                    }

                }
                
                
                // renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
                
                if ($_GET['export']){
                    $vehicleId = $_GET['vehicleId'];
                    $dateRange = explode("-",$_GET['dateRange']);
                    $fromParts = explode("/",trim($dateRange[0]));
                    $from = trim($fromParts[2])."-".str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT);
                    $toParts = explode("/",trim($dateRange[1]));
                    $to = trim($toParts[2])."-".str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT);
                    $datetimeRange['from'] = $from;
                    $datetimeRange['to'] = $to;
                    
                     Yii::import('ext.ECSVExport');
                     // CActiveDataProvider
                    $csv = new ECSVExport(VehicleOdometerSnaps::model()->searchAccumulative($vehicleId, $datetimeRange));
                    // Get all dates between selected range
                    $datesArray = VehicleOdometerSnaps::model()->createDateRangeArray($datetimeRange['from'],$datetimeRange['to']);

                    $csv->setHeader('serial', 'Vehicle');
                    foreach ($datesArray as $key => $date){
                        $csv->setHeader('date'.$key, $date);
                    }
                    $csv->setHeader('dist', 'Distance');
                    $csv->setExclude('vehicle_id');
                    $content = $csv->toCSV();                   
                    Yii::app()->getRequest()->sendFile("vehicle-distance-". time().".csv", $content, "text/csv", false);
                    exit();
                }

				if ($_GET['export_separate_vehicles']){
					$vehicleId = $_GET['vehicleId'];
					$dateRange = explode("-",$_GET['dateRange']);
					$to = explode("/",$dateRange[1]);
					$to = trim($to[2])."/".trim($to[1])."/".trim($to[0]);
					$datetimeRange['from'] = $from;
					$datetimeRange['to'] = $to;

					Yii::import('ext.ECSVExport');

					$csv = new ECSVExport(VehicleOdometerSnaps::model()->searchAccumulativeAsSeparateVehicles($vehicleId, $datetimeRange));

//
//					$csv->setHeader('serial', 'Vehicle');
//					foreach ($datesArray as $key => $date){
//						$csv->setHeader('date'.$key, $date);
//					}
					$csv->setHeader('dist', 'Distance');
					$csv->setExclude('vehicle_id');
					$content = $csv->toCSV();
					Yii::app()->getRequest()->sendFile("vehicle-distance-". time().".csv", $content, "text/csv", false);
					exit();
				}
                
                
		$this->render('vehiclesDistanceAccumulative',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
                        'columnsArray'=>$columnsArray,
		));
		
	}

	public function actionVehicleDistance()
	{

		if($_POST['Vehicle']['id'])
		{
			global $deviceId;
			$vehicle_id = $_POST['Vehicle']['id'];
			$from = reformDateTimeToGPS($_POST['Vehicle']['from'],Yii::app()->user->timezone);
			$to = reformDateTimeToGPS($_POST['Vehicle']['to'],Yii::app()->user->timezone);

			$date = DateTime::createFromFormat('Y/m/d  h:i a', $_POST['Vehicle']['from']);
			$fromLocal = $date->format('YmdHis');
			$date = DateTime::createFromFormat('Y/m/d  h:i a', $_POST['Vehicle']['to']);
			$toLocal = $date->format('YmdHis');


			$sql = "Select latitude, longitude, gps_datetime FROM vehicle_points_".$vehicle_id." WHERE gps_datetime between '$from' and '$to' AND gps_datetime NOT LIKE '20______000000'";

			$records = Yii::app()->db->createCommand($sql)->queryAll();
			$distance[$vehicle_id] = 0;

		}else{

			$condition = "t.device_id = 'imposible'";
			$table = 'device_details';
		}




		if ($records) {

			foreach ($records as $record){
				if (!$prevLat[$vehicle_id]){
					$distance[$vehicle_id] = 0;
					$prevLat[$vehicle_id] = $record['latitude'];
					$prevLong[$vehicle_id] = $record['longitude'];
				}else{
					$dist = calculateDistance($record['latitude'], $record['longitude'], $prevLat[$vehicle_id], $prevLong[$vehicle_id]);
					$distance[$vehicle_id] += $dist;
					$gpsDateTime = reformDateTime($record['gps_datetime'],Yii::app()->user->timezone);
					$prevLat[$vehicle_id] = $record['latitude'];
					$prevLong[$vehicle_id] = $record['longitude'];
				}

			}
		}

		$odometerFrom = file_get_contents("http://localhost/api/one_company_vehicle_bytime_text.php?vehicle_id=".$vehicle_id."&to=".$fromLocal."&key=mn6F83f073560feP83Dpem641sTmeTiA");

		print_r($odometerFrom);

		$this->render('vehicleDistance',array(
			'vehicleID'=>$vehicle_id,
			'distance'=>$distance[$vehicle_id],
			'odometerFrom' => $odometerFrom,
			'odometerTo' => $odometerFrom + $distance[$vehicle_id]
		));

	}

	public function actionVehicleSpeedZone(){
		$model = new VehicleSpeedzone;

		global $deviceId;
		$driverId = $_POST['Driver']['id'];
		$dateRange = explode("-",$_POST['Vehicle']['dateRange']);
		$fromParts = explode("/",trim($dateRange[0]));
		$from = trim($fromParts[2])."-".str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT);
		$toParts = explode("/",trim($dateRange[1]));
		$to = trim($toParts[2])."-".str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT);
		$datetimeRange['from'] = $from;
		$datetimeRange['to'] = $to;

		$dataProvider = $model->search($driverId, $datetimeRange);


		if ($_GET['export']){
			$driverId = $_GET['driverId'];
			$dateRange = explode("-",$_GET['dateRange']);
			$fromParts = explode("/",trim($dateRange[0]));
			$from = trim($fromParts[2])."-".str_pad(trim($fromParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($fromParts[0]), 2, '0', STR_PAD_LEFT);
			$toParts = explode("/",trim($dateRange[1]));
			$to = trim($toParts[2])."-".str_pad(trim($toParts[1]), 2, '0', STR_PAD_LEFT)."-".str_pad(trim($toParts[0]), 2, '0', STR_PAD_LEFT);
			$datetimeRange['from'] = $from;
			$datetimeRange['to'] = $to;

			Yii::import('ext.ECSVExport');
			// CActiveDataProvider
			$csv = new ECSVExport($model->search($driverId, $datetimeRange));

			$csv->useBOM();
			$csv->setExclude('vehicle_id');
			$content = $csv->toCSV();
			Yii::app()->getRequest()->sendFile("vehicle-speedZone". time().".csv", $content, "text/csv", false);
			exit();
		}

		$this->render('vehiclesSpeedZone',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
		));

	}
        
        public function actionExport(){
            CsvExport::export(
              VehicleOdometerSnaps::model()->findAll(), // a CActiveRecord array OR any CModel array
              array('idpeople'=>array('number'),'birthofdate'=>array('date')),
              true, // boolPrintRows
              'registers-upto--'.date('d-m-Y H-i').".csv"
             );
          }

	public function actionVehiclesMoreThanOdo(){
		$distance = Yii::app()->request->getParam('distance');
		$model = new VehicleOdometerSnapsToday;
		$dataProvider = VehicleOdometerSnapsToday::model()->searchDetails($distance);

		$this->render('vehicleOdometerSnapsToday',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model
		));
	}
	public function actionVehiclesLessThanOdo(){
		$distance = Yii::app()->request->getParam('distance');
		$dateTimeFrom = Yii::app()->request->getParam('from');
		$filterTrips = Yii::app()->request->getParam('filterTrips');

		if ($dateTimeFrom) $dateTimeFrom = reformDateTimeToGPS($dateTimeFrom,Yii::app()->user->timezone);
		if (!$dateTimeFrom) $dateTimeFrom = reformDateTimeToGPS(date('Y/m/d 00:00:00 \a\m', time()),Yii::app()->user->timezone);
		$dateTimeTo = Yii::app()->request->getParam('to');
		if ($dateTimeTo) $dateTimeTo = reformDateTimeToGPS($dateTimeTo,Yii::app()->user->timezone);
		if (!$dateTimeTo) $dateTimeTo = reformDateTimeToGPS(date('Y/m/d h:i:s a', time()));
//		echo $dateTimeFrom."<br>";
//		echo $dateTimeTo;
		if ($this->userData->userType->level <1000){
			$company_id= "Having companyId =".Yii::app()->user->company_id;
		}else{
			$company_id=" ";
		};
		if ($filterTrips){
			$trips = " AND (tr.from <= STR_TO_DATE('$dateTimeFrom','%Y%m%d%H%i%s') and (tr.to = date('0000-00-00') or tr.to > STR_TO_DATE('$dateTimeTo','%Y%m%d%H%i%s')))";
		}else{
			$trips = " ";
		}
		$isFirst = true;

		$vehiclesQuery = Yii::app()->db->createCommand("
							SELECT v.id,v.serial,v.company_id as companyId
                            FROM vehicle as v
                            LEFT JOIN repairs as r on r.vehicle_id = v.id
                            LEFT JOIN trip as tr on tr.vehicle_id = v.id
                            WHERE
                            r.end_date <= STR_TO_DATE('$dateTimeFrom','%Y%m%d%H%i%s') and r.end_date <> date('0000-00-00') or r.end_date is null
                            $trips
                            Group By v.id
              				$company_id
                            Order By v.serial+0, v.serial+0 <>0 DESC, v.serial");
		$vehicles = $vehiclesQuery->queryAll();

		if ($vehicles){
			foreach ($vehicles as $vehicle){
				if($isFirst){
					$temp = 0;
					$sqlCmdMain = Yii::app()->db->createCommand();
					$sqlCmdMain->select("(ROUND(sum(distance)/1000,2) )as distance, '{$vehicle['serial']}' as vehicle_number");
					$sqlCmdMain->from('vehicle_points_'.$vehicle['id']);
					$sqlCmdMain->where('gps_datetime between "'.$dateTimeFrom.'" AND "'.$dateTimeTo.'"');
					$temp = $sqlCmdMain->queryRow();
					$sqlText = $sqlCmdMain->getText();
					if ($temp['distance'] != null and intval($temp['distance']) < $distance){
						$sqlCmdMain = Yii::app()->db->createCommand();
						$sqlCmdMain->select("(ROUND(sum(distance)/1000,2) )as distance, '{$vehicle['serial']}' as vehicle_number");
						$sqlCmdMain->from('vehicle_points_'.$vehicle['id']);
						$sqlCmdMain->where('gps_datetime between "'.$dateTimeFrom.'" AND "'.$dateTimeTo.'"');
						$isFirst = false;
					}else{
						continue;
					}
				}else{
					$temp = 0;
					$sqlCmdChild = Yii::app()->db->createCommand();
					$sqlCmdChild->select("(ROUND(sum(distance)/1000,2) )as distance, '{$vehicle['serial']}' as vehicle_number");
					$sqlCmdChild->from('vehicle_points_'.$vehicle['id']);
					$sqlCmdChild->where('gps_datetime between "'.$dateTimeFrom.'" AND "'.$dateTimeTo.'"');
					$temp = $sqlCmdChild->queryRow();
					if (intval($temp['distance']) < $distance)
						$sqlCmdMain->union($sqlCmdChild->getText());
				}


		}
			$sql = $sqlCmdMain->getText();

			$count=Yii::app()->db->createCommand($sql)->queryScalar();

			$dataProvider=new CSqlDataProvider($sql, array(
					'totalItemCount'=>$count,
					'sort'=>array(
						'attributes'=>array(
							'id'
						),
					),
					'pagination'=> false
				)

			);

		}else{
			$dataProvider = false;
		}




		$this->render('vehicleOdometerSnapsToday',array(
			'dataProvider'=>$dataProvider,
			'dateTimeFrom'=>$dateTimeFrom,
			'dateTimeTo'=>$dateTimeTo
		));
	}

}