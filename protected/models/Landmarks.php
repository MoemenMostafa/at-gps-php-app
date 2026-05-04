<?php

/**
 * This is the model class for table "landmarks".
 *
 * The followings are the available columns in table 'landmarks':
 * @property integer $id
 * @property integer $company_id
 * @property string $name
 * @property string $lat
 * @property string $long
 * @property string $icon
 *
 * The followings are the available model relations:
 * @property Company $company
 */
class Landmarks extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Landmarks the static model class
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
		return 'landmarks';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('company_id', 'required'),
			array('company_id', 'numerical', 'integerOnly'=>true),
			array('name, icon', 'length', 'max'=>255),
			array('lat, long', 'length', 'max'=>21),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, company_id, name, lat, long, icon', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'company_id' => 'Company',
			'name' => 'Name',
			'lat' => 'Lat',
			'long' => 'Long',
			'icon' => 'Icon',
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
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('lat',$this->lat,true);
		$criteria->compare('long',$this->long,true);
		$criteria->compare('icon',$this->icon,true);

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
}