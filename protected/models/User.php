<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property string $fullname
 * @property string $title
 * @property integer $company_id
 * @property integer $user_type_id
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property UserType $userType
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public $salt;
        public $repeatpassword;
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('password, email, company_id, user_type_id', 'required'),
			array('company_id, user_type_id', 'numerical', 'integerOnly'=>true),
			array('email, password, fullname, title', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id,  email, password, fullname, title, company_id, user_type_id', 'safe', 'on'=>'search'),
                        array('repeatpassword', 'compare', 'compareAttribute'=>'password', 'message'=>"Passwords don't match"),

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
			'userType' => array(self::BELONGS_TO, 'UserType', 'user_type_id'),
			'userSettings' => array(self::BELONGS_TO, 'UserSettings', 'id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'E-mail',
			'password' => 'Password',
                        'newpassword' => 'New Password',
                        'repeatpassword' => 'Repeat New Password',
			'fullname' => 'Name',
			'title' => 'Title',
			'company_id' => 'Company',
			'user_type_id' => 'User Type',
			'company.name' => 'Company',
			'userType.name' => 'User Type',
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
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('fullname',$this->fullname,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('user_type_id',$this->user_type_id);
		if (Yii::app()->user->level >=1000)
		{$criteria->compare('company_id',$this->company_id);
		}else{
		$company_id=Yii::app()->user->company_id;
		$criteria->addCondition("company_id = $company_id");
		}
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function validatePassword($password)
    {
		
        //return $this->hashPassword($password,$this->salt)===$this->password;
      	return $password===$this->password;
	}
 
    public function hashPassword($password,$salt)
    {
        return md5($salt.$password);
    }
}