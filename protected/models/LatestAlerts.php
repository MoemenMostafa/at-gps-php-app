<?php

/**
 * This is the model class for table "latest_alerts".
 *
 * The followings are the available columns in table 'latest_alerts':
 * @property integer $vehicle_id
 * @property integer $alert_id
 * @property integer $status
 * @property integer $user_id
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property Vehicle $vehicle
 * @property Alert $alert
 * @property User $user
 */
class LatestAlerts extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LatestAlerts the static model class
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
		return 'latest_alerts';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vehicle_id, alert_id, status, type', 'required'),
			array('vehicle_id, alert_id, status, user_id, type', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('vehicle_id, alert_id, status, user_id, type', 'safe', 'on'=>'search'),
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
			'vehicle' => array(self::BELONGS_TO, 'Vehicle', 'vehicle_id'),
			'alert' => array(self::BELONGS_TO, 'Alert', 'alert_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'vehicle_id' => 'Vehicle',
			'alert_id' => 'Alert',
			'status' => 'Status',
			'user_id' => 'User',
			'type' => 'Type',
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
		$criteria->compare('alert_id',$this->alert_id);
		$criteria->compare('status',$this->status);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('type',$this->type);
		$criteria->with = array('vehicle');
		if (Yii::app()->user->level >=1000)
		{}else{
		$company_id=Yii::app()->user->company_id;
		$criteria->addCondition("vehicle.company_id = $company_id");
		$criteria->with = array('vehicle');
		}
		
		 
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getTypeText(){
		if ($this->type =="1"){return "Geofence";}
	}
	
	public function getDateTime(){
		date_default_timezone_set('GMT');
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $this->alert->datetime);
		if($date){
			$date->setTimezone(new DateTimeZone(Yii::app()->user->timezone));
			return ($this->alert->datetime = $date->format('Y-m-d h:i:s a'));
		}
	}

}