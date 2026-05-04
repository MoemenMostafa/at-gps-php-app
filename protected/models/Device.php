<?php

/**
 * This is the model class for table "device".
 *
 * The followings are the available columns in table 'device':
 * @property integer $id
 * @property string $id
 * @property integer $device_type_id
 *
 * The followings are the available model relations:
 * @property DeviceType $deviceType
 * @property Vehicle[] $vehicles
 */
class Device extends CActiveRecord
{
	public $vehicle_serial_search;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Device the static model class
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
		return 'device';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, device_type_id, company_id', 'required'),
			array('device_type_id', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, server_ip, server_port, device_type_id, company.name, vehicle_serial_search', 'safe', 'on'=>'search'),
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
			'deviceType' => array(self::BELONGS_TO, 'DeviceType', 'device_type_id'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'vehicles' => array(self::HAS_MANY, 'Vehicle', 'device_id'),
			'deviceDetails' => array(self::HAS_MANY, 'DeviceDetails', 'device_id'),
			'latestPoint' => array(self::HAS_ONE, 'LatestPoints', 'device_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'Device ID',
			'device_type_id' => 'Device Type',
			'deviceType.name' => 'Device Type',
			'vehicles.name' => 'Vehicle Name',
			'vehicles.serial' => 'Vehicle Plates',
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('server_ip',$this->server_ip);
		$criteria->compare('server_port',$this->server_port);
		$criteria->compare('device_type_id',$this->device_type_id);
		$criteria->compare('t.company_id',$this->company_id);
		if (Yii::app()->user->level >=1000)
		{}else{
		$company_id=Yii::app()->user->company_id;
		$criteria->addCondition("t.company_id = $company_id");
		}

		$criteria->with = array('vehicles', 'latestPoint');
		$criteria->together = true;
		if (strtolower($this->vehicle_serial_search) === 'unassigned') {
			$criteria->addCondition('vehicles.id IS NULL');
		} else {
			$criteria->compare('vehicles.serial', $this->vehicle_serial_search, true);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'attributes'=>array(
					'vehicle_serial_search'=>array(
						'asc'=>'vehicles.serial',
						'desc'=>'vehicles.serial DESC',
					),
					'latestPoint.gps_datetime'=>array(
						'asc'=>'latestPoint.gps_datetime',
						'desc'=>'latestPoint.gps_datetime DESC',
					),
					'*',
				),
			),
			'pagination' => ['pagesize' => 100]
		));
	}
        
        public function listDevices()
        {	
			$userCompanyId = Yii::app()->user->company_id;
                        
			$criteria = new CDbCriteria(); $criteria->addCondition("`company_id` = $userCompanyId");
			//$criteriaAdmin = new CDbCriteria(); $criteriaAdmin->addCondition("vehicles.id > 0");

			if (Yii::app()->user->level >= 1000){
				$records = Device::model()->findAll();
				}else{$records =  Device::model()->findAll($criteria);}
			
                        return $records;
        }

	protected function beforeDelete()
	{
		if (parent::beforeDelete()) {
			// Delete associated records to satisfy foreign key constraints
			Commands::model()->deleteAll('device_id = :id', array(':id' => $this->id));
			LatestPoints::model()->deleteAll('device_id = :id', array(':id' => $this->id));
			DeviceDetails::model()->deleteAll('device_id = :id', array(':id' => $this->id));
			
			// Unlink vehicles instead of deleting them
			Vehicle::model()->updateAll(array('device_id' => null), 'device_id = :id', array(':id' => $this->id));
			
			return true;
		}
		return false;
	}
}