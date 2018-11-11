<?php

class TicketController extends Controller
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
				array('allow', // allow all users to access all actions.
						'users' => array('@'),
						'actions' => array('index', 'create', 'view'),
				),
				array('deny', // allow all visitors to access all actions.
						'users' => array('*'),
				),
		);
	}

	/**
	 * *************************************************
	 */
	public function actionIndex()
	{
		$service = new TicketService();
		$dataProvider = $service->getDataProvider(Yii::app()->user->id);
	
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
			$model = $service->getById($id, Yii::app()->user->id);
			$viewModel = new TicketViewModel();
			
			if($model->status == 'new') {
				$model->status = 'read';
				$model->save();
			}

			if($model) {
				if(isset($_POST['TicketViewModel']) && $model->status != 'fixed')
				{
					$viewModel->attributes 	= $_POST['TicketViewModel'];

					if ($viewModel->validate())
					{
						if($service->createAnswer($id, $viewModel))
						{
							$model->manageStatus = 'new';
							$model->save();

							$model = $service->getById($id, Yii::app()->user->id);
							$viewModel = new TicketViewModel();
							Yii::app()->user->setFlash('success', yii::t('form', 'The data was successfully created.'));
							
							
							$userService = new UserService();
							$userModel = $userService->getUserId(Yii::app()->user->id);
							
							//send mail
							$to = Yii::app()->setting->adminEmail;
							$subject = "پاسخ به تیکت در بیا تو پروژه";
							$message = "یک پاسخ به تیکت ".$model->id."# از طرف ".$userModel->username." داده شده است.";
							$headers = "From: $userModel->email" . "\r\n" .
								"Content-type: text/html; charset=UTF-8";
							
							mail($to,$subject,$message,$headers);
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
		
		$service 		= new TicketService();
		$ticketModel	= new Ticket();
		$viewModel 		= new TicketViewModel('create');
		
		if($pid) {
			$productService = new ProductService();
			$productModel	= $productService->getMyProductId($pid);
			if($productModel) {
				$viewModel->title = 'پروژه '.$productModel->title.' - ';
				
				$viewModel->description = "\n\n\n\n=======================================================\n";
				$viewModel->description .= 'پروژه '.$productModel->title."\n";
				$viewModel->description .= Yii::app()->createAbsoluteUrl("/product/view", array("id"=>$productModel->id));
			}
		}

		if(isset($_POST['TicketViewModel']))
		{
			$viewModel->attributes 	= $_POST['TicketViewModel'];

			if ($viewModel->validate())
			{
				if($id = $service->create($viewModel, $ticketModel))
				{
					$userService = new UserService();
					$userModel = $userService->getUserId(Yii::app()->user->id);

					//send mail
					$to = Yii::app()->setting->adminEmail;
					$subject = "تیکت جدید در بیا تو پروژه";
					$message = "یک تیکت جدید از طرف ".$userModel->username." ثبت شده است.";
					$headers = "From: $userModel->email" . "\r\n" .
						"Content-type: text/html; charset=UTF-8";
					
					mail($to,$subject,$message,$headers);
							
					Yii::app()->user->setFlash('success', yii::t('form', 'The data was successfully created.'));
					$this->redirect(array('/ticket/view', 'id'=>$id));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'The data was not created.'));
				}
			}
		}

		$this->render('create', array(
			'viewModel'=>$viewModel,
			'ticketModel'=>$ticketModel,
		));
	}
}

?>