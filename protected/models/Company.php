<?php

/**
 * This is the model class for table "company".
 *
 * The followings are the available columns in table 'company':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property integer $country_id
 * @property integer $timezone_id
 * @property integer $overspeed_value
 * @property integer $rpm_value
 * @property integer $fueltemp_value
 * @property integer $oilpres_value
 * @property integer $engtemp_value
 * @property integer $fuellevel_value
 * @property integer $fuelrate_value
 * @property integer $accpedal_value
 *
 * The followings are the available model relations:
 * @property Country $country
 * @property Timezone $timezone
 * @property Device[] $devices
 * @property Driver[] $drivers
 * @property Route[] $routes
 * @property Trip[] $trips
 * @property User[] $users
 * @property Vehicle[] $vehicles
 */
class Company extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Company the static model class
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
		return 'company';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('country_id, timezone_id, geofence, overspeed_value, rpm_value, fueltemp_value, oilpres_value, engtemp_value, fuellevel_value, fuelrate_value, accpedal_value', 'required'),
			array('country_id, timezone_id, geofence, overspeed_value, rpm_value, fueltemp_value, oilpres_value, engtemp_value, fuellevel_value, fuelrate_value, accpedal_value', 'numerical', 'integerOnly'=>true),
			array('name, address', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, address, country_id, timezone_id, geofence, overspeed_value, rpm_value, fueltemp_value, oilpres_value, engtemp_value, fuellevel_value, fuelrate_value, accpedal_value', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'Country', 'country_id'),
			'timezone' => array(self::BELONGS_TO, 'Timezone', 'timezone_id'),
			'devices' => array(self::HAS_MANY, 'Device', 'company_id'),
			'drivers' => array(self::HAS_MANY, 'Driver', 'company_id'),
			'routes' => array(self::HAS_MANY, 'Route', 'company_id'),
			'trips' => array(self::HAS_MANY, 'Trip', 'company_id'),
			'users' => array(self::HAS_MANY, 'User', 'company_id'),
			'vehicles' => array(self::HAS_MANY, 'Vehicle', 'company_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'address' => 'Address',
			'country_id' => 'Country',
			'country.name' => 'Country',
			'timezone_id' => 'Timezone',
			'geofence' => 'Geofence',
			'overspeed_value' => 'Overspeed Value',
			'rpm_value' => 'Rpm Value',
			'fueltemp_value' => 'Fueltemp Value',
			'oilpres_value' => 'Oilpres Value',
			'engtemp_value' => 'Engtemp Value',
			'fuellevel_value' => 'Fuellevel Value',
			'fuelrate_value' => 'Fuelrate Value',
			'accpedal_value' => 'Accpedal Value',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('timezone_id',$this->timezone_id);
		$criteria->compare('overspeed_value',$this->overspeed_value);
		$criteria->compare('rpm_value',$this->rpm_value);
		$criteria->compare('fueltemp_value',$this->fueltemp_value);
		$criteria->compare('oilpres_value',$this->oilpres_value);
		$criteria->compare('engtemp_value',$this->engtemp_value);
		$criteria->compare('fuellevel_value',$this->fuellevel_value);
		$criteria->compare('fuelrate_value',$this->fuelrate_value);
		$criteria->compare('accpedal_value',$this->accpedal_value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}