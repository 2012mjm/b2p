<?php

class SettingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionIndex()
	{
		$settingService = new SettingService();
		$viewModel 		= new SettingViewModel();
		
		// get viewModel & set attr then return to viewModel
		$viewModel = $settingService->getSetting($viewModel);

		if(isset($_POST['SettingViewModel']))
		{
			$viewModel->attributes = $_POST['SettingViewModel'];
			$viewModel->lowWithdraw *= 10;
			$viewModel->lowWithdrawBankComission *= 10;
			
			if ($viewModel->validate())
			{
				if($settingService->update($viewModel)) {
					Yii::app()->user->setFlash('success', yii::t('form', 'Changes were successfully updated.'));
					$this->refresh();
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'Changes were not updated.'));
				}
			}
		}
		else {
			$viewModel->lowWithdraw /= 10;
			$viewModel->lowWithdrawBankComission /= 10;
		}

		$this->render('index', array(
			'model'=>$viewModel,
		));
	}
}
