<?php

/**
 * This is the model class for table "device_commands".
 *
 * The followings are the available columns in table 'device_commands':
 * @property integer $id
 * @property integer $device_type_id
 * @property string $name
 * @property string $command
 * @property integer $user_available
 *
 * The followings are the available model relations:
 * @property DeviceType $deviceType
 */
class DeviceCommands extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DeviceCommands the static model class
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
		return 'device_commands';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_type_id, name, command, user_available', 'required'),
			array('device_type_id', 'numerical', 'integerOnly'=>true),
			array('name, command', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, device_type_id, name, command, user_available', 'safe', 'on'=>'search'),
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
			'deviceType' => array(self::BELONGS_TO, 'DeviceType', 'device_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'deviceType.type_en' => 'Device Type',
			'name' => ' Command Name',
			'command' => 'Command',
                        'user_available' => 'Available for User',
                        'UserAvailable' => 'Available for User',
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
		$criteria->compare('device_type_id',$this->device_type_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('command',$this->command,true);
                $criteria->compare('user_available',$this->user_available);
                if (Yii::app()->user->level >=1000)
		{}else{
                    $criteria->addCondition("user_available = 1");
		}
                
                
                
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'defaultOrder' => array(
                               'device_type_id' => CSort::SORT_ASC
                            ),
                         ),
		));
	}
        
        public function getUserAvailable()
        {
                if ($this->user_available == 0) return 'No';
                if ($this->user_available == 1) return 'Yes';
        }
}