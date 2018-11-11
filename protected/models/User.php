<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property integer $isVerifiedEmail
 * @property string $firstname
 * @property string $lastname
 * @property string $phone
 * @property string $mobile
 * @property string $gender
 * @property string $birthday
 * @property string $fieldStudy
 * @property string $bankName
 * @property string $bankAccountNumber
 * @property string $bankCardNumber
 * @property string $virtualCredit
 * @property string $realCredit
 * @property string $randomKey
 * @property string $expiryRandomKey
 * @property string $registrationDate
 * @property string $lastVisit
 * @property string $status
 *
 * The followings are the available model relations:
 * @property File[] $files
 * @property Message[] $senderMessages
 * @property Message[] $recieverMessages
 * @property Order[] $orders
 * @property Product[] $products
 * @property Report[] $reports
 * @property Withdraw[] $withdraws
 * @property Ticket[] $ticketsUser
 * @property Ticket[] $ticketsAssign
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
        return array(
            array('username, password, email, registrationDate', 'required'),
            array('username, password, firstname, lastname, fieldStudy, bankAccountNumber, bankCardNumber, virtualCredit, realCredit', 'length', 'max'=>45),
       		array('isVerifiedEmail', 'numerical', 'integerOnly'=>true),
            array('email', 'length', 'max'=>255),
            array('phone, mobile', 'length', 'max'=>20),
            array('gender', 'length', 'max'=>6),
            array('bankName', 'length', 'max'=>10),
			array('randomKey', 'length', 'max'=>32),
            array('status', 'length', 'max'=>8),
            array('birthday, expiryRandomKey, lastVisit', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, email, firstname, lastname, phone, mobile, gender, birthday, fieldStudy, bankName, bankAccountNumber, bankCardNumber, virtualCredit, realCredit, registrationDate, lastVisit, status', 'safe', 'on'=>'search'),
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
			'files' => array(self::HAS_MANY, 'File', 'userId'),
			'senderMessages' => array(self::HAS_MANY, 'Message', 'senderId'),
			'recieverMessages' => array(self::HAS_MANY, 'Message', 'recieverId'),
			'orders' => array(self::HAS_MANY, 'Order', 'userId'),
			'products' => array(self::HAS_MANY, 'Product', 'userId'),
			'reports' => array(self::HAS_MANY, 'Report', 'userId'),
			'withdraws' => array(self::HAS_MANY, 'Withdraw', 'userId'),
			'ticketsUser' => array(self::HAS_MANY, 'Ticket', 'userId'),
			'ticketsAssign' => array(self::HAS_MANY, 'Ticket', 'assignId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username'			=> Yii::t('user', 'Username'),
			'password' 			=> Yii::t('user', 'Password'),
			'firstname' 		=> Yii::t('user', 'First Name'),
			'lastname' 			=> Yii::t('user', 'Last Name'),
			'email' 			=> Yii::t('user', 'Email'),
			'gender' 			=> Yii::t('user', 'Gender'),
			'birthday' 			=> Yii::t('user', 'Birthday'),
			'fieldStudy' 		=> Yii::t('user', 'Field Study'),
			'phone' 			=> Yii::t('user', 'Phone'),
			'mobile' 			=> Yii::t('user', 'Mobile'),
			'bankName' 			=> Yii::t('user', 'Bank Name'),
			'bankAccountNumber'	=> Yii::t('user', 'Bank Account Number'),
			'bankCardNumber' 	=> Yii::t('user', 'Bank Card Number'),
			'virtualCredit'		=> Yii::t('user', 'Virtual Credit'),
			'realCredit' 		=> Yii::t('user', 'Real Credit'),
			'registrationDate' 	=> Yii::t('user', 'Registration Date'),
			'lastVisit' 		=> Yii::t('user', 'Last Visit'),
			'status' 			=> Yii::t('user', 'Status'),
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
        $criteria->compare('username',$this->username,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('isVerifiedEmail',$this->isVerifiedEmail);
        $criteria->compare('firstname',$this->firstname,true);
        $criteria->compare('lastname',$this->lastname,true);
        $criteria->compare('phone',$this->phone,true);
        $criteria->compare('mobile',$this->mobile,true);
        $criteria->compare('gender',$this->gender,true);
        $criteria->compare('birthday',$this->birthday,true);
        $criteria->compare('fieldStudy',$this->fieldStudy,true);
        $criteria->compare('bankName',$this->bankName,true);
        $criteria->compare('bankAccountNumber',$this->bankAccountNumber,true);
        $criteria->compare('bankCardNumber',$this->bankCardNumber,true);
        $criteria->compare('virtualCredit',$this->virtualCredit,true);
        $criteria->compare('realCredit',$this->realCredit,true);
        $criteria->compare('registrationDate',$this->registrationDate,true);
        $criteria->compare('lastVisit',$this->lastVisit,true);
        $criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}