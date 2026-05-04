<?php

/**
 * This is the model class for table "alert_overspeed".
 *
 * The followings are the available columns in table 'alert_overspeed':
 * @property integer $id
 * @property integer $vehicle_id
 * @property double $distance_one
 * @property integer $time_one
 * @property double $distance_two
 * @property integer $time_two
 * @property double $distance_three
 * @property integer $time_three
 * @property double $distance_four
 * @property integer $time_four
 * @property integer $driver_id
 * @property string $date
 * @property string $lat
 * @property string $lon
 * @property string $gps_datetime
 *
 * The followings are the available model relations:
 * @property Vehicle $vehicle
 * @property Driver $driver
 */
class AlertOverspeed extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return AlertOverspeed the static model class
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
		return 'alert_overspeed';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vehicle_id, date', 'required'),
			array('vehicle_id, time_one, time_two, time_three, time_four, driver_id', 'numerical', 'integerOnly'=>true),
			array('distance_one, distance_two, distance_three, distance_four', 'numerical'),
			array('lat, lon', 'length', 'max'=>9),
			array('gps_datetime', 'length', 'max'=>14),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vehicle_id, distance_one, time_one, distance_two, time_two, distance_three, time_three, distance_four, time_four, driver_id, date, lat, lon, gps_datetime', 'safe', 'on'=>'search'),
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
			'vehicle_id' => 'Vehicle',
			'distance_one' => 'Distance One',
			'time_one' => 'Time One',
			'distance_two' => 'Distance Two',
			'time_two' => 'Time Two',
			'distance_three' => 'Distance Three',
			'time_three' => 'Time Three',
			'distance_four' => 'Distance Four',
			'time_four' => 'Time Four',
			'driver_id' => 'Driver',
			'date' => 'Date',
			'lat' => 'Lat',
			'lon' => 'Lon',
			'gps_datetime' => 'Gps Datetime',
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
		$criteria->compare('distance_one',$this->distance_one);
		$criteria->compare('time_one',$this->time_one);
		$criteria->compare('distance_two',$this->distance_two);
		$criteria->compare('time_two',$this->time_two);
		$criteria->compare('distance_three',$this->distance_three);
		$criteria->compare('time_three',$this->time_three);
		$criteria->compare('distance_four',$this->distance_four);
		$criteria->compare('time_four',$this->time_four);
		$criteria->compare('driver_id',$this->driver_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('lat',$this->lat,true);
		$criteria->compare('lon',$this->lon,true);
		$criteria->compare('gps_datetime',$this->gps_datetime,true);
                $criteria->join = 'LEFT JOIN vehicle AS v ON v.id=t.vehicle_id';
		if (Yii::app()->user->level < 1000){
                        $company_id=Yii::app()->user->company_id;
			$criteria->addCondition("v.company_id=$company_id");
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}