<?php

class RepairsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
				'actions'=>array('create','update','AjaxUpdate', 'AjaxSelect', 'AjaxCreate', 'Export', 'ExportFile'),
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Repairs']))
		{
			$model->attributes=$_POST['Repairs'];
			if($model->save())
				$this->redirect(array('index','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
        
        public function actionAjaxUpdate()
	{
		$model=$this->loadModel($_POST['Repairs']['id']);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                
                if(isset($_POST['Repairs']))
		{
			$model->attributes=$_POST['Repairs'];
			if($model->save())
				Echo "<strong>Successfully Updated vehicle no. ".$vehicle."</strong>";
                }

	}
        
        public function actionAjaxCreate()
	{
		$model=new Repairs;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                if(isset($_POST['Repairs']))
		{echo var_dump($_POST);
                        $model->attributes=$_POST['Repairs'];
			if($model->save());
                }
        }
        
        public function actionAjaxSelect($id, $vehicleId, $location, $description, $startDate, $endDate , $note)
	{
		
                $data['id']=$id;
                $data['vehicleId']=$vehicleId;
                $data['location']=$location;
                $data['description']=$description;
                $data['startDate']=$startDate;
                $data['endDate']=$endDate;
                $data['note']=$note;
                $return = json_encode($data);
                echo($return);
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
                if(Yii::app()->request->getParam('export')) {
                    $this->actionExport();
                    Yii::app()->end();
                }
		
                $model=new Repairs('search');
		$model->unsetAttributes();  // clear any default values

		$this->render('index',array(
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
		$model=Repairs::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='repairs-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionExport()
        {
            $fp = fopen('php://temp', 'w');

            /* 
             * Write a header of csv file
             */
            $headers = array(
                'vehicle_id',
                'location',
                'description',
                'start_date',
                'end_date',
                'note',
            );
            $row = array();
            foreach($headers as $header) {
                $row[] = RepairsController()->getAttributeLabel($header);
            }
            fputcsv($fp,$row);

            /*
             * Init dataProvider for first page
             */
            $model=new Model('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['MODEL'])) {
                $model->attributes=$_GET['MODEL'];
            }
            $dp = $model->search();

            /*
             * Get models, write to a file, then change page and re-init DataProvider
             * with next page and repeat writing again
             */
            while($models = $dp->getData()) {
                foreach($models as $model) {
                    $row = array();
                    foreach($headers as $head) {
                        $row[] = CHtml::value($model,$head);
                    }
                    fputcsv($fp,$row);
                }

                unset($model,$dp,$pg);
                $model=new MODEL('search');
                $model->unsetAttributes();  // clear any default values
                if(isset($_GET['MODEL']))
                    $model->attributes=$_GET['MODEL'];

                $dp = $model->search();
                $nextPage = $dp->getPagination()->getCurrentPage()+1;
                $dp->getPagination()->setCurrentPage($nextPage);
            }

            /*
             * save csv content to a Session
             */
            rewind($fp);
            Yii::app()->user->setState('export',stream_get_contents($fp));
            fclose($fp);
        }
        
        public function actionExportFile()
        {
            Yii::app()->request->sendFile('repairs.csv',Yii::app()->user->getState('export'));
            Yii::app()->user->clearState('export');
        }
}
