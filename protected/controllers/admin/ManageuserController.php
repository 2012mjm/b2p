<?php

class ManageuserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $showSidebar = false;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform all actions
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model = new User('search');
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$userService = new UserService();
		
		$model = $userService->getUserId($id);
		if(!$model) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		
		$dataProviderOrder = new CActiveDataProvider('Order', array(
			'criteria'=>$userService->ordersSallerCriteria($id),
			'pagination'=>array(
				'pageSize'=>20,
			),
		));

		//Total Sale Price
		$criteria = $userService->ordersSallerCriteria($id);
		$totalSalePrice = 0;
		$criteria->select = 'SUM(t.count * t.price) AS price';
		$orderUserModel = Order::model()->find($criteria);
		if($orderUserModel) {
			$totalSalePrice = $orderUserModel->price;
		}

		//Total Sale Price With Comission
		$criteria = $userService->ordersSallerCriteria($id);
		$totalSalePriceWithCommission = 0;
		$criteria->select = 'SUM(t.count * t.price * (100 - t.systemComission) / 100) AS price';
		$orderUserModel2 = Order::model()->find($criteria);
		if($orderUserModel2) {
			$totalSalePriceWithCommission = $orderUserModel2->price;
		}

		//Total Count Sale
		$criteria = $userService->ordersSallerCriteria($id);
		$totalCount = 0;
		$criteria->select = 'SUM(t.count) AS count';
		$orderUserModel3 = Order::model()->find($criteria);
		if($orderUserModel3) {
			$totalCount = $orderUserModel3->count;
		}

		//Block Credit in Withdraw 
		$blockCredit = 0;
		$criteria = new CDbCriteria();
		$criteria->compare('userId', $id);
		$criteria->compare('status', 'pending');
		$criteria->select = 'SUM(credit) AS credit';
		$withdrawModel = Withdraw::model()->find($criteria);
		if($withdrawModel) {
			$blockCredit = $withdrawModel->credit;
		}

		$this->render('view',array(
			'model'=>$model,
			'dataProviderOrder'=>$dataProviderOrder,
			'totalCount'=>$totalCount,
			'totalSalePrice'=>$totalSalePrice,
			'totalSalePriceWithCommission'=>$totalSalePriceWithCommission,
			'blockCredit'=>$blockCredit,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$userService 	= new UserService();
		$viewModel 		= new UserViewModel();
		$userModel	 	= new User();
		
		// get viewModel & set attr then return to viewModel
		$viewModel = $userService->getUserId($id, $viewModel);

		if(isset($_POST['UserViewModel']))
		{
			$viewModel->id = $id;
			$viewModel->attributes = $_POST['UserViewModel'];
			
			if ($viewModel->validate())
			{
				if($userService->update($viewModel))
				{
					Yii::app()->user->setFlash('success', yii::t('form', 'Changes were successfully updated.'));
					$this->redirect(array('index'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'Changes were not updated.'));
				}
			}
		}

		$this->render('update', array(
			'model'=>$viewModel,
			'userModel'=>$userModel,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$userService = new UserService();
		if($userService->delete($id))
		{
			Yii::app()->user->setFlash('success', yii::t('form', 'The data was successfully removed.'));
		}
		else {
			Yii::app()->user->setFlash('error', yii::t('form', 'The data was not removed.'));
		}
		
		
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
	}
	
	public function actionDeletes()
	{
		if(isset($_POST['selectedIds']) && !empty($_POST['selectedIds']))
		{
			$items = explode(',', $_POST['selectedIds']);
			
			$userService = new UserService();
			if($userService->deletes($items))
			{
				Yii::app()->user->setFlash('success', yii::t('form', 'The datas were successfully removed.'));
			}
			else {
				Yii::app()->user->setFlash('error', yii::t('form', 'The datas were not removed.'));
			}
	    }
	    else {
	    	Yii::app()->user->setFlash('notice', yii::t('form', 'At least one item must be selected.'));
	    }
	}
	
	public function actionStatuses()
	{
		if(isset($_POST['selectedIds']) && !empty($_POST['selectedIds']))
		{
			$items = explode(',', $_POST['selectedIds']);
			
			$userService = new UserService();
			if($userService->statuses($items, $_POST['selectedStatus']))
			{
				Yii::app()->user->setFlash('success', yii::t('form', 'Changes were successfully updated.'));
			}
			else {
				Yii::app()->user->setFlash('error', yii::t('form', 'Changes were not updated.'));
			}
	    }
	    else {
	    	Yii::app()->user->setFlash('notice', yii::t('form', 'At least one item must be selected.'));
	    }
	}

	/**
	 * Performs the AJAX validation.
	 * @param User $model the model to be validated
	 */
//	protected function performAjaxValidation($model)
//	{
//		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
//		{
//			echo CActiveForm::validate($model);
//			Yii::app()->end();
//		}
//	}
}
