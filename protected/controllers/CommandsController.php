<?php

class CommandsController extends Controller
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
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','selectVehicle', 'selectDevice', 'createAjax', 'dataLogAjax'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
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
		$model=new Commands;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Commands']))
		{
                        date_default_timezone_set('GMT');
                        $_POST['Commands']['date_recorded'] = date("Y-m-d H:i:s");
			$model->attributes=$_POST['Commands'];
			if($model->save())
				$this->redirect(array('index&ajax=command-grid&Commands_sort=id.desc','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
        
        public function actionCreateAjax()
	{
		$model=new Commands;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Commands']))
		{
                        date_default_timezone_set('GMT');
                        $_POST['Commands']['date_recorded'] = date("Y-m-d H:i:s");
			$model->attributes=$_POST['Commands'];
			if($model->save()) 
                        {echo "Sent";}else{echo "Not Sent";};
                }

	}
        
        
        public function actionDataLogAjax()
	{	
            $commands = $this->loadModelByDevice($_POST['vehicleID']);
            
          foreach ($commands as $command){
            if ($command->date_response) echo("<div>".$command->date_response." GMT: Device Responded with \"".$command->response."\"</div>");
            if ($command->date_sent) echo("<div>".$command->date_sent." GMT: Command Sent</div>");
            echo("<div>".$command->date_recorded." GMT: Command Recoreded</div>");
          }
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

		if(isset($_POST['Commands']))
		{
			$model->attributes=$_POST['Commands'];
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index&ajax=command-grid&Commands_sort=id.desc'));
	}

	/**
	 * Lists all models.
	 
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Commands');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}*/

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new Commands('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Commands']))
			$model->attributes=$_GET['Commands'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        
        public function actionSelectVehicle()
	{
		
		
                $criteria = new CDbCriteria();
		$criteria->addCondition("`device_id` = {$_POST['Commands']['device_id']}");
                
                $criteria2 = new CDbCriteria();
		$criteria2->addCondition("`id` = {$_POST['Commands']['device_id']}");
                
		//Vehicle
                If ($_POST['Commands']['device_id']){
                    
		$data=Vehicle::model()->findAll($criteria);
                $data2=Device::model()->findAll($criteria2);
                }else{
                    $data=Vehicle::model()->search("list",true);
                    $data2=Device::model()->findAll();
                    $dropDownVehicle = CHtml::tag('option',array('value'=>''),CHtml::encode('(Select a Vehicle)'),true);

                }
	 
		$data=CHtml::listData($data,'id','serial');
		
		foreach($data as $value=>$name)
		{
			$dropDownVehicle .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
		}
                
                
                $data2=CHtml::listData($data2,'deviceType.type_en','device_type_id');
		
		foreach($data2 as $value=>$name)
		{
                    $deviceType =  $value;   
                    $deviceTypeId = $name;                        
		}
                
                $criteria3 = new CDbCriteria();
		$criteria3->addCondition("`device_type_id` = $deviceTypeId");
                if (Yii::app()->user->level >=1000)
		{}else{
                $criteria3->addCondition("`user_available` = 1");
                }
                $data3=DeviceCommands::model()->findAll($criteria3);
                $data3=CHtml::listData($data3,'id','name');
                
                
                $dropDownCommand = CHtml::tag('option',array('value'=>''),CHtml::encode('(Select a Command)'),true);
		foreach($data3 as $value=>$name)
		{
                        $dropDownCommand .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);                        
		}
		
               
                $final = array('dropDownVehicle'=>$dropDownVehicle,'device_type_id'=>$deviceTypeId,'dropDownCommand'=>$dropDownCommand,'device_type'=>$deviceType);
                
  
		$this->selectReturn($final);
		
	
	}
        
        
        public function actionSelectDevice()
	{
		$criteria = new CDbCriteria();
                $criteria->join = 'LEFT JOIN `vehicle` `v` ON v.device_id = t.id';
		$criteria->addCondition("`v`.`id` = {$_POST['Vehicle']['id']}");
                

		
		//Device
                 If ($_POST['Vehicle']['id']){
		$data=Device::model()->findAll($criteria);
                $data2=Device::model()->findAll($criteria);
                }else{
                    $data=Device::model()->findAll();
                    $data2=Device::model()->findAll();
                    $dropDownDevice = CHtml::tag('option',array('value'=>''),CHtml::encode('(Select a Device)'),true);

                }
		
	 
		$data=CHtml::listData($data,'id','deviceType.type_en');
		
		foreach($data as $value=>$name)
		{
			$dropDownDevice .= CHtml::tag('option',array('value'=>$value),CHtml::encode($value),true);
                        $deviceType = $name;
                        
		}
                
                $data2=CHtml::listData($data2,'id','device_type_id');
		
		foreach($data2 as $value=>$name)
		{
                        $deviceTypeId = $name;                        
		}
                
                $criteria3 = new CDbCriteria();
		$criteria3->addCondition("`device_type_id` = $deviceTypeId");
                if (Yii::app()->user->level >=1000)
		{}else{
                $criteria3->addCondition("`user_available` = 1");
                }
                $data3=DeviceCommands::model()->findAll($criteria3);
                $data3=CHtml::listData($data3,'id','name');
                
                
                $dropDownCommand = CHtml::tag('option',array('value'=>''),CHtml::encode('(Select a Command)'),true);
		foreach($data3 as $value=>$name)
		{
                        $dropDownCommand .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);                        
		}
		
               
                    $this->selectReturn(array(
                      'dropDownDevice'=>$dropDownDevice,
                      'device_type' =>$deviceType,
                      'device_type_id' =>$deviceTypeId,
                      'dropDownCommand'=>$dropDownCommand,
                    ));
		

	}
        
        
        private function selectReturn($data){
            

                echo CJSON::encode($data);
           

        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Commands::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
        
        
        public function loadModelByDevice($id)
	{
            if ($id){    
                $model=Commands::model()->findAllBySql("SELECT * from commands WHERE device_id = ".$id." ORDER BY id DESC");
		return $model;
            }
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='commands-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
