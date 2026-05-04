<?php

/**
 * This is the model class for table "alert".
 *
 * The followings are the available columns in table 'alert':
 * @property integer $id
 * @property integer $type
 * @property integer $vehicle_points_id
 * @property integer $vehicle_id
 * @property integer $value
 * @property integer $max_value
 * @property integer $status
 * @property integer $user_id
 * @property string $first_occurrence
 * @property string $last_occurrence
 * @property integer $counter
 *
 * The followings are the available model relations:
 * @property Vehicle $vehicle
 * @property LatestAlerts[] $latestAlerts
 */
class Alert extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Alert the static model class
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
		return 'alert';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('type, vehicle_id, max_value, first_occurrence, counter', 'required'),
			array('type, vehicle_points_id, vehicle_id, value, max_value, status, user_id, counter', 'numerical', 'integerOnly'=>true),
			array('last_occurrence', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, type, vehicle_points_id, vehicle_id, value, max_value, status, user_id, first_occurrence, last_occurrence, counter', 'safe', 'on'=>'search'),
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
			'latestAlerts' => array(self::HAS_MANY, 'LatestAlerts', 'alert_id'),
			'users' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'type' => 'Type',
			'vehicle_points_id' => 'Vehicle Points',
			'vehicle_id' => 'Vehicle',
			'value' => 'Value',
			'max_value' => 'Max Value',
			'status' => 'Status',
                        'Status' => 'Check',
			'user_id' => 'Checked By',
                        'users.fullname' => 'Checked By',
			'first_occurrence' => 'First Occurrence',
			'last_occurrence' => 'Last Occurrence',
			'counter' => 'Counter',
                        'duration' => 'Duration (min.)',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($period = FALSE,$checkStatus = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('type',$this->type);
		$criteria->compare('vehicle_points_id',$this->vehicle_points_id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('value',$this->value);
		$criteria->compare('max_value',$this->max_value);
		$criteria->compare('status',$this->status);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('first_occurrence',$this->first_occurrence,true);
		$criteria->compare('last_occurrence',$this->last_occurrence,true);
		$criteria->compare('counter',$this->counter);
		$criteria->join = 'LEFT JOIN vehicle AS v ON v.id=t.vehicle_id';
                
		if(!Yii::app()->user->isAdmin()){
		$company_id=Yii::app()->user->company_id;
		$criteria->addCondition("v.company_id = $company_id");
              
                }
                if ($period){
                   $criteria->addCondition("t.last_occurrence > DATE_SUB( now(), INTERVAL $period MINUTE) ");
                   $criteria->order='t.last_occurrence DESC';
                   $this->getAlertUserConditions($criteria);
                   
                }
                
                if ($checkStatus){
                    $criteria->addCondition("t.status = 0");
                }

			// User Group Exceptions
			if (Yii::app()->user->id == 8){$criteria->addCondition("`device_id` = '1010001001'");}
			if (Yii::app()->user->id == 9){$criteria->addCondition("`device_id` = '1010000392' OR `device_id` = '1010000432'");}
			if (Yii::app()->user->id == 11){$criteria->addCondition("`device_id` = '1010001002'");}
			if (Yii::app()->user->id == 26){$criteria->addCondition("device_id = '1010006001' or device_id = '1010006002' or device_id = '1010006003' or device_id = '1010006005' or device_id = '1010006006' or device_id = '1010006007' or device_id = '1010006009' or device_id = '1010006024' or device_id = '1010006008'");}
			if (Yii::app()->user->id == 28){$criteria->addCondition("device_id = '1010006021' or device_id = '1010006004' or device_id = '1010006023'");}



		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>false
                        ));  
                
	}
	
	public function getAlertType(){
			switch ($this->type){
				case 1:
					return 'Geofence';
				break;
				
				case 2:
					return 'Speeding';
				break;
				
				case 3:
					return 'RPM';
				break;
				
				case 4:
					return 'Fuel Temp.';
				break;
				
				case 5:
					return 'Oil Pressure';
				break;
				
				case 6:
					return 'Engine Temp.';
				break;
				
				case 7:
					return 'Fuel Level';
				break;
				
				case 8:
					return 'Fuel Rate';
				break;
				
				case 9:
					return 'Acc. Pedal';
				break;
			}
	}
	public function getStatus(){
			switch ($this->status){
				case 0:
					return false;
				break;
				
				case 1:
					return true;
				break;
				
				case 2:
					return 'Archived';
				break;
			}
	}
        public function getDuration(){
            $diff = round(((strtotime($this->last_occurrence) - strtotime($this->first_occurrence))/60)+0.5);
            $duration = round($this->counter/6);
            if ($diff>0){
            $persent = round($duration/$diff * 100);
            }else{
               $persent = 0; 
            }
            if ($persent >= 75 && $duration > 5){
            return "<div style='color:red'><strong>".$duration." min / ".$diff." min (".$persent."% violation)</strong></div>";
            }else{
                return $duration." min / ".$diff." min (".$persent."% violation)";
            }
	}
        

        

        
        private function getAlertUserConditions($criteria){

                   $userAlertParameters = UserSettings::model()->findByPK(Yii::app()->user->getId());
                   $operator = "and";
                    if ($userAlertParameters->geofence == 1){$criteria->addSearchCondition("t.type", "1", true, $operator);$operator="or";$this->getCompanyIdSQLCondiction($criteria);};
                    if ($userAlertParameters->overspeed == 1){$criteria->addSearchCondition("t.type", "2", true, $operator);$operator="or";$criteria->addCondition("t.value >= $userAlertParameters->overspeed_SoundAlertValue", "and");$this->getCompanyIdSQLCondiction($criteria);};
                    if ($userAlertParameters->rpm == 1){$criteria->addSearchCondition("t.type", "3", true, $operator);$operator="or";$criteria->addCondition("t.value >= $userAlertParameters->rpm_SoundAlertValue", "and");$this->getCompanyIdSQLCondiction($criteria);};
                    if ($userAlertParameters->fueltemp == 1){$criteria->addSearchCondition("t.type", "4", true, $operator);$operator="or";$criteria->addCondition("t.value >= $userAlertParameters->fueltemp_SoundAlertValue", "and");$this->getCompanyIdSQLCondiction($criteria);};
                    if ($userAlertParameters->oilpres == 1){$criteria->addSearchCondition("t.type", "5", true, $operator);$operator="or";$criteria->addCondition("t.value >= $userAlertParameters->oilpres_SoundAlertValue", "and");$this->getCompanyIdSQLCondiction($criteria);};
                    if ($userAlertParameters->engtemp == 1){$criteria->addSearchCondition("t.type", "6", true, $operator);$operator="or";$criteria->addCondition("t.value >= $userAlertParameters->engtemp_SoundAlertValue", "and");$this->getCompanyIdSQLCondiction($criteria);};
                    if ($userAlertParameters->fuellevel == 1){$criteria->addSearchCondition("t.type", "7", true, $operator);$operator="or";$criteria->addCondition("t.value >= $userAlertParameters->fuelrate_SoundAlertValue", "and");$this->getCompanyIdSQLCondiction($criteria);};
                    if ($userAlertParameters->fuelrate == 1){$criteria->addSearchCondition("t.type", "8", true, $operator);$operator="or";$criteria->addCondition("t.value >= $userAlertParameters->fuelrate_SoundAlertValue", "and");$this->getCompanyIdSQLCondiction($criteria);};
                    if ($userAlertParameters->accpedal == 1){$criteria->addSearchCondition("t.type", "9", true, $operator);$operator="or";$criteria->addCondition("t.value >= $userAlertParameters->accpedal_SoundAlertValue", "and");$this->getCompanyIdSQLCondiction($criteria);};
                    //IF all Alert parameters are off
                    if ($operator === "and"){
                        $criteria->addSearchCondition("t.type", "0", true, $operator);
                    }
                    return $criteria;
        }
        
        private function getCompanyIdSQLCondiction($criteria){
                 if(!Yii::app()->user->isAdmin()){
                    $company_id=Yii::app()->user->company_id;
                    $criteria->addCondition("v.company_id = $company_id");
                  } 
        }
}