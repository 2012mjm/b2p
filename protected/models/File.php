<?php

/**
 * This is the model class for table "{{file}}".
 *
 * The followings are the available columns in table '{{file}}':
 * @property integer $id
 * @property integer $userId
 * @property string $type
 * @property string $fileName
 * @property string $filePath
 * @property string $fileType
 * @property integer $fileSize
 * @property string $creationDate
 * @property string $isDeleted
 *
 * The followings are the available model relations:
 * @property User $user
 * @property FileProduct[] $fileProducts
 * @property Order[] $orders
 * @property Product $photo
 * @property Product $demoFile
 * @property Product $projehFile
 */
class File extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return File the static model class
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
		return '{{file}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, type, fileName, filePath, creationDate', 'required'),
			array('userId, fileSize', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>6),
			array('fileName, filePath', 'length', 'max'=>255),
			array('fileType', 'length', 'max'=>50),
			array('isDeleted', 'length', 'max'=>3),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userId, type, fileName, filePath, fileType, fileSize, creationDate, isDeleted', 'safe', 'on'=>'search'),
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
			'fileProducts' => array(self::HAS_MANY, 'FileProduct', 'fileId'),
			'orders' => array(self::HAS_MANY, 'Order', 'projehFileId'),
			'photo' => array(self::HAS_ONE, 'Product', 'photoId'),
			'demoFile' => array(self::HAS_ONE, 'Product', 'demoFileId'),
			'projehFile' => array(self::HAS_ONE, 'Product', 'projehFileId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userId' => 'User',
			'type' => 'Type',
			'fileName' => 'File Name',
			'filePath' => 'File Path',
			'fileType' => 'File Type',
			'fileSize' => 'File Size',
			'creationDate' => 'Creation Date',
			'isDeleted' => 'Is Deleted',
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
		$criteria->compare('userId',$this->userId);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('fileName',$this->fileName,true);
		$criteria->compare('filePath',$this->filePath,true);
		$criteria->compare('fileType',$this->fileType,true);
		$criteria->compare('fileSize',$this->fileSize);
		$criteria->compare('creationDate',$this->creationDate,true);
		$criteria->compare('isDeleted',$this->isDeleted,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}