<?php
class TicketService
{
	public function getById($id, $userId=null)
	{
		$criteria = new CDbCriteria;
		if($userId != null) {
			$criteria->compare('t.userId', $userId);
			$criteria->compare('t.assignId', $userId, false, 'OR');
		}
		$criteria->compare('t.id', $id);
		$criteria->addCondition('t.subId IS NULL');
		$criteria->order = 'tickets.id ASC';
		$criteria->together = true;
		$criteria->with[] = 'tickets';

		return Ticket::model()->find($criteria);
	}
	public function getAllById($id)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.id', $id);
		$criteria->addCondition('t.subId IS NULL');
		$criteria->order = 'tickets.id ASC';
		$criteria->together = true;
		$criteria->with[] = 'tickets';

		return Ticket::model()->find($criteria);
	}

	public function getDataProvider($userId)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.userId', $userId);
		$criteria->compare('t.assignId', $userId, false, 'OR');
		$criteria->addCondition('t.subId IS NULL');
		$criteria->order = 't.id DESC';
		
		$dataProvider = new CActiveDataProvider('Ticket', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>20,
		    ),
		));
		
		return $dataProvider;
	}
	public function getAllDataProvider()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('t.subId IS NULL');
		$criteria->order = 't.id DESC';
		$criteria->together = true;
		$criteria->with[] = 'assign';
		
		$dataProvider = new CActiveDataProvider('Ticket', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>40,
		    ),
		));
		
		return $dataProvider;
	}

	public function create($viewModel, $model)
	{
		$model->setAttributes($viewModel->attributes);
		
		$model->userId 			= Yii::app()->user->id;
		$model->assignId 		= 1;
		$model->status 			= 'new';
		$model->manageStatus 	= 'new';
		$model->subId 			= NULL;
		$model->creationDate	= date('Y-m-d H:i:s');
		
		$model->save();
		return $model->id;
	}
	public function createAll($viewModel, $model)
	{
		$model->setAttributes($viewModel->attributes);
		
		$model->userId 			= Yii::app()->user->id;
		$model->assignId 		= $viewModel->assignId;
		$model->status 			= 'new';
		$model->manageStatus 	= 'new';
		$model->subId 			= NULL;
		$model->creationDate	= date('Y-m-d H:i:s');
		
		$model->save();
		return $model->id;
	}

	public function createAnswer($id, $viewModel)
	{
		$model = new Ticket();
		$model->setAttributes($viewModel->attributes);
		
		$model->userId 		= Yii::app()->user->id;
		$model->assignId 	= 1;
		$model->subId 		= $id;
		$model->creationDate= date('Y-m-d H:i:s');

		return $model->save();
	}
	public function createAnswerAll($id, $viewModel)
	{
		$model = new Ticket();
		$model->setAttributes($viewModel->attributes);
		
		$model->userId 		= Yii::app()->user->id;
		$model->assignId 	= $viewModel->assignId;
		$model->subId 		= $id;
		$model->creationDate= date('Y-m-d H:i:s');
		$model->status 		= NULL;

		return $model->save();
	}
	
	public static function countUnread()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.userId', Yii::app()->user->id);
		$criteria->compare('t.assignId', Yii::app()->user->id, false, 'OR');
		$criteria->addCondition('t.subId IS NULL');
		$criteria->compare('t.status', 'new');
		$criteria->select = 'COUNT(*) AS id';

		$model = Ticket::model()->find($criteria);
		if($model) {
			return $model->id;
		}
	}
	
	public static function countManageUnread()
	{
		$criteria = new CDbCriteria;
		$criteria->addCondition('t.subId IS NULL');
		$criteria->compare('t.manageStatus', 'new');
		$criteria->select = 'COUNT(*) AS id';

		$model = Ticket::model()->find($criteria);
		if($model) {
			return $model->id;
		}
	}
}
?>