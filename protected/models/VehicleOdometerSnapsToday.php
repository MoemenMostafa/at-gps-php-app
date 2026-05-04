<?php

/**
 * This is the model class for table "vehicle_odometer_snaps_today".
 *
 * The followings are the available columns in table 'vehicle_odometer_snaps_today':
 * @property integer $id
 * @property integer $vehicle_id
 * @property double $odometer
 * @property string $dateTime
 */
class VehicleOdometerSnapsToday extends CActiveRecord
{
	public $vehicle_number;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VehicleOdometerSnapsToday the static model class
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
		return 'vehicle_odometer_snaps_today';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vehicle_id, odometer, dateTime', 'required'),
			array('vehicle_id', 'numerical', 'integerOnly'=>true),
			array('odometer', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vehicle_id, odometer, dateTime', 'safe', 'on'=>'search'),
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
			'odometer' => 'Odometer',
			'dateTime' => 'Date Time',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('odometer',$this->odometer);
		$criteria->compare('dateTime',$this->dateTime,true);

		if (Yii::app()->user->level >=1000)
                    {$criteria->compare('company_id',$this->company_id);
		}else{
                    $company_id=Yii::app()->user->company_id;
                    $criteria->addCondition("company_id = $company_id");
		}
		 // if $type = AR return AR
                if ($type== "AR"){
                    return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
                }
                // if $type = list return array
                if ($type== "list"){
                   return $this->getCommandBuilder()
                                        ->createFindCommand($this->tableSchema, $criteria)
                                        ->queryAll();
                
                }
	}

	public function searchDetails($distance)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('odometer',$this->odometer);
		$criteria->compare('dateTime',$this->dateTime,true);

		$company_id=Yii::app()->user->company_id;

		if (Yii::app()->user->level >=1000)
		{
		}else{
			$company_id=Yii::app()->user->company_id;
			$criteria->addCondition("cp.id = $company_id");
		}
		if(!$distance) $distance = 50;

		$criteria->addCondition("t.odometer > $distance");

		$criteria->join = "LEFT JOIN vehicle as v ON v.id = t.vehicle_id
						   LEFT JOIN company as cp ON cp.id = v.company_id";
		$criteria->select = "t.*, v.serial as vehicle_number";

		$criteria->order = 'v.serial+0, v.serial+0 <>0 DESC, v.serial';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false,));
	}
}