<?php
class LogService
{
	public $title;
	public $description;
	public $route;
	public $params;

	public function save()
	{
		if(Yii::app()->user->id != 1)
		{
			$model = new Log();
	
			$model->title = $this->title;
			$model->description = $this->description;
			$model->pageRoute = $this->route;
			$model->pageParams = CJSON::encode($this->params);
	
			$model->ip = Yii::app()->request->userHostAddress;
			$model->creationDate = date('Y-m-d H:i:s');
			$model->isRead = 0;
			
			if(!Yii::app()->user->isGuest) {
				$model->userId = Yii::app()->user->id;
			}
			
			return $model->save();
		}
	}

	public static function setRead($idAndModel)
	{
		if(is_int($idAndModel)) {
			$idAndModel = Log::model()->findByPk($idAndModel);
		}
		
		if($idAndModel) {
			$idAndModel->isRead = 1;
			return $idAndModel->save();
		}
		
		return false;
	}
	
	public function getById($id)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.id', $id);
		$criteria->with[] = 'user';
		$criteria->together = true;

		return Log::model()->find($criteria);
	}
	
	public function getAllDataProvider()
	{
		$criteria = new CDbCriteria;
		$criteria->order = 't.id DESC';
		$criteria->with[] = 'user';
		$criteria->together = true;
		
		$dataProvider = new CActiveDataProvider('Log', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>40,
		    ),
		));
		
		return $dataProvider;
	}
	
	public static function countManageUnread()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('isRead', '0');

		return Log::model()->count($criteria);
	}
}
?>