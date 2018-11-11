<?php

/**
 * This is the model class for table "{{order}}".
 *
 * The followings are the available columns in table '{{order}}':
 * @property integer $id
 * @property integer $paymentId
 * @property integer $productId
 * @property integer $userId
 * @property integer $price
 * @property integer $count
 * @property integer $systemComission
 * @property string $trackingCode
 * @property integer $projehFileId
 * @property string $linkDownload
 * @property string $creationDate
 * @property string $email
 * @property string $ip
 * @property integer $isRead
 * @property string $status
 *
 * The followings are the available model relations:
 * @property File $projehFile
 * @property Payment $payment
 * @property User $user
 * @property Product $product
 * @property Report[] $reports
 */
class Order extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Order the static model class
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
		return '{{order}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('paymentId, productId, price, trackingCode, projehFileId, linkDownload, creationDate', 'required'),
			array('paymentId, productId, userId, price, count, systemComission, projehFileId, isRead', 'numerical', 'integerOnly'=>true),
			array('trackingCode, linkDownload', 'length', 'max'=>20),
			array('email', 'length', 'max'=>255),
			array('ip', 'length', 'max'=>15),
			array('status', 'length', 'max'=>8),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, paymentId, productId, userId, price, count, systemComission, trackingCode, projehFileId, linkDownload, creationDate, email, ip, isRead, status', 'safe', 'on'=>'search'),
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
			'projehFile' => array(self::BELONGS_TO, 'File', 'projehFileId'),
			'payment' => array(self::BELONGS_TO, 'Payment', 'paymentId'),
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
			'product' => array(self::BELONGS_TO, 'Product', 'productId'),
			'reports' => array(self::HAS_MANY, 'Report', 'orderId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'paymentId' => Yii::t('order', 'Payment'),
			'productId' => Yii::t('order', 'Product'),
			'userId' => Yii::t('order', 'User'),
			'price' => Yii::t('order', 'Price'),
			'count' => Yii::t('order', 'Count'),
			'systemComission' => Yii::t('order', 'درصد کارمزد سیستم'),
			'trackingCode' => Yii::t('order', 'Tracking code'),
			'projehFileId' => Yii::t('order', 'Projeh File'),
			'linkDownload' => Yii::t('order', 'Download product link'),
			'creationDate' => Yii::t('order', 'Creation date'),
			'email' => Yii::t('order', 'Email'),
			'ip' => Yii::t('order', 'IP'),
			'isRead' => Yii::t('order', 'Is Read'),
			'status' => Yii::t('order', 'Status'),
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
		$criteria->compare('paymentId',$this->paymentId);
		$criteria->compare('productId',$this->productId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('price',$this->price);
		$criteria->compare('count',$this->count);
		$criteria->compare('systemComission',$this->systemComission);
		$criteria->compare('trackingCode',$this->trackingCode,true);
		$criteria->compare('projehFileId',$this->projehFileId);
		$criteria->compare('linkDownload',$this->linkDownload,true);
		$criteria->compare('creationDate',$this->creationDate,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('isRead',$this->isRead);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}