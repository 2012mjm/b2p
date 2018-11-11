<?php

/**
 * This is the model class for table "{{page}}".
 *
 * The followings are the available columns in table '{{page}}':
 * @property integer $id
 * @property string $title
 * @property string $key
 * @property string $context
 * @property integer $visit
 * @property string $creationDate
 * @property string $updateDate
 * @property string $type
 */
class Page extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{page}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, key, context, creationDate', 'required'),
			array('visit', 'numerical', 'integerOnly'=>true),
			array('title, key', 'length', 'max'=>45),
			array('type', 'length', 'max'=>6),
			array('updateDate', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, key, context, visit, creationDate, updateDate, type', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'عنوان',
			'key' => 'کلید',
			'context' => 'محتویات',
			'visit' => 'بازدید',
			'creationDate' => 'تاریخ ایجاد',
			'updateDate' => 'تاریخ ویرایش',
			'type' => 'نوع',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('context',$this->context,true);
		$criteria->compare('visit',$this->visit);
		$criteria->compare('creationDate',$this->creationDate,true);
		$criteria->compare('updateDate',$this->updateDate,true);
		$criteria->compare('type',$this->type,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return BasePage the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
