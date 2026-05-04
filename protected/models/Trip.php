<?php

/**
 * This is the model class for table "trip".
 *
 * The followings are the available columns in table 'trip':
 * @property integer $id
 * @property integer $vehicle_id
 * @property integer $route_id
 * @property integer $driver_id
 * @property integer $company_id
 * @property string $from
 * @property string $to
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Vehicle $vehicle
 * @property Route $route
 * @property Driver $driver
 */
class Trip extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Trip the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trip';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vehicle_id, route_id, driver_id, company_id, from', 'required'),
			array('to', 'safe'),
			array('vehicle_id, route_id, driver_id, company_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vehicle_id, route_id, driver_id, company_id, from, to', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'vehicle' => array(self::BELONGS_TO, 'Vehicle', 'vehicle_id'),
			'route' => array(self::BELONGS_TO, 'Route', 'route_id'),
			'driver' => array(self::BELONGS_TO, 'Driver', 'driver_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'vehicle_id' => 'Vehicle ID',
			'route_id' => 'Route',
			'driver_id' => 'Driver',
			'company_id' => 'Company',
			'from' => 'From',
			'to' => 'To',
			'route.name' => 'Route',
			'driver.name' => 'Driver',
			'company.name' => 'Company',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('route_id',$this->route_id);
		$criteria->compare('driver_id',$this->driver_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);
		if (Yii::app()->user->level >=1000)
		{$criteria->compare('company_id',$this->company_id);
		}else{
		$company_id=Yii::app()->user->company_id;
		$criteria->addCondition("company_id = $company_id");
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getFromLocal() {
			date_default_timezone_set('GMT');
			$dateFrom = DateTime::createFromFormat('Y-m-d H:i:s', $this->from);
			if($dateFrom){
				$dateFrom->setTimezone(new DateTimeZone(Yii::app()->user->timezone));
				return $dateFrom->format('Y-m-d h:i a');
			}

	}
	
	public function getToLocal() {
			date_default_timezone_set('GMT');
			$dateTo = DateTime::createFromFormat('Y-m-d H:i:s', $this->to);
			if($dateTo){
				$dateTo->setTimezone(new DateTimeZone(Yii::app()->user->timezone));
				return $dateTo->format('Y-m-d h:i a');
			}

	}

	public function getVehicleFilter() {
		$criteria = new CDbCriteria();
		$criteria->select = "id, serial";
		if (Yii::app()->user->level >=1000)
		{$criteria->compare('company_id',$this->company_id);
		}else{
			$company_id=Yii::app()->user->company_id;
			$criteria->addCondition("company_id = $company_id");
		}
		$results = Vehicle::model()->findAll($criteria);
		$category_list = array();
		foreach ($results as $result) {
			$category_list[$result->id] = $result->id;
			$category_list[$result->id] = $result->serial;
		}
		return $category_list;
	}

	public function getDriverFilter() {
		$criteria = new CDbCriteria();
		$criteria->select = "id, name";
		if (Yii::app()->user->level >=1000)
		{$criteria->compare('company_id',$this->company_id);
		}else{
			$company_id=Yii::app()->user->company_id;
			$criteria->addCondition("company_id = $company_id");
		}
		$results = Driver::model()->findAll($criteria);
		$category_list = array();
		foreach ($results as $result) {
			$category_list[$result->id] = $result->id;
			$category_list[$result->id] = $result->name;
		}
		return $category_list;
	}

	public function getRouteFilter() {
		$criteria = new CDbCriteria();
		$criteria->select = "id, name";
		if (Yii::app()->user->level >=1000)
		{$criteria->compare('company_id',$this->company_id);
		}else{
			$company_id=Yii::app()->user->company_id;
			$criteria->addCondition("company_id = $company_id");
		}
		$results = Route::model()->findAll($criteria);
		$category_list = array();
		foreach ($results as $result) {
			$category_list[$result->id] = $result->id;
			$category_list[$result->id] = $result->name;
		}
		return $category_list;
	}
}