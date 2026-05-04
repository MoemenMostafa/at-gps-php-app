<?php

/**
 * This is the model class for table "latest_points".
 *
 * The followings are the available columns in table 'latest_points':
 * @property integer $id
 * @property integer $device_id
 * @property string $gps_datetime
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
 * @property string $rtc_datetime
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
 * @property integer $last_connection
 */
class LatestPoints extends CActiveRecord
{
    
        public $driverName;
        public $driverMobile;
        public $routeName;
        public $phptimezone;
        public $tripId;
        public $repairId;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LatestPoints the static model class
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
		return 'latest_points';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_id, gps_datetime, longitude, latitude, speed, direction, altitude, satellites, messageID, input_status, output_status, analog_input1, analog_input2, rtc_datetime, mileage', 'required'),
			array('device_id, speed, altitude, satellites, messageID, input_status, output_status, mileage, speed_cam, rpm_cam, engine_temp_cam, fuel_level_cam, fuel_rate_cam, fuel_temp_cam, oil_press_cam, acc_pedal_cam, axel_weight_cam, odometer_cam', 'numerical', 'integerOnly'=>true),
			array('gps_datetime, rtc_datetime', 'length', 'max'=>14),
			array('longitude, latitude', 'length', 'max'=>9),
			array('direction, analog_input1, analog_input2', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('device_id, gps_datetime, longitude, latitude, speed, direction, altitude, satellites, messageID, input_status, output_status, analog_input1, analog_input2, rtc_datetime, mileage, speed_cam, rpm_cam, engine_temp_cam, fuel_level_cam, fuel_rate_cam, fuel_temp_cam, oil_press_cam, acc_pedal_cam, axel_weight_cam, odometer_cam', 'safe', 'on'=>'search'),
			array('vehicle_serial', 'safe', 'on'=>'search'),
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
			//'device' => array(self::HAS_ONE, 'Device', 'id'),
			'vehicle' => array(self::HAS_ONE, 'Vehicle',array('device_id'=>'device_id')),
		);														
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'device_id' => 'Device',
			'gps_datetime' => 'Gps Datetime',
			'vehicle_serial' => 'Vehicle #',
			'longitude' => 'Longitude',
			'latitude' => 'Latitude',
			'speed' => 'Speed',
			'direction' => 'Direction',
			'altitude' => 'Altitude',
			'satellites' => 'Satellites',
			'messageID' => 'Message',
			'input_status' => 'Ignition',
			'output_status' => 'Output Status',
			'analog_input1' => 'Analog Input1',
			'analog_input2' => 'Analog Input2',
			'rtc_datetime' => 'Rtc Datetime',
			'mileage' => 'Mileage',
			'speed_cam' => 'Speed',
			'rpm_cam' => 'Rpm',
			'engine_temp_cam' => 'Engine Temp &#8451;',
			'fuel_level_cam' => 'Fuel Level %',
			'fuel_rate_cam' => 'Fuel Rate %',
			'fuel_temp_cam' => 'Fuel Temp &#8451;',
			'oil_press_cam' => 'Oil Press bar',
			'acc_pedal_cam' => 'Acc Pedal %',
			'axel_weight_cam' => 'Axel Weight',
			'odometer_cam' => 'Odometer Km',
			'last_connection' => 'Last Connection',
			'ignition_time' => 'Ignition Time',
			'address' => 'Address'
		);
	}
	
	// Added RelatedSearchBehavior.
	public function behaviors() {
	    return array(
	            'relatedsearch'=>array(
						 'class'=>'RelatedSearchBehavior',
						 'relations'=>array(
	                            'vehicle_serial'=>'vehicle.serial',
	                    ),
	            ),
	            );
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($userData,$vehicleInfo = false, $device_id = false, $tripFilter = false, $driverFilter = false, $maintenanceFilter = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
                $sort = new CSort();
                $sort->attributes = array(

                            'vehicle.serial'=> array(
                                
                                'desc' => 'serial desc',
                                'asc' => 'serial',
                                'default'=>'asc',
                            ),
                            '*',
                      );
            
            
		$criteria=new CDbCriteria;
		if ($userData->userType->level <1000){
			$criteria->addCondition("v.company_id={$userData->company_id}");
			$notAdmin = "AND v.company_id=".$userData->company_id;
		}
		// User Group Exceptions
		if ($userData->id ==8){
			$criteria->addCondition("t.device_id='1010001001'");
		}
		if ($userData->id ==9){
			$criteria->addCondition("t.device_id='1010000392' OR t.device_id='1010000432'");
		}
		if ($userData->id ==11){
			$criteria->addCondition("t.device_id='1010001002'");
		}
		if ($userData->id ==26){
			$criteria->addCondition("t.device_id = '1010006001' or t.device_id = '1010006002' or t.device_id = '1010006003' or t.device_id = '1010006005' or t.device_id = '1010006006' or t.device_id = '1010006007' or t.device_id = '1010006009' or t.device_id = '1010006024' or t.device_id = '1010006008'");
		}
		if ($userData->id ==28){
			$criteria->addCondition("t.device_id = '1010006021' or t.device_id = '1010006004' or t.device_id = '1010006023'");
		}
		$criteria->order = 'serial+0, serial+0 <>0 DESC, serial' ;
		/*$criteria->compare('device_id',$this->device_id);
		$criteria->compare('gps_datetime',$this->gps_datetime,true);
		$criteria->compare('longitude',$this->longitude,true);
		$criteria->compare('latitude',$this->latitude,true);
		$criteria->compare('speed',$this->speed);
		$criteria->compare('direction',$this->direction,true);
		$criteria->compare('altitude',$this->altitude);
		$criteria->compare('satellites',$this->satellites);
		$criteria->compare('messageID',$this->messageID);
		$criteria->compare('input_status',$this->input_status);
		$criteria->compare('output_status',$this->output_status);
		$criteria->compare('analog_input1',$this->analog_input1,true);
		$criteria->compare('analog_input2',$this->analog_input2,true);
		$criteria->compare('rtc_datetime',$this->rtc_datetime,true);
		$criteria->compare('mileage',$this->mileage);
		$criteria->compare('speed_cam',$this->speed_cam);
		$criteria->compare('rpm_cam',$this->rpm_cam);
		$criteria->compare('engine_temp_cam',$this->engine_temp_cam);
		$criteria->compare('fuel_level_cam',$this->fuel_level_cam);
		$criteria->compare('fuel_rate_cam',$this->fuel_rate_cam);
		$criteria->compare('fuel_temp_cam',$this->fuel_temp_cam);
		$criteria->compare('oil_press_cam',$this->oil_press_cam);
		$criteria->compare('acc_pedal_cam',$this->acc_pedal_cam);
		$criteria->compare('axel_weight_cam',$this->axel_weight_cam);
		$criteria->compare('odometer_cam',$this->odometer_cam);*/

		//return $this->relatedSearch($criteria,array('pagination'=>false,'sort' => $sort));
                
                if ($vehicleInfo){
                    $now = date('Y-m-d H:i:s');
                    $criteria->join = "
                            LEFT JOIN vehicle AS v ON v.device_id=t.device_id
                            LEFT JOIN trip AS tr ON tr.vehicle_id = v.id AND tr.from < '$now' AND (tr.to > '$now' OR tr.to = 0)
                            LEFT JOIN route AS r ON r.id = tr.route_id
                            LEFT JOIN driver AS dr ON dr.id = tr.driver_id
                            LEFT JOIN company AS c ON c.id = v.company_id
                            LEFT JOIN timezone AS time ON time.id = c.timezone_id
                            ";
                    
                      $criteria->addCondition("t.device_id =  '$device_id'"); 
                      $criteria->select = array("t.*", "dr.name AS driverName", "time.phptimezone" , "dr.mobile AS driverMobile", "r.name AS routeName");
                }else{
					$criteria->join = '
						LEFT JOIN vehicle AS v ON v.device_id=t.device_id '.$notAdmin.'
						LEFT JOIN trip AS tp ON tp.vehicle_id=v.id AND tp.from <= NOW() AND (tp.to > NOW() OR tp.to = 0)
						LEFT JOIN repairs AS r ON r.vehicle_id=v.id AND r.start_date <= NOW() AND (r.end_date > NOW() OR r.end_date = 0)
						';
					$criteria->select = array("t.*",  "tp.id AS tripId",  "r.id AS repairId");
				}

				$operator = 'and';

				if ($tripFilter){
					$criteria->addCondition('tp.from <= NOW() AND (tp.to > NOW() OR tp.to = 0)');
					$operator = 'or';
				}
				if ($driverFilter){
					$criteria->addCondition('tp.driver_id is not NULL',$operator);
					$operator = 'or';
				}
				if ($maintenanceFilter){
					$criteria->addCondition('r.id is not NULL',$operator);
				}

                
                    return new CActiveDataProvider($this, array(
                            'criteria'=>$criteria,
                            'pagination'=>false,
                            'sort' => $sort
                    ));
                
	}
}