<?php

/**
 * This is the model class for table "commands".
 *
 * The followings are the available columns in table 'commands':
 * @property integer $id
 * @property integer $device_commands_id
 * @property integer $device_id
 * @property integer $status
 * @property string $response
 * @property string $date_recorded
 * @property string $date_sent
 * @property string $date_response
 *
 * The followings are the available model relations:
 * @property DeviceCommands $deviceCommands
 * @property Device $device
 */
class Commands extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Commands the static model class
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
		return 'commands';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('device_commands_id, device_id', 'required'),
			array('device_commands_id, device_id, status', 'numerical', 'integerOnly'=>true),
			array('response', 'length', 'max'=>255),
			array('date_recorded, date_sent, date_response', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, device_commands_id, device_id, status, response, date_recorded, date_sent, date_response', 'safe', 'on'=>'search'),
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
			'deviceCommands' => array(self::BELONGS_TO, 'DeviceCommands', 'device_commands_id'),
			'device' => array(self::BELONGS_TO, 'Device', 'device_id'),
                        'vehicle' => array(self::HAS_ONE, 'Vehicle', array('device_id'=>'device_id')),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'device_commands_id' => 'Device Commands',
			'device_id' => 'Device',
                        'DeviceType.type_en' => 'Device Type',
			'status' => 'Status',
			'response' => 'Response',
			'date_recorded' => 'Date Recorded',
			'date_sent' => 'Sent Date ',
			'date_response' => 'Response Date ',
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
		$criteria->compare('device_commands_id',$this->device_commands_id);
		$criteria->compare('device_id',$this->device_id);
                if (Yii::app()->user->level >=1000)
		{}else{
                $criteria->join = 'LEFT JOIN device as d ON d.id = t.device_id';
                $criteria->join = 'LEFT JOIN device_commands as dc ON dc.id = t.device_commands_id';
		$company_id=Yii::app()->user->company_id;
		$criteria->addCondition("d.company_id = $company_id");

		}
  
		$criteria->compare('status',$this->status);
		$criteria->compare('response',$this->response,true);
		$criteria->compare('date_recorded',$this->date_recorded,true);
		$criteria->compare('date_sent',$this->date_sent,true);
		$criteria->compare('date_response',$this->date_response,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'defaultOrder' => array(
                               'id' => CSort::SORT_DESC
                            ),
                         ),
		));
	}
        
        public function getDateRecorded(){
            date_default_timezone_set('GMT');
            $dateRecorded = DateTime::createFromFormat('Y-m-d H:i:s', $this->date_recorded);
			if($dateRecorded){
				$dateRecorded->setTimezone(new DateTimeZone(Yii::app()->user->timezone));
				return $dateRecorded->format('Y-m-d h:i:s a');
			}

	}
        public function getDateSent(){
            date_default_timezone_set('GMT');
            $dateRecorded = DateTime::createFromFormat('Y-m-d H:i:s', $this->date_sent);
			if($dateRecorded){
				$dateRecorded->setTimezone(new DateTimeZone(Yii::app()->user->timezone));
				return $dateRecorded->format('Y-m-d h:i:s a');
			}

	}
        public function getDateResponse(){
            date_default_timezone_set('GMT');
            $dateRecorded = DateTime::createFromFormat('Y-m-d H:i:s', $this->date_response);
			if($dateRecorded){
				$dateRecorded->setTimezone(new DateTimeZone(Yii::app()->user->timezone));
				return $dateRecorded->format('Y-m-d h:i:s a');
			}

	}
        
        public function getStatus(){
            if ($this->status == 0){echo "Recorded";}
            if ($this->status == 1){echo "Sent";}
            if ($this->status == 2){echo "Responded";}

	}
        

    
}