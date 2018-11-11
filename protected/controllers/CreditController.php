<?php

class CreditController extends Controller
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
						'actions' => array('index'),
				),
				array('deny', // allow all visitors to access all actions.
						'users' => array('*'),
				),
		);
	}

	/**
	 * Displays the login page
	 */
	public function actionIndex()
	{
		$userId = Yii::app()->user->id;
		
		$userService	= new UserService();
		$userModel 		= $userService->getUserId($userId);
		
		$creditService 		= new CreditService();
		$creditDataProvider	= $creditService->getCreditsUser($userId);
		
		$viewModel = new WithdrawViewModel();
		
		if (isset($_POST['WithdrawViewModel']))
		{
			$viewModel->attributes = $_POST['WithdrawViewModel'];
			if($viewModel->validate())
			{
				$creditRial = $viewModel->credit*10;
	
				if($creditRial > $userModel->virtualCredit) {
					Yii::app()->user->setFlash('error', yii::t('withdraw', 'You can request your money than your account!'));
				}
				elseif($creditRial < Yii::app()->setting->lowWithdrawBankComission) {
					Yii::app()->user->setFlash('error', yii::t('withdraw', 'این مبلغ کمتر از کارمزد  می باشد و قابل برداشت نمی باشد!'));
				}
				else {
					if($creditService->addWithdraw($creditRial)) {
						$userModel->virtualCredit -= $creditRial;
						$userModel->save();
						
						$viewModel->credit = null;
						Yii::app()->user->setFlash('success', yii::t('withdraw', 'Your request has been successfully registered.'));
					}
					else {
						Yii::app()->user->setFlash('error', yii::t('withdraw', 'Submit your request in the wrong!'));
					}
				}
			}
		}

		$this->render('index', array(
			'userModel'=>$userModel,
			'creditDataProvider'=>$creditDataProvider,
			'viewModel'=>$viewModel
		));
	}
}