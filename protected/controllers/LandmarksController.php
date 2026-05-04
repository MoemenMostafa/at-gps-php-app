<?php

class LandmarksController extends Controller
{
	public function actionAdmin()
	{
		$this->render('admin');
	}

	public function actionIndex()
	{
		$data = Landmarks::model()->search("list");
		$this->renderJSON($data);
	}

	public function actionGet()
	{
		$data = Landmarks::model()->search("list");
		$this->renderJSON($data);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreateAjax()
	{
		$model=new Landmarks;

		if (Yii::app()->request->getParam( 'action' ) && Yii::app()->request->getParam( 'action' ) === "delete")
		{
			$params = Yii::app()->request->getParam( 'Landmarks' );
			$id = $params[id];
			if($this->loadModel($id)->delete()){
				$data = array("status"=>"success");
				$this->renderJSON($data);
			}else{
				$data = array("status"=>"failed","error"=>$model->errors);
				$this->renderJSON($data);
			}

		}else if( Yii::app()->request->getParam( 'Landmarks' ))
		{
			$params = Yii::app()->request->getParam( 'Landmarks' );
			if ($params[id]){
				$model=$this->loadModel($params[id]);
				$model->attributes= Yii::app()->request->getParam( 'Landmarks' );
			}else{
				$model->attributes= Yii::app()->request->getParam( 'Landmarks' );
				$model->company_id = $this->userData->company_id;
			}
			if($model->save()){
				$data = array("status"=>"success");
				$this->renderJSON($data);
			}else{
				$data = array("status"=>"failed","error"=>$model->errors);
				$this->renderJSON($data);
			}

		}

	}


	public function actionDeleteAjax()
	{
		$id = Yii::app()->request->getParam( 'id' );
		$this->loadModel($id)->delete();
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		$id = Yii::app()->request->getParam( 'id' );
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		$name = Yii::app()->request->getParam( 'name' );
		$lat = Yii::app()->request->getParam( 'lat' );
		$long = Yii::app()->request->getParam( 'long' );
		$icon = Yii::app()->request->getParam( 'icon' );
		$company_id = Yii::app()->request->getParam( 'company_id' );

		if(isset($id))
		{
			$model->id = $id;

			if(isset($name)) $model->name=$name;
			if(isset($lat)) $model->lat=$lat;
			if(isset($long)) $model->long=$long;
			if(isset($icon)) $model->icon=$icon;
			if(isset($company_id)) $model->company_id=$company_id;

			if($model->save()){
				$data = array("status"=>"success");
				$this->renderJSON($data);
			}else{
				$data = array("status"=>"failed","error"=>$model->errors);
				$this->renderJSON($data);
			}
		}

	}


	/**
	 * Return data to browser as JSON and end application.
	 * @param array $data
	 */
	protected function renderJSON($data)
	{
		header('Content-type: application/json');
		echo CJSON::encode($data);

		foreach (Yii::app()->log->routes as $route) {
			if($route instanceof CWebLogRoute) {
				$route->enabled = false; // disable any weblogroutes
			}
		}
		Yii::app()->end();
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Landmarks::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}


	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}