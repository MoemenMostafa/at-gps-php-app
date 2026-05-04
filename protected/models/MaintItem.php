<?php

/**
 * This is the model class for table "maint_item".
 *
 * The followings are the available columns in table 'maint_item':
 * @property integer $id
 * @property integer $maint_group_id
 * @property string $name
 * @property integer $maint_item_brand_id
 * @property integer $life
 * @property integer $company_id
 *
 * The followings are the available model relations:
 * @property Commands $company
 * @property MaintGroup $maintGroup
 * @property MaintItemBrand $maintItemBrand
 * @property MaintSetup[] $maintSetups
 */
class MaintItem extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MaintItem the static model class
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
		return 'maint_item';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('maint_group_id, name, maint_item_brand_id, life, company_id', 'required'),
			array('maint_group_id, maint_item_brand_id, life, company_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, maint_group_id, name, maint_item_brand_id, life, company_id', 'safe', 'on'=>'search'),
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
			'maintGroup' => array(self::BELONGS_TO, 'MaintGroup', 'maint_group_id'),
			'maintItemBrand' => array(self::BELONGS_TO, 'MaintItemBrand', 'maint_item_brand_id'),
			'maintSetups' => array(self::HAS_MANY, 'MaintSetup', 'maint_item_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'maint_group_id' => 'Item Group',
                        'maintGroup.name' => 'Item Group',
			'name' => 'Item Name',
			'maint_item_brand_id' => 'Item Brand',
                        'maintItemBrand.name' => 'Item Brand',
			'life' => 'Life Span(Km)',
			'company_id' => 'Company',
                        'company.name' => 'Company',
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
		$criteria->compare('maint_group_id',$this->maint_group_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('maint_item_brand_id',$this->maint_item_brand_id);
		$criteria->compare('life',$this->life);
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
        
        public function getGroup(){
            return $this->maintGroup->name; 
            
          
        }
}