<?php

/**
 * This is the model class for table "{{log}}".
 *
 * The followings are the available columns in table '{{log}}':
 * @property string $id
 * @property string $ip
 * @property integer $userId
 * @property string $title
 * @property string $pageRoute
 * @property string $pageParams
 * @property string $description
 * @property string $creationDate
 * @property integer $isRead
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Log extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Log the static model class
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
		return '{{log}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('ip, title, description, creationDate', 'required'),
			array('userId, isRead', 'numerical', 'integerOnly'=>true),
			array('ip', 'length', 'max'=>15),
			array('title, pageRoute', 'length', 'max'=>45),
			array('pageParams, description', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, ip, userId, title, pageRoute, pageParams, description, creationDate, isRead', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'ip' => 'Ip',
			'userId' => 'User',
			'title' => 'Title',
			'pageRoute' => 'Page Route',
			'pageParams' => 'Page Params',
			'description' => 'Description',
			'creationDate' => 'Creation Date',
			'isRead' => 'Is Read',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('ip',$this->ip,true);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('pageRoute',$this->pageRoute,true);
		$criteria->compare('pageParams',$this->pageParams,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('creationDate',$this->creationDate,true);
		$criteria->compare('isRead',$this->isRead);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}