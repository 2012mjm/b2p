<?php
class ReportService
{
	public function create($viewModel) {
		$model = new Report();
		
		$model->userId 			= Yii::app()->user->getId();
		$model->productId 		= $viewModel->productId;
		$model->orderId 		= ($viewModel->orderId) ? $viewModel->orderId : 0;
		$model->description 	= $viewModel->description;
		$model->type 			= 'abuse';
		$model->creationDate 	= date('Y-m-d H:i:s');
		
		return $model->save();
	}

	public static function countManageUnread()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('t.status', 'new');
		$criteria->select = 'COUNT(*) AS id';

		$model = Report::model()->find($criteria);
		if($model) {
			return $model->id;
		}
	}
}