<?php

/**
 * This is the model class for table "maint_item_brand".
 *
 * The followings are the available columns in table 'maint_item_brand':
 * @property integer $id
 * @property string $name
 * @property integer $company_id
 * @property integer $maint_group_id
 *
 * The followings are the available model relations:
 * @property MaintItem[] $maintItems
 * @property Company $company
 */
class MaintItemBrand extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaintItemBrand the static model class
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
		return 'maint_item_brand';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, company_id, maint_group_id', 'required'),
			array('company_id, maint_group_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, company_id, maint_group_id', 'safe', 'on'=>'search'),
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
			'maintItems' => array(self::HAS_MANY, 'MaintItem', 'maint_item_brand_id'),
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
                        'maintGroup' => array(self::BELONGS_TO, 'MaintGroup', 'maint_group_id'),
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
			'company_id' => 'Company',
                        'company.name' => 'Company',
                        'maint_group_id' => 'Item Group',
                        'maintGroup.name' => 'Item Group',
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
		$criteria->compare('name',$this->name);
		$criteria->compare('company_id',$this->company_id);
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