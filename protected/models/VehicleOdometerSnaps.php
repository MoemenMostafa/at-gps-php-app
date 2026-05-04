<?php

/**
 * This is the model class for table "vehicle_odometer_snaps".
 *
 * The followings are the available columns in table 'vehicle_odometer_snaps':
 * @property integer $id
 * @property integer $vehicle_id
 * @property string $odometer
 * @property string $datetime
 *
 * The followings are the available model relations:
 * @property Vehicle $vehicle
 */

class VehicleOdometerSnaps extends CActiveRecord
{
	
    
        public $start;
        public $end;
        public $dist;
        public $date0;
        public $date1;
        public $date2;
        public $date3;
        public $date4;
        public $date5;
        public $date6;
        public $date7;
        public $date8;
        public $date9;
        public $date10;
        public $date11;
        public $date12;
        public $date13;
        public $date14;
        public $date15;
        public $date16;
        public $date17;
        public $date18;
        public $date19;
        public $date20;
        public $date21;
        public $date22;
        public $date23;
        public $date24;
        public $date25;
        public $date26;
        public $date27;
        public $date28;
        public $date29;
        public $date30;
        public $date31;
        public $date32;
        public $date33;
        public $date34;
        public $date35;
        public $date36;
        public $date37;
        public $date38;
        public $date39;
        public $date40;
        public $date41;
        public $date42;
        public $date43;
        public $date44;
        public $date45;
        public $date46;
        public $date47;
        public $date48;
        public $date49;
        public $date50;
        public $date51;
        public $date52;
        public $date53;
        public $date54;
        public $date55;
        public $date56;
        public $date57;
        public $date58;
        public $date59;
        public $date60;
        public $date61;
        public $date62;
        public $date63;
        public $date64;
        public $date65;
        public $date66;
        public $date67;
        public $date68;
        public $date69;
        public $date70;
        public $date71;
        public $date72;
        public $date73;
        public $date74;
        public $date75;
        public $date76;
        public $date77;
        public $date78;
        public $date79;
        public $date80;
        public $date81;
        public $date82;
        public $date83;
        public $date84;
        public $date85;
        public $date86;
        public $date87;
        public $date88;
        public $date89;
        public $date90;
        public $date91;
        public $date92;
        public $date93;
        public $date94;
        public $date95;
        public $date96;
        public $date97;
        public $date98;
        public $date99;

        
        /**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return VehicleOdometerSnaps the static model class
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
		return 'vehicle_odometer_snaps';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('vehicle_id, odometer, datetime', 'required'),
			array('vehicle_id', 'numerical', 'integerOnly'=>true),
			array('odometer', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, vehicle_id, odometer, datetime', 'safe', 'on'=>'search'),
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
			'odometer' => 'Odometer',
			'datetime' => 'Datetime',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
         * @param string $vehicleId vehicle ID or false for All vehicles.
         * @param array $datetimeRange time range in from of array($from,$to).
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($vehicleId = false, $datetimeRange = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('odometer',$this->odometer,true);
		$criteria->compare('datetime',$this->datetime,true);

		if (Yii::app()->user->level >=1000)
                    {
		}else{
                    $company_id=Yii::app()->user->company_id;
                    $criteria->addCondition("cp.id = $company_id");
		}
		 // if all vehicles are selected
                if ($vehicleId && is_numeric($vehicleId)){
                    //$criteria->select = array("t.vehicle_id", "(select odometer from vehicle_odometer_snaps AS b WHERE vehicle_id = $vehicleId AND date(datetime) = '{$datetimeRange['from']}' limit 1) as start" , "(select odometer from vehicle_odometer_snaps AS c WHERE vehicle_id = $vehicleId AND date(datetime) = '{$datetimeRange['to']}' limit 1) as end");
                    //$criteria->addCondition("vehicle_id = $vehicleId");
                    $criteria->select = array("t.vehicle_id, v.serial, sum(t.odometer) as dist");
                    $criteria->addCondition("(date(t.datetime) BETWEEN '{$datetimeRange['from']}' AND '{$datetimeRange['to']}') AND t.vehicle_id = $vehicleId");
                }else{
                    if ($datetimeRange['from']){
                        $criteria->select = array("t.vehicle_id, v.serial, sum(t.odometer)as dist");
                        $criteria->addCondition("(date(t.datetime) BETWEEN '{$datetimeRange['from']}' AND '{$datetimeRange['to']}')");
                    }else{
                        //$criteria->addCondition("vehicle_id = $vehicleId");
                        //$criteria->select = array("t.vehicle_id");
                        $criteria->addCondition("id = 'imposible'");
                    }
                }   
                
                $criteria->join = "LEFT JOIN vehicle as v ON v.id = t.vehicle_id
                                   LEFT JOIN company as cp ON cp.id = v.company_id";
                
                
                $criteria->group = "t.vehicle_id";
                
                $criteria->order = 'v.serial+0, v.serial+0 <>0 DESC, v.serial';
                
                
                /*else{
                    $criteria->select = array("t.vehicle_id", "(select odometer from vehicle_odometer_snaps AS b WHERE vehicle_id = t.vehicle_id AND date(datetime) = '{$datetimeRange['from']}') as start" , "(select odometer from vehicle_odometer_snaps AS c WHERE vehicle_id = t.vehicle_id AND date(datetime) = '{$datetimeRange['to']}') as end");
                    //print_r($criteria->select);
                    
                    }*/
                /*select a.vehicle_id, (select odometer from vehicle_odometer_snaps AS b WHERE vehicle_id = 5 AND date(datetime) = "2014-07-14") as start , (select odometer from vehicle_odometer_snaps AS c WHERE vehicle_id = 5 AND date(datetime) = "2014-07-20") as end from vehicle_odometer_snaps AS a
WHERE vehicle_id = 5
GROUP BY a.vehicle_id
                */
               return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,));
	}
        
    public function searchDetails($vehicleId = false, $datetimeRange = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('odometer',$this->odometer,true);
		$criteria->compare('datetime',$this->datetime,true);

		if (Yii::app()->user->level >=1000)
                    {
		}else{
                    $company_id=Yii::app()->user->company_id;
                    $criteria->addCondition("cp.id = $company_id");
		}
                if ($datetimeRange['from'] !== "//"){
                    $datesArray = $this->createDateRangeArray($datetimeRange['from'],$datetimeRange['to']);

                    // echo(implode($datesArray, ', '));
                    $selectString = "t.vehicle_id, v.serial, ";
                    foreach ($datesArray as $key => $date){
                        $selectString .= "MAX(IF(t.`datetime` like '$date%', t.`odometer`, NULL)) as date$key, ";
                    }
                    foreach ($datesArray as $key => $date){
                        $selectString .= "MAX(IF(t.`datetime` like '$date%', t.`odometer`, NULL)) +";
                    }
                    $selectString = substr($selectString, 0 , -1);
                    $selectString .=  " as dist";
                }
		 // if all vehicles are selected
                if ($vehicleId){
                    $criteria->select = array($selectString);
                    $criteria->addCondition("(date(t.datetime) BETWEEN '{$datetimeRange['from']}' AND '{$datetimeRange['to']}') AND t.vehicle_id = $vehicleId");
                }else{
                    if ($datetimeRange['from']){
                        $criteria->select = array($selectString);
                        $criteria->addCondition("(date(t.datetime) BETWEEN '{$datetimeRange['from']}' AND '{$datetimeRange['to']}')");
                    }else{
                        $criteria->addCondition("id = 'imposible'");
                    }
                }   
                
                $criteria->join = "LEFT JOIN vehicle as v ON v.id = t.vehicle_id
                                   LEFT JOIN company as cp ON cp.id = v.company_id";
                
                
                $criteria->group = "t.vehicle_id";
                
                $criteria->order = 'v.serial+0, v.serial+0 <>0 DESC, v.serial';
                
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,));
	}

     public function searchDetailsAsSeparateVehicles($vehicleId = false, $datetimeRange = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('odometer',$this->odometer,true);
		$criteria->compare('datetime',$this->datetime,true);

		if (Yii::app()->user->level >=1000)
                    {
		}else{
                    $company_id=Yii::app()->user->company_id;
                    $criteria->addCondition("cp.id = $company_id");
		}
                $selectString = "t.vehicle_id, date(t.datetime) as date_stamp, t.odometer as distance, v.serial";


//                if ($datetimeRange['from'] !== "//"){
//                    $criteria->addCondition("datetime Between {$datetimeRange['from']} AND {$datetimeRange['to']}");
//                }
		 // if all vehicles are selected
                if ($vehicleId){
                    $criteria->select = array($selectString);
                    $criteria->addCondition("(date(t.datetime) BETWEEN '{$datetimeRange['from']}' AND '{$datetimeRange['to']}') AND t.vehicle_id = $vehicleId");
                }else{
                    if ($datetimeRange['from']){
                        $criteria->select = array($selectString);
                        $criteria->addCondition("(date(t.datetime) BETWEEN '{$datetimeRange['from']}' AND '{$datetimeRange['to']}')");
                    }else{
                        $criteria->addCondition("id = 'imposible'");
                    }
                }

                $criteria->join = "LEFT JOIN vehicle as v ON v.id = t.vehicle_id
                                   LEFT JOIN company as cp ON cp.id = v.company_id";


                //$criteria->group = "t.vehicle_id";

                $criteria->order = 'v.serial+0, v.serial+0 <>0 DESC, v.serial, date_stamp ASC';

                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,));
	}

        public function searchAccumulative($vehicleId = false, $datetimeRange = false)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('vehicle_id',$this->vehicle_id);
		$criteria->compare('odometer',$this->odometer,true);
		$criteria->compare('datetime',$this->datetime,true);

		if (Yii::app()->user->level >=1000)
                    {
		}else{
                    $company_id=Yii::app()->user->company_id;
                    $criteria->addCondition("cp.id = $company_id");
		}
                if ($datetimeRange['from'] !== "//"){
                    $datesArray = $this->createDateRangeArray($datetimeRange['from'],$datetimeRange['to']);

                    $selectString = "t.vehicle_id, v.serial, ";
                    foreach ($datesArray as $key => $date){
                        $selectString .= "SUM(IF(t.`datetime` <= DATE_ADD('$date', INTERVAL 1 DAY), t.`odometer`, NULL)) date$key, ";
                    }
                    $selectString = substr($selectString, 0,-2);
                }
		 // if all vehicles are selected
                if ($vehicleId){
                    $criteria->select = array($selectString);
                    $criteria->addCondition("(date(t.datetime) BETWEEN '0000-00-00 00:00:00' AND '{$datetimeRange['to']}') AND t.vehicle_id = $vehicleId");
                }else{
                    if ($datetimeRange['from']){
                        $criteria->select = array($selectString);
                        $criteria->addCondition("(date(t.datetime) BETWEEN '0000-00-00 00:00:00' AND '{$datetimeRange['to']}')");
                    }else{
                        $criteria->addCondition("id = 'imposible'");
                    }
                }   

                $criteria->join = "LEFT JOIN vehicle as v ON v.id = t.vehicle_id
                                   LEFT JOIN company as cp ON cp.id = v.company_id";

                
                $criteria->group = "t.vehicle_id";
                
                $criteria->order = 'v.serial+0, v.serial+0 <>0 DESC, v.serial';
                
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,));
	}
        public function searchAccumulativeAsSeparateVehicles($vehicleId = false, $datetimeRange = false)
	{
        $condition = "";

		if (Yii::app()->user->level >=1000)
                    {
		}else{
                    $company_id=Yii::app()->user->company_id;
                    $condition .= (" AND cp.id = $company_id");
		}
                if ($datetimeRange['from'] !== "//"){


                    if ($vehicleId){
                        $condition .= " AND t.vehicle_id = $vehicleId";
                    }

                    $join = "LEFT JOIN vehicle as v ON v.id = t.vehicle_id
                             LEFT JOIN company as cp ON cp.id = v.company_id";

                    // Get the accumulative odometer until -1 day of from
                    $command = Yii::app()->db->createCommand("select t.vehicle_id, sum(t.odometer) as sum from vehicle_odometer_snaps t $join where date(t.datetime) < '{$datetimeRange['from']}'  $condition
					 group by t.vehicle_id");
                    $accumOdos = $command->queryAll();
                    // create an array with vehicle id as key and odomenter as value to use it as a base for our next query
                    foreach ($accumOdos as $accumOdo){
                        $baseOdo[$accumOdo['vehicle_id']] =  $accumOdo['sum'];
                    }
                    //print_r($baseOdo);


                    $order = 'ORDER BY v.serial+0, v.serial+0 <>0 DESC, v.serial, t.datetime ASC';
                    $sql = "select t.vehicle_id, date(t.datetime) date,  t.odometer, v.serial
							from vehicle_odometer_snaps t
							$join
							where date(t.datetime) BETWEEN '{$datetimeRange['from']}' AND '{$datetimeRange['to']}'
							$condition
							$order
							";
                    $command = Yii::app()->db->createCommand($sql);
                    $results = $command->queryAll();
                    $x=0;
                    foreach ($results as $result){
                        if ($results2[$x-1]['vehicle_id'] == $result['vehicle_id']) {
                            $odometer = $results2[$x-1]['odometer'] + $result['odometer'];
                        }else{
                            $odometer = $result['odometer']+ $baseOdo[$result['vehicle_id']];
                        }
                        $results2[$x]['date'] = $result['date'];
                        $results2[$x]['odometer'] = $odometer;
                        $results2[$x]['serial'] = $result['serial'];
                        $results2[$x]['vehicle_id'] = $result['vehicle_id'];

                        $x++;
                    }
                    //print_r($results2);

                    return $results2;

                }

	}

        Public function createDateRangeArray($strDateFrom,$strDateTo)
        {
            $aryRange=array();
            
            $begin = new DateTime($strDateFrom);
            $end = new DateTime($strDateTo);
            $end->modify('+1 day'); // include end date
            
            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($begin, $interval ,$end);

            foreach($daterange as $date){
                $aryRange[] = $date->format("Y-m-d");
            }
            return $aryRange;
        }
}