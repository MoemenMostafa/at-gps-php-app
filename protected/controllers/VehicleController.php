<?php

class VehicleController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2_admin';

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
				'users'=>array('@'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete', 'export', 'dynamicvehicles', 'bulkdelete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Vehicle;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Vehicle']))
		{
			$model->attributes=$_POST['Vehicle'];
			if($model->save()){
				
				//Create vehicle_points_$id table for the vehicle
				Yii::app()->db->createCommand("
				
						CREATE TABLE IF NOT EXISTS `vehicle_points_{$model->id}` (
						  `id` int(11) NOT NULL AUTO_INCREMENT,
						  `device_id` bigint(16) NOT NULL,
						  `gps_datetime` varchar(14) NOT NULL,
						  `longitude` decimal(9,7) NOT NULL,
						  `latitude` decimal(9,7) NOT NULL,
						  `speed` int(3) NOT NULL,
						  `direction` decimal(6,3) NOT NULL,
						  `altitude` int(11) NOT NULL,
						  `satellites` int(11) NOT NULL,
						  `messageID` int(11) NOT NULL,
						  `input_status` int(11) NOT NULL,
						  `output_status` int(11) NOT NULL,
						  `analog_input1` decimal(6,3) NOT NULL,
						  `analog_input2` decimal(6,3) NOT NULL,
						  `rtc_datetime` varchar(14) NOT NULL,
						  `mileage` int(11) NOT NULL,
						  `speed_cam` int(3) DEFAULT NULL COMMENT 'Km/h',
						  `rpm_cam` int(5) DEFAULT NULL,
						  `engine_temp_cam` int(4) DEFAULT NULL COMMENT 'if more than 180 or (-) value then (ignore (bad data)) ',
						  `fuel_level_cam` int(3) DEFAULT NULL,
						  `fuel_rate_cam` int(4) DEFAULT NULL,
						  `fuel_temp_cam` int(4) DEFAULT NULL COMMENT 'if more than 180 or (-) value then (ignore (bad data)) ',
						  `oil_press_cam` int(5) DEFAULT NULL COMMENT '(KPa) ##### x 0.69',
						  `acc_pedal_cam` int(3) DEFAULT NULL COMMENT '%',
						  `axel_weight_cam` int(5) DEFAULT NULL COMMENT 'Kg',
						  `odometer_cam` int(11) DEFAULT NULL COMMENT 'Km',
						  `distance` int(11) DEFAULT NULL COMMENT 'Km',
						  PRIMARY KEY (`id`),
						  KEY `fk_device_details_device` (`device_id`),
						  KEY `gps_datetime` (`gps_datetime`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1;
						
				
				
				
				")->query();
				
				
				//Create trigger for vehicle_points table
				Yii::app()->db->createCommand("
							CREATE TRIGGER  `update_latest_points_{$model->id}` AFTER INSERT ON `vehicle_points_{$model->id}`
									 FOR EACH ROW UPDATE latest_points
									SET gps_datetime = NEW.gps_datetime , longitude = NEW.longitude , latitude = NEW.latitude , speed = NEW.speed , direction = NEW.direction , altitude = NEW.altitude , satellites = NEW.satellites , messageID = NEW.messageID , latitude = NEW.latitude , input_status = NEW.input_status ,	output_status = NEW.output_status  ,	analog_input1 = NEW.analog_input1  ,	analog_input2 = NEW.analog_input2  ,	rtc_datetime = NEW.rtc_datetime  ,	mileage	= NEW.mileage	 ,	rpm_cam	 = NEW.rpm_cam	  , engine_temp_cam = NEW.engine_temp_cam  , fuel_level_cam = NEW.fuel_level_cam  , fuel_rate_cam = NEW.fuel_rate_cam  , fuel_temp_cam = NEW.fuel_temp_cam  ,	oil_press_cam = NEW.oil_press_cam  ,	acc_pedal_cam = NEW.acc_pedal_cam  ,	axel_weight_cam = NEW.axel_weight_cam   ,	odometer_cam = NEW.odometer_cam  
									WHERE device_id = NEW.device_id AND NEW.gps_datetime > gps_datetime AND NEW.gps_datetime < DATE_FORMAT(CURRENT_TIMESTAMP + INTERVAL 1 DAY,'%Y%m%d%H%i%s');
				")->query();
				
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Vehicle']))
		{
			$model->attributes=$_POST['Vehicle'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
		if ($this->loadModel($id)->delete())
				Yii::app()->db->createCommand("DROP TABLE IF EXISTS `vehicle_points_$id`")->query();;

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Vehicle('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Vehicle']))
			$model->attributes=$_GET['Vehicle'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        public function actionExport()
	{
		$model=new Vehicle('search');
		$model->unsetAttributes();  // clear any default values
                


		$this->render('export',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Vehicle::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='vehicle-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        
        public function actionDynamicvehicles()
	{
		
		$criteria = new CDbCriteria();
		$criteria->addCondition("`company_id` = {$_POST['Vehicle']['company_id']}");
		
		
		//Vehicle
		$data=Vehicle::model()->findAll($criteria);
	 
		$data=CHtml::listData($data,'id','serial');
		
		$dropDownVehicle = CHtml::tag('option',array('value'=>''),CHtml::encode('(Select a Vehicle)'),true);
		foreach($data as $value=>$name)
		{
			$dropDownVehicle .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
		}
	
		
		// return data (JSON formatted)
            echo CJSON::encode(array(
              'dropDownVehicle'=>$dropDownVehicle,
            ));
		
	}

	public function actionBulkDelete()
	{
		// 1. Respect the user role (level 500 required for admin actions)
		if (method_exists($this, 'allowUser')) {
			$this->allowUser(500);
		}

		if (isset($_POST['ids']) && !empty($_POST['ids'])) {
			$userCompanyId = Yii::app()->user->company_id;
			$userLevel = Yii::app()->user->level;

			foreach ($_POST['ids'] as $id) {
				$model = $this->loadModel($id);
				
				// 2. Data Scope Check: Ensure the user owns this record OR is a Super Admin
				if ($model && ($userLevel >= 1000 || $model->company_id == $userCompanyId)) {
					$model->delete();
				}
			}
			echo "Selected items have been deleted.";
		}
	}
}
