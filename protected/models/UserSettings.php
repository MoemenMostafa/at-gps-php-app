<?php

/**
 * This is the model class for table "user_settings".
 *
 * The followings are the available columns in table 'user_settings':
 * @property integer $id
 * @property integer $geofence
 * @property integer $overspeed
 * @property integer $overspeed_value
 * @property integer $rpm
 * @property integer $rpm_value
 * @property integer $fueltemp
 * @property integer $fueltemp_value
 * @property integer $oilpres
 * @property integer $oilpres_value
 * @property integer $engtemp
 * @property integer $engtemp_value
 * @property integer $fuellevel
 * @property integer $fuellevel_value
 * @property integer $fuelrate
 * @property integer $fuelrate_value
 * @property integer $accpedal
 * @property integer $accpedal_value
 *
 * The followings are the available model relations:
 * @property User $id0
 */
class UserSettings extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserSettings the static model class
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
		return 'user_settings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, geofence, overspeed, rpm, fueltemp, oilpres, engtemp, fuellevel, fuelrate, accpedal, overspeed_SoundAlertValue, rpm_SoundAlertValue, fueltemp_SoundAlertValue, oilpres_SoundAlertValue, engtemp_SoundAlertValue, fuellevel_SoundAlertValue, fuelrate_SoundAlertValue, accpedal_SoundAlertValue', 'required'),
			array('id, geofence, overspeed, rpm, fueltemp, oilpres, engtemp, fuellevel, fuelrate, accpedal, overspeed_SoundAlertValue, rpm_SoundAlertValue, fueltemp_SoundAlertValue, oilpres_SoundAlertValue, engtemp_SoundAlertValue, fuellevel_SoundAlertValue, fuelrate_SoundAlertValue, accpedal_SoundAlertValue', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, geofence, overspeed, rpm, fueltemp, oilpres, engtemp, fuellevel, fuelrate, accpedal, overspeed_SoundAlertValue, rpm_SoundAlertValue, fueltemp_SoundAlertValue, oilpres_SoundAlertValue, engtemp_SoundAlertValue, fuellevel_SoundAlertValue, fuelrate_SoundAlertValue, accpedal_SoundAlertValue', 'safe', 'on'=>'search'),
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
			'id0' => array(self::BELONGS_TO, 'User', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'geofence' => 'Geofence',
			'overspeed' => 'Overspeed',
			'rpm' => 'Rpm',
			'fueltemp' => 'Fuel temp.',
			'oilpres' => 'Oilpres',
			'engtemp' => 'Eng. temp.',
			'fuellevel' => 'Fuel level',
			'fuelrate' => 'Fuel rate',
			'accpedal' => 'Acceleration',
                    	'overspeed_SoundAlertValue' => 'SoundAlertValue',
			'rpm_SoundAlertValue' => 'SoundAlertValue',
			'fueltemp_SoundAlertValue' => 'SoundAlertValue',
			'oilpres_SoundAlertValue' => 'SoundAlertValue',
			'engtemp_SoundAlertValue' => 'SoundAlertValue',
			'fuellevel_SoundAlertValue' => 'SoundAlertValue',
			'fuelrate_SoundAlertValue' => 'SoundAlertValue',
			'accpedal_SoundAlertValue' => 'SoundAlertValue',
                    
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
		$criteria->compare('geofence',$this->geofence);
		$criteria->compare('overspeed',$this->overspeed);
		$criteria->compare('rpm',$this->rpm);
		$criteria->compare('fueltemp',$this->fueltemp);
		$criteria->compare('oilpres',$this->oilpres);
		$criteria->compare('engtemp',$this->engtemp);
		$criteria->compare('fuellevel',$this->fuellevel);
		$criteria->compare('fuelrate',$this->fuelrate);
		$criteria->compare('accpedal',$this->accpedal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}