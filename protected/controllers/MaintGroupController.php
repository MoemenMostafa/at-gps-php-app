<?php

class MaintGroupController extends Controller
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
				'actions'=>array('create','update','SelectBrand'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('@'),
			),
		);
	}

        
        public function actionSelectBrand()
	{

                $criteria = new CDbCriteria();
		$criteria->addCondition("`company_id` = {$_POST['MaintItem']['company_id']}");
                $criteria->addCondition("`maint_item_brand_id` = {$_POST['MaintItemBrand']['id']}");
            
		//Item Group
		$data=  MaintItem::model()->findAll($criteria);;
	 
		$data=CHtml::listData($data,'id','name');
		
		$dropDownMaintItem = CHtml::tag('option',array('value'=>''),CHtml::encode('(Select Item)'),true);
		foreach($data as $value=>$name)
		{
			$dropDownMaintItem .= CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
		}
 
                
                // return data (JSON formatted)
                echo CJSON::encode(array(
                    'dropDownMaintItem'=>$dropDownMaintItem,
                ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MaintGroup;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MaintGroup']))
		{
			$model->attributes=$_POST['MaintGroup'];
			if($model->save())
				$this->redirect(array('index','id'=>$model->id));
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

		if(isset($_POST['MaintGroup']))
		{
			$model->attributes=$_POST['MaintGroup'];
			if($model->save())
				$this->redirect(array('index','id'=>$model->id));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		
                $model=new MaintGroup('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MaintGroup']))
			$model->attributes=$_GET['MaintGroup'];

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
		$model=MaintGroup::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='maint-group-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
