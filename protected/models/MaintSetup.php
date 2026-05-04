<?php

/**
 * This is the model class for table "maint_setup".
 *
 * The followings are the available columns in table 'maint_setup':
 * @property integer $id
 * @property integer $maint_item_id
 * @property integer $vehicle_id
 * @property string $date
 * @property integer $odometer
 * @property integer $installed
 *
 * The followings are the available model relations:
 * @property Vehicle $vehicle
 * @property MaintItem $maintItem
 */
class MaintSetup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaintSetup the static model class
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
		return 'maint_setup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('maint_item_id, vehicle_id, date, odometer', 'required'),
			array('maint_item_id, vehicle_id, odometer, installed', 'numerical',  'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, maint_item_id, vehicle_id, date, odometer, installed', 'safe', 'on'=>'search'),
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
			'maintItem' => array(self::BELONGS_TO, 'MaintItem', 'maint_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'maint_item_id' => 'Item',
                        'maintItem.name' => 'Item',
                        'maintItem.maintItemBrand.name' =>'Brand',
                        'maintItem.maintGroup.name' =>'Group',
			'vehicle_id' => 'Vehicle',
                        'vehicle.seial' => 'Vehicle',
			'date' => 'Maintenance Date',
			'odometer' => 'Odometer',
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
		$criteria->compare('maint_item_id',$this->maint_item_id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('odometer',$this->odometer);
                $criteria->join = "LEFT JOIN vehicle as v on v.id=t.vehicle_id";
                if (Yii::app()->user->level >=1000){ 
                }else{
                    $criteria->addCondition("v.company_id=".Yii::app()->user->company_id);
                }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        Public function getOdometerKM(){
            return $this->odometer/1000;
            
        }
}