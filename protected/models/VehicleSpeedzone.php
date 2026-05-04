<?php

/**
 * This is the model class for table "vehicle_speedzone_violation".
 *
 * The followings are the available columns in table 'vehicle_speedzone_violation':
 * @property string $id
 * @property integer $vehicle_id
 * @property integer $speed_zone_id
 * @property double $odometer
 * @property integer $max_speed
 * @property string $datetime
 */
class VehicleSpeedzone extends CActiveRecord
{

	public $speed_zone_name;
	public $serial;
	public $date;
	public $driver_name;
	public $start;
	public $end;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VehicleSpeedzone the static model class
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
		return 'vehicle_speedzone_violation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('speed_zone_id, datetime', 'required'),
			array('vehicle_id, speed_zone_id, max_speed', 'numerical', 'integerOnly'=>true),
			array('odometer', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vehicle_id, speed_zone_id, odometer, max_speed, datetime', 'safe', 'on'=>'search'),
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
			'speed_zone_id' => 'Speed Zone',
			'odometer' => 'Odometer',
			'max_speed' => 'Max Speed',
			'datetime' => 'Datetime',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($driverId, $datetimeRange)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('speed_zone_id',$this->speed_zone_id);
		$criteria->compare('odometer',$this->odometer);
		$criteria->compare('max_speed',$this->max_speed);
		$criteria->compare('datetime',$this->datetime,true);

		if (Yii::app()->user->level >=1000)
                    {
		}else{
                    $company_id=Yii::app()->user->company_id;
                    $criteria->addCondition("cp.id = $company_id");
		}

		if ($driverId){
			$criteria->select = array("t.vehicle_id, v.serial, t.odometer, sz.name as speed_zone_name, DATE(t.datetime) as date, t.datetime, DATE_FORMAT(CONVERT_TZ(t.datetime,'+00:00','+02:00'),'%h:%i:%s %p') as start, DATE_FORMAT(CONVERT_TZ(t.datetimeEnd,'+00:00','+02:00'),'%h:%i:%s %p') as end, t.max_speed, d.name as driver_name");
			$criteria->addCondition("(date(CONVERT_TZ(t.datetime,'+00:00','+02:00')) BETWEEN '{$datetimeRange['from']}' AND '{$datetimeRange['to']}') AND tr.driver_id = $driverId");
		}else{
			if ($datetimeRange['from']){
				$criteria->select = array("t.vehicle_id, v.serial, t.odometer, sz.name as speed_zone_name, DATE(t.datetime) as date, t.datetime, DATE_FORMAT(CONVERT_TZ(t.datetime,'+00:00','+02:00'),'%h:%i:%s %p') as start, DATE_FORMAT(CONVERT_TZ(t.datetimeEnd,'+00:00','+02:00'),'%h:%i:%s %p') as end,  t.max_speed, d.name as driver_name");
				$criteria->addCondition("(date(CONVERT_TZ(t.datetime,'+00:00','+02:00')) BETWEEN '{$datetimeRange['from']}' AND '{$datetimeRange['to']}') AND d.name is not null");
			}else{
				//$criteria->addCondition("vehicle_id = $vehicleId");
				//$criteria->select = array("t.vehicle_id");
				$criteria->addCondition("id = 'imposible'");
			}
		}

		$criteria->join = "LEFT JOIN vehicle as v ON v.id = t.vehicle_id
                          LEFT JOIN company as cp ON cp.id = v.company_id
                          LEFT JOIN trip as tr ON tr.vehicle_id = t.vehicle_id AND date(tr.from) <= date(t.datetime) AND (date(tr.to) >= date(t.datetime) OR date(tr.to) = '0000-00-00')
                          LEFT JOIN driver as d ON d.id = tr.driver_id
                          LEFT JOIN speed_zone as sz ON sz.id = t.speed_zone_id";


		//$criteria->group = "t.vehicle_id";

		$criteria->order = 't.datetime ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,
		));

	}
}