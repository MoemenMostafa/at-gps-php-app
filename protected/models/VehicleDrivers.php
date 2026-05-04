<?php

/**
 * This is the model class for table "vehicle_drivers".
 *
 * The followings are the available columns in table 'vehicle_drivers':
 * @property integer $id
 * @property integer $vehicle_id
 * @property integer $driver_id
 * @property string $from
 * @property string $to
 *
 * The followings are the available model relations:
 * @property Driver $driver
 * @property Vehicle $vehicle
 */
class VehicleDrivers extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VehicleDrivers the static model class
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
		return 'vehicle_drivers';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vehicle_id, driver_id', 'required'),
			array('vehicle_id, driver_id', 'numerical', 'integerOnly'=>true),
			array('from, to', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vehicle_id, driver_id, from, to', 'safe', 'on'=>'search'),
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
			'driver' => array(self::BELONGS_TO, 'Driver', 'driver_id'),
			'vehicle' => array(self::BELONGS_TO, 'Vehicle', 'vehicle_id'),
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
			'driver_id' => 'Driver',
			'from' => 'From',
			'to' => 'To',
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
		$criteria->compare('driver_id',$this->driver_id);
		$criteria->compare('from',$this->from,true);
		$criteria->compare('to',$this->to,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}