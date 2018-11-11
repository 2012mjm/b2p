<?php

class ManageticketController extends Controller
{
	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
    public function filters()
    {
        return array( 'accessControl' ); // perform access control for CRUD operations
    }

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
	 * *************************************************
	 */
	public function actionIndex()
	{
		$service = new TicketService();
		$dataProvider = $service->getAllDataProvider();
	
		$this->render('index', array('dataProvider'=>$dataProvider));
	}

	/**
	 * *************************************************
	 */
	public function actionView()
	{
		$id = (int)	Yii::app()->request->getQuery('id');

		if(!empty($id))
		{
			$service = new TicketService();
			$model = $service->getAllById($id);
			$viewModel = new TicketViewModel('answerAll');
			$viewModel->fixed = ($model->status == 'fixed') ? true : false;
		
			if($model->manageStatus == 'new') {
				$model->manageStatus = 'read';
				$model->save();
			}

			if($model) {
				if(isset($_POST['TicketViewModel']))
				{
					$viewModel->attributes 	= $_POST['TicketViewModel'];
					$viewModel->assignId = ($model->userId == 1) ? $model->assignId : $model->userId;

					if ($viewModel->validate())
					{
						if($service->createAnswerAll($id, $viewModel))
						{
							if($viewModel->fixed == '1') {
								$model->status = 'fixed';
							} else {
								$model->status = 'new';
							}

							$model->save();

							$userService = new UserService();
							$userModel = $userService->getUserId($viewModel->assignId);
							
							//send mail
							$to = $userModel->email;
							$subject = "پاسخ به تیکت شما در بیا تو پروژه";
							$message = '<div style="direction:rtl;text-align:right">';
								$message .= 'پاسخ به تیکت شما در سایت بیا تو پروژه داده شده است.<br><br>';
								$message .= 'برای خواندن پاسخ به لینک زیر در سایت مراجعه کنید.<br>';
								$message .= '<a href="'. Yii::app()->createAbsoluteUrl('/ticket/view', array('id'=>$id)) .'">تیکت '.$id.'#</a><br>';
								$message .= '<br><hr>بیا تو پروژه<br><a href="http://bia2projeh.ir">www.bia2projeh.ir</a>';
							$message .= '</div>';
							$headers = "From: ".Yii::app()->setting->adminEmail . "\r\n" .
								"Content-type:text/html;charset=UTF-8";
							
							mail($to,$subject,$message,$headers);

							$model = $service->getById($id);
							$viewModel = new TicketViewModel();
							$viewModel->fixed = ($model->status == 'fixed') ? true : false;
							Yii::app()->user->setFlash('success', yii::t('form', 'The data was successfully created.'));
						}
						else {
							Yii::app()->user->setFlash('error', yii::t('form', 'The data was not created.'));
						}
					}
				}
			}

			$this->render('view', array('model'=>$model, 'viewModel'=>$viewModel));
		}
	}

	/**
	 * *************************************************
	 */
	public function actionCreate()
	{
		$pid = (int) Yii::app()->request->getQuery('pid', 0);
		$uid = (int) Yii::app()->request->getQuery('uid', 0);

		$service 		= new TicketService();
		$ticketModel	= new Ticket();
		$viewModel 		= new TicketViewModel('createAll');
	
		if($pid) {
			$productService = new ProductService();
			$productModel	= $productService->getProductId($pid);
			if($productModel) {
				$viewModel->title = 'پروژه '.$productModel->title.' - ';
				
				$viewModel->description = "\n\n\n\n=======================================================\n";
				$viewModel->description .= 'پروژه '.$productModel->title."\n";
				$viewModel->description .= Yii::app()->createAbsoluteUrl("/product/view", array("id"=>$productModel->id));
				
				$viewModel->assignId = $productModel->userId;
			}
		}
		
		if($uid) {
			$viewModel->assignId = $uid;
		}

		$criteria = new CDbCriteria();
		$criteria->compare('t.status', 'active');
		$criteria->compare('t.id', '<>1');
		$userModel = User::model()->findAll($criteria);
		
		if($userModel) {
			foreach($userModel as $user) {
				$assignList[$user->id] = $user->username . ' - '. $user->email;
			}
		}

		if(isset($_POST['TicketViewModel']))
		{
			$viewModel->attributes 	= $_POST['TicketViewModel'];

			if ($viewModel->validate())
			{
				if($id = $service->createAll($viewModel, $ticketModel))
				{
					$userService = new UserService();
					$userModel = $userService->getUserId($viewModel->assignId);
					
					//send mail
					$to = $userModel->email;
					$subject = "تیکت جدید در بیا تو پروژه";
					$message = '<div style="direction:rtl;text-align:right">';
						$message .= 'شما یک تیکت جدید در سایت بیا تو پروژه دارید.<br><br>';
						$message .= 'برای خواندن تیکت به لینک زیر در سایت مراجعه کنید.<br>';
						$message .= '<a href="'. Yii::app()->createAbsoluteUrl('/ticket/view', array('id'=>$id)) .'">تیکت '.$id.'#</a><br>';
						$message .= '<br><hr>بیا تو پروژه<br><a href="http://bia2projeh.ir">www.bia2projeh.ir</a>';
					$message .= '</div>';
					$headers = "From: ".Yii::app()->setting->adminEmail . "\r\n" .
						"Content-type:text/html;charset=UTF-8";
					
					mail($to,$subject,$message,$headers);
					
					Yii::app()->user->setFlash('success', yii::t('form', 'The data was successfully created.'));
					$this->redirect(array('view', 'id'=>$id));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'The data was not created.'));
				}
			}
		}

		$this->render('create', array(
			'viewModel'=>$viewModel,
			'ticketModel'=>$ticketModel,
			'assignList'=>$assignList,
		));
	}
}

?>