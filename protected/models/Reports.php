<?php

/**
 * This is the model class for table "device_details".
 *
 * The followings are the available columns in table 'device_details':
 * @property integer $id
 * @property integer $device_id
 * @property integer $gps_datetime
 * @property string $longitude
 * @property string $latitude
 * @property integer $speed
 * @property string $direction
 * @property integer $altitude
 * @property integer $satellites
 * @property integer $messageID
 * @property integer $input_status
 * @property integer $output_status
 * @property string $analog_input1
 * @property string $analog_input2
 * @property integer $rtc_datetime
 * @property integer $mileage
 * @property integer $speed_cam
 * @property integer $rpm_cam
 * @property integer $engine_temp_cam
 * @property integer $fuel_level_cam
 * @property integer $fuel_rate_cam
 * @property integer $fuel_temp_cam
 * @property integer $oil_press_cam
 * @property integer $acc_pedal_cam
 * @property integer $axel_weight_cam
 * @property integer $odometer_cam
 * @property integer $distance
 */
class Reports extends CActiveRecord
{
	
	
	private $tableName = 'device_details';
    private static $_models=array();
    private $_md;
	

	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DeviceDetails the static model class
	 */
	public static function model($tableName = false, $className=__CLASS__)
	{
		if($tableName === null) $className=null; // this string will save internal CActiveRecord functionality
        if(!$tableName)
            return parent::model($className);

        if(isset(self::$_models[$tableName.$className]))
            return self::$_models[$tableName.$className];
        else
        {
            $model=self::$_models[$tableName.$className]=new $className(null);
            $model->tableName = $tableName;

            $model->_md=new CActiveRecordMetaData($model);
            $model->attachBehaviors($model->behaviors());

            return $model;
        }
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return $this->tableName;
	}
	
	
	
	public function getMetaData()
    {
        if($this->_md!==null)
            return $this->_md;
        else
            return $this->_md=static::model($this->tableName())->_md;
    }

    public function refreshMetaData()
    {
        $finder=static::model($this->tableName());
        $finder->_md=new CActiveRecordMetaData($finder);
        if($this!==$finder)
            $this->_md=$finder->_md;
    }
	
	

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			// array('device_id, gps_datetime, longitude, latitude, speed, direction, altitude, satellites, messageID, input_status, output_status, analog_input1, analog_input2, rtc_datetime, mileage, distance', 'required'),
			// array('device_id, gps_datetime, speed, altitude, satellites, messageID, input_status, output_status, rtc_datetime, mileage, speed_cam, rpm_cam, engine_temp_cam, fuel_level_cam, fuel_rate_cam, fuel_temp_cam, oil_press_cam, acc_pedal_cam, axel_weight_cam, odometer_cam, distance', 'numerical', 'integerOnly'=>true),
			// array('longitude, latitude', 'length', 'max'=>9),
			// array('direction, analog_input1, analog_input2', 'length', 'max'=>6),
			// // The following rule is used by search().
			// // Please remove those attributes that should not be searched.
			// array('id, device_id, gps_datetime, longitude, latitude, speed, direction, altitude, satellites, messageID, input_status, output_status, analog_input1, analog_input2, rtc_datetime, mileage, speed_cam, rpm_cam, engine_temp_cam, fuel_level_cam, fuel_rate_cam, fuel_temp_cam, oil_press_cam, acc_pedal_cam, axel_weight_cam, odometer_cam, distance', 'safe', 'on'=>'search'),
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
			'device' => array(self::BELONGS_TO, 'Device', 'device_id'),
			'vehicle' => array(self::MANY_MANY, 'Vehicle', 'device(id, device_id)'),
			'vehicle_drivers' => array(self::MANY_MANY, 'VehicleDrivers', 'vehicle(id, device_id)'),
			'driver' => array(self::MANY_MANY, 'Driver', 'vehicle_drivers(driver_id, vehicle_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			// 'id' => 'ID',
			// 'device_id' => 'Device ID',
			// 'gps_datetime' => 'Gps Datetime',
			// 'longitude' => 'Longitude',
			// 'latitude' => 'Latitude',
			// 'speed' => 'Speed',
			// 'direction' => 'Direction',
			// 'altitude' => 'Altitude',
			// 'satellites' => 'Satellites',
			// 'messageID' => 'Message',
			// 'input_status' => 'Input Status',
			// 'output_status' => 'Output Status',
			// 'analog_input1' => 'Analog Input1',
			// 'analog_input2' => 'Analog Input2',
			// 'rtc_datetime' => 'Rtc Datetime',
			// 'mileage' => 'Mileage',
			// 'speed_cam' => 'Speed Cam',
			// 'rpm_cam' => 'Rpm',
			// 'engine_temp_cam' => 'Engine Temp.',
			// 'fuel_level_cam' => 'Fuel Level',
			// 'fuel_rate_cam' => 'Fuel Rate',
			// 'fuel_temp_cam' => 'Fuel Temp.',
			// 'oil_press_cam' => 'Oil Pressure',
			// 'acc_pedal_cam' => 'Acc. Pedal %',
			// 'axel_weight_cam' => 'Axel Weight Cam',
			// 'odometer_cam' => 'Odometer Cam',
			// 'distance' => 'Distance',

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

		// $criteria->compare('id',$this->id);
		// $criteria->compare('device_id',$this->device_id);
		// $criteria->compare('gps_datetime',$this->gps_datetime);
		// $criteria->compare('longitude',$this->longitude,true);
		// $criteria->compare('latitude',$this->latitude,true);
		// $criteria->compare('speed',$this->speed);
		// $criteria->compare('direction',$this->direction,true);
		// $criteria->compare('altitude',$this->altitude);
		// $criteria->compare('satellites',$this->satellites);
		// $criteria->compare('messageID',$this->messageID);
		// $criteria->compare('input_status',$this->input_status);
		// $criteria->compare('output_status',$this->output_status);
		// $criteria->compare('analog_input1',$this->analog_input1,true);
		// $criteria->compare('analog_input2',$this->analog_input2,true);
		// $criteria->compare('rtc_datetime',$this->rtc_datetime);
		// $criteria->compare('mileage',$this->mileage);
		// $criteria->compare('speed_cam',$this->speed_cam);
		// $criteria->compare('rpm_cam',$this->rpm_cam);
		// $criteria->compare('engine_temp_cam',$this->engine_temp_cam);
		// $criteria->compare('fuel_level_cam',$this->fuel_level_cam);
		// $criteria->compare('fuel_rate_cam',$this->fuel_rate_cam);
		// $criteria->compare('fuel_temp_cam',$this->fuel_temp_cam);
		// $criteria->compare('oil_press_cam',$this->oil_press_cam);
		// $criteria->compare('acc_pedal_cam',$this->acc_pedal_cam);
		// $criteria->compare('axel_weight_cam',$this->axel_weight_cam);
		// $criteria->compare('odometer_cam',$this->odometer_cam);
		// $criteria->compare('distance',$this->distance);


		$criteria->with = array('device');
		if (Yii::app()->user->level >=1000)
		{}else{
		$company_id=Yii::app()->user->company_id;
		$criteria->with = array('device');
		$criteria->addCondition("device.company_id = $company_id");
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));



		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}