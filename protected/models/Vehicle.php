<?php

/**
 * This is the model class for table "vehicle".
 *
 * The followings are the available columns in table 'vehicle':
 * @property integer $id
 * @property integer $device_id
 * @property string $name
 * @property integer $serial
 * @property string $model
 * @property string $colour
 * @property integer $vehicle_type_id
 * @property integer $company_id
 * @property integer $odometer
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property Device $device
 * @property VehicleType $vehicleType
 * @property VehicleDrivers[] $vehicleDrivers
 */
class Vehicle extends CActiveRecord
{
	
        public $driverName;
        public $driverName_search;
        public $driverMobile;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Vehicle the static model class
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
		return 'vehicle';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vehicle_type_id, company_id, serial, model', 'required'),
			array('device_id, vehicle_type_id, company_id, odometer', 'numerical', 'integerOnly'=>true),
			array('serial', 'length' , 'max'=>11),
			array('name, model, colour', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, device_id, name, serial, model, colour, vehicle_type_id, company_id, driverName_search', 'safe', 'on'=>'search'),
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
			'device' => array(self::BELONGS_TO, 'Device', 'device_id'),
			'vehicleType' => array(self::BELONGS_TO, 'VehicleType', 'vehicle_type_id'),
			'vehicleDrivers' => array(self::HAS_MANY, 'VehicleDrivers', 'vehicle_id'),
			'latestPoints' => array(self::HAS_ONE, 'LatestPoints', array('device_id'=>'device_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'device_id' => 'Device',
			'name' => 'Name',
			'serial' => 'Vehicle No.',
			'model' => 'Model',
			'colour' => 'Colour',
			'vehicle_type_id' => 'Vehicle Type',
			'company_id' => 'Company',
                        'odometer' => 'Odometer',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($type = 'AR', $order = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.device_id',$this->device_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('serial',$this->serial);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('colour',$this->colour,true);
		$criteria->compare('vehicle_type_id',$this->vehicle_type_id);
                $criteria->compare('odometer',$this->odometer);
                if ($order){$criteria->order = 'serial+0, serial+0 <>0 DESC, serial';}
		if (Yii::app()->user->level >=1000)
		{$criteria->compare('company_id',$this->company_id);
		}else{
		$company_id=Yii::app()->user->company_id;
		$criteria->addCondition("t.company_id = $company_id");
		}

                // User Group Exceptions
                if (Yii::app()->user->id == 8){$criteria->addCondition("`device_id` = '1010001001'");}
                if (Yii::app()->user->id == 9){$criteria->addCondition("`device_id` = '1010000392' OR `device_id` = '1010000432'");}
                if (Yii::app()->user->id == 11){$criteria->addCondition("`device_id` = '1010001002'");}
                if (Yii::app()->user->id == 26){$criteria->addCondition("device_id = '1010006001' or device_id = '1010006002' or device_id = '1010006003' or device_id = '1010006005' or device_id = '1010006006' or device_id = '1010006007' or device_id = '1010006009' or device_id = '1010006024' or device_id = '1010006008'");}
				if (Yii::app()->user->id == 28){$criteria->addCondition("device_id = '1010006021' or device_id = '1010006004' or device_id = '1010006023'");}

                
                // if $type = AR return AR
                if ($type== "AR"){
					$criteria->with = array('latestPoints');
                    return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'attributes'=>array(
					'latestPoints.gps_datetime'=>array(
						'asc'=>'latestPoints.gps_datetime',
						'desc'=>'latestPoints.gps_datetime DESC',
					),
					'*',
				),
			),
			'pagination'=>array(
				'pageSize'=>100,
			),
		));
                }
                // if $type = list return array
                if ($type== "list"){
                   return $this->getCommandBuilder()
                                        ->createFindCommand($this->tableSchema, $criteria)
                                        ->queryAll();
                
                }
	}
        
                
        public function listVehicles()
        {	
			$userCompanyId = Yii::app()->user->company_id;
                        
			$criteria = new CDbCriteria(); $criteria->addCondition("`company_id` = $userCompanyId");
			//$criteriaAdmin = new CDbCriteria(); $criteriaAdmin->addCondition("vehicles.id > 0");

			if (Yii::app()->user->level >= 1000){
				$records = Vehicle::model()->findAll();
				}else{$records =  Vehicle::model()->findAll($criteria);}
			
                        return $records;
        }
	
	public function getSerialStyle()
	{
		$status = getStatus($this->latestPoints->gps_datetime, $this->latestPoints->last_connection);	
		return("<div style='color:{$status['color']}'>".$this->serial."</div>" );
		
	}

	protected function beforeDelete()
	{
		if (parent::beforeDelete()) {
			// Clean up vehicle history and relations
			VehicleDrivers::model()->deleteAll('vehicle_id = :id', array(':id' => $this->id));
			Trip::model()->deleteAll('vehicle_id = :id', array(':id' => $this->id));
			Repairs::model()->deleteAll('vehicle_id = :id', array(':id' => $this->id));
			MaintSetup::model()->deleteAll('vehicle_id = :id', array(':id' => $this->id));
			VehicleOdometerSnaps::model()->deleteAll('vehicle_id = :id', array(':id' => $this->id));
			VehicleOdometerSnapsToday::model()->deleteAll('vehicle_id = :id', array(':id' => $this->id));
			VehicleSpeedzone::model()->deleteAll('vehicle_id = :id', array(':id' => $this->id));
			Alert::model()->deleteAll('vehicle_id = :id', array(':id' => $this->id));
			AlertOverspeed::model()->deleteAll('vehicle_id = :id', array(':id' => $this->id));
			LatestPoints::model()->deleteAll('device_id = :id', array(':id' => $this->device_id));
			DeviceDetails::model()->deleteAll('device_id = :id', array(':id' => $this->device_id));
			
			// When a vehicle is removed, we remove the hardware (device) as well
			if ($this->device_id > 0) {
				$device = Device::model()->findByPk($this->device_id);
				if ($device) {
					$device->delete();
				}
			}

			// Safely drop the vehicle_points table if it exists
			Yii::app()->db->createCommand("DROP TABLE IF EXISTS `vehicle_points_{$this->id}`")->query();
			
			return true;
		}
		return false;
	}
}