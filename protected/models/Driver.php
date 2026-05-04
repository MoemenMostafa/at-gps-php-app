<?php

/**
 * This is the model class for table "driver".
 *
 * The followings are the available columns in table 'driver':
 * @property integer $id
 * @property string $name
 * @property string $dob
 * @property string $mobile
 * @property integer $company_id
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property VehicleDrivers[] $vehicleDrivers
 */
class Driver extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Driver the static model class
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
		return 'driver';
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
			array('name', 'length', 'max'=>45),
                        array('mobile', 'length', 'max'=>20),
                        array('ibutton', 'length', 'max'=>15),
			array('dob, mobile', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, dob, mobile, ibutton, company_id', 'safe', 'on'=>'search'),
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
			'vehicleDrivers' => array(self::HAS_MANY, 'VehicleDrivers', 'driver_id'),
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
			'dob' => 'Date of Birth',
                        'mobile' => 'Mobile',
                        'ibutton' => 'iButton Code',
			'company_id' => 'Company',
			'company.name' => 'Company',

		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($type="AR")
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('dob',$this->dob,true);
                $criteria->compare('mobile',$this->mobile,true);
                $criteria->compare('ibutton',$this->ibutton,true);
		$criteria->compare('company_id',$this->company_id);
		if (Yii::app()->user->level >=1000)
		{}else{
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
	
	public function getCompanyFilter() {
        $Criteria = new CDbCriteria();
        $Criteria->select = "id, name";
        $results = Company::model()->findAll($Criteria);
        $category_list = array();
        foreach ($results as $result) {
                $company_list[$result->id] = $result->id;
				$company_list[$result->id] = $result->name;
        }
        return $company_list;
    }
}