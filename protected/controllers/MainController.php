<?php

class MainController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		$service = new ProductService();
		$productsDataProvider = $service->getProductsDataProvider();
	
		$this->render('index', array('productsDataProvider'=>$productsDataProvider));
	}

	public function actionDownload($key)
	{
		$service = new OrderService();
		$model = $service->download($key);
		
		if($model == null)
		{
			Yii::app()->user->setFlash('error', 'آدرس مورد نظر منقضی شده است و یا وجود ندارد!');
			$this->redirect(isset(Yii::app()->request->urlReferrer) ? Yii::app()->request->urlReferrer : array('/main'));
		}
		else {
			$projehFile = Yii::getPathOfAlias('webroot') . $model->projehFile->filePath . $model->projehFile->fileName;
			$fileName = uniqid().'.'.pathinfo($model->projehFile->fileName, PATHINFO_EXTENSION);

			$req = new CHttpRequest();
			if (function_exists('apache_get_modules') && in_array('mod_xsendfile', apache_get_modules())) {
				$req->xSendFile($projehFile, array("terminate" => false, "saveName" => $fileName));
			} else {
				$req->sendFile($fileName, file_get_contents($projehFile), null, false);
			}
		}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactViewModel;
		if(isset($_POST['ContactViewModel']))
		{
			$model->attributes=$_POST['ContactViewModel'];
			if($model->validate())
			{
				$name=$model->name;
				$subject=$model->subject;
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/html; charset=UTF-8";

				if(mail(Yii::app()->setting->adminEmail,$subject,$model->body,$headers)) {
					Yii::app()->user->setFlash('success',Yii::t('contact', 'Thank you for contacting us. We will respond to you as soon as possible.'));
					$this->refresh();
				} else {
					Yii::app()->user->setFlash('error',Yii::t('contact', 'Your message was not sent, please try again.'));
				}
			}
		}
		$this->render('contact',array('model'=>$model));
	}
}