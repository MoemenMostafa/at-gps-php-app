<?php

/**
 * This is the model class for table "repairs".
 *
 * The followings are the available columns in table 'repairs':
 * @property integer $id
 * @property integer $vehicle_id
 * @property string $location
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Vehicle $vehicle
 */
class Repairs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Repairs the static model class
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
		return 'repairs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vehicle_id, location, description, start_date', 'required'),
			array('id, vehicle_id', 'numerical', 'integerOnly'=>true),
			array('location', 'length', 'max'=>255),
			array('description, note', 'length', 'max'=>1000),
                        array('note, end_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vehicle_id, location, description, start_date, end_date, note', 'safe', 'on'=>'search'),
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
			'location' => 'Location',
			'description' => 'Description',
			'start_date' => 'Start Date',
			'end_date' => 'End Date',
			'note' => 'Note',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('location',$this->location,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('start_date',$this->start_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('note',$this->note,true);
                $criteria->join = 'LEFT JOIN vehicle as v ON v.id=t.vehicle_id ';

		if (Yii::app()->user->level >=1000)
                    {
		}else{
                    $company_id=Yii::app()->user->company_id;
                    $criteria->addCondition("v.company_id = $company_id");
		}
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => $sort,
                        'pagination'=>false,
                        
		));
	}
}