<?php

class ManagewithdrawController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow', // allow admin subcategory to perform all actions
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		
		if($model->status != 'pending') {
			throw new CHttpException(503,'شما فقط می توانید درخواست های در وضعیت معلق را ویرایش نمائید.');
			return;
		}

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Withdraw']))
		{
			$model->attributes=$_POST['Withdraw'];
			$model->answerDate = date('Y-m-d H:i:s');
			if($model->save()) {
				
				$userModel = $model->user;
					
				//status
				if($model->status == 'rejected')
				{
					$userModel->virtualCredit += $model->credit;
					$userModel->save();
				}
				
				//send mail
				$to = $userModel->email;
				$subject = "پاسخ به درخواست واریز شما در بیا تو پروژه";
				$message = '<div style="direction:rtl;text-align:right">';
					$message .= 'پاسخ به درخواست واریز شما در سایت بیا تو پروژه داده شده است.<br><br>';
					$message .= 'برای دیدن جزئیات بیشتر به لینک زیر در سایت مراجعه کنید.<br>';
					$message .= '<a href="'. Yii::app()->createAbsoluteUrl('/credit/index') .'">لینک درخواست های واریز</a><br>';
					$message .= '<br><hr>بیا تو پروژه<br><a href="http://bia2projeh.ir">www.bia2projeh.ir</a>';
				$message .= '</div>';
				$headers = "From: ".Yii::app()->setting->adminEmail . "\r\n" .
					"Content-type:text/html;charset=UTF-8";
				
				mail($to,$subject,$message,$headers);
				
				
				Yii::app()->user->setFlash('success', 'وضعیت درخواست برداشت تغییر کرد.');
				$this->redirect(array('index'));
			}
			else {
				Yii::app()->user->setFlash('error', 'وضعیت درخواست برداشت تغییر نکرد!');
			}
		}


		//Block Credit in Withdraw
		$blockCredit = 0;
		$criteria = new CDbCriteria();
		$criteria->compare('userId', $model->userId);
		$criteria->compare('status', 'pending');
		$criteria->select = 'SUM(credit) AS credit';
		$withdrawModel = Withdraw::model()->find($criteria);
		if($withdrawModel) {
			$blockCredit = $withdrawModel->credit;
		}

		$this->render('update',array(
			'model'=>$model,
			'withdrawModel'=>new Withdraw(),
			'blockCredit'=>$blockCredit,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$creditService 		= new CreditService();
		$creditDataProvider	= $creditService->getCreditsAllUser();

		$this->render('index', array(
			'creditDataProvider'=>$creditDataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Withdraw::model()->with('user')->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='withdraw-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
