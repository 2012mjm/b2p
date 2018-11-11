<?php
class CreditService
{
	public function getCreditsUser($userId)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('t.userId', $userId);
		$criteria->order = 't.id DESC';
		$criteria->limit = 10;
		$criteria->together = true;
		$criteria->with[] = 'user';
		
		$orderDataProvider = new CActiveDataProvider('Withdraw', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));
		
		return $orderDataProvider;
	}

	public function getCreditsAllUser()
	{
		$criteria = new CDbCriteria();
		$criteria->order = 't.id DESC';
		$criteria->limit = 30;
		$criteria->together = true;
		$criteria->with[] = 'user';
		
		$orderDataProvider = new CActiveDataProvider('Withdraw', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>30,
		    ),
		));
		
		return $orderDataProvider;
	}
	
	public function addWithdraw($credit)
	{
		$model = new Withdraw();
		$model->credit 			= $credit;
		$model->userId 			= Yii::app()->user->id;
		$model->requestDate 	= date('Y-m-d H:i:s');
		$model->status 			= 'pending';
		$model->rejectReason 	= null;
		
		return $model->save();
	}

	public static function countManageUnread()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.status', 'pending');
		$criteria->select = 'COUNT(*) AS id';

		$model = Withdraw::model()->find($criteria);
		if($model) {
			return $model->id;
		}
	}
}
?>