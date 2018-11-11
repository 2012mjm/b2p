<?php

class UserController extends Controller
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
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		if (Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->homeUrl);

		$this->redirect(array('user/profile'));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
//		echo Encrypt::encryptPassword("admin");die;

		if (!Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->homeUrl);

		$loginModel = new LoginViewModel;

		if (isset($_POST['LoginViewModel']))
		{
			$loginModel->attributes = $_POST['LoginViewModel'];
			
			if ($loginModel->validate())
			{
				$userService = new UserService();
				if ($userService->login($loginModel))
				{
					$this->redirect(Yii::app()->request->urlReferrer);
				}
				else {
					Yii::app()->user->setFlash('error', 'نام‌کاربری یا کلمه عبور صحیح نمی‌باشد و یا اینکه فعال سازی پست الکترونیکی خود را انجام نداده‌اید!');
					//$viewModel->addError(null ,yii::t('user', 'Incorrect username or password.'));
				}
			}
		}
		
		$this->render('login',array('model'=>$loginModel));
	}
	
	/**
	 * Signup
	*/
	public function actionSignup()
	{
		if (!Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->homeUrl);
		
		$signupModel = new SignupViewModel();
		$userModel	 = new User();
		
		if (isset($_POST['SignupViewModel']))
		{
			$signupModel->attributes = $_POST['SignupViewModel'];
			
			if ($signupModel->validate())
			{
				$userService = new UserService();
				$userModelFinal = $userService->signup($signupModel);
				if ($userModelFinal !== false)
				{
					$userService->sendMailForActiveEmail($userModelFinal);
					
// 					//auto login
// 					$loginModel = new LoginViewModel;
// 					$loginModel->username = $signupModel->username;
// 					$loginModel->password = $signupModel->password;
// 					$userService->login($loginModel);

					Yii::app()->user->setFlash('success', 'ثبت نام شما با موفقیت انجام شد، برای فعال سازی اکانت خود، پست الکترونی را بررسی نمایید.');
					$this->redirect(Yii::app()->homeUrl);
				}
			}
		}
		
		//json list city to outdoor
		/*if(($cityList = CityService::getCityList()) !== false) {
			Yii::app()->clientScript->registerScript('cityListJson', 'var cityListJson='.CJavaScript::encode($cityList).';', CClientScript::POS_HEAD);
		}*/
		
		$this->render('signup', array('model'=>$signupModel, 'userModel'=>$userModel));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		if (Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->homeUrl);
		
		$userService = new UserService();
		$userService->logout();

		Yii::app()->user->setFlash('success', yii::t('user', 'You have successfully signed out.'));
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * profile
	 */
	public function actionProfile()
	{
		if (Yii::app()->user->isGuest)
			$this->redirect(array('/user/login'));
			
		$userService 	= new UserService();
		$model 			= $userService->getUserId(Yii::app()->user->id);
		$sumSale 		= $userService->getSumOrderSeller(Yii::app()->user->id);

		$this->render('profile', array( 
			'model'=>$model,
			'sumSale'=>$sumSale,
		));
	}
	
	/**
	 * update
	*/
	public function actionUpdate()
	{
		if (Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->homeUrl);
		
		$userModel 		= new User();
		$userService 	= new UserService();
		$viewModel 		= new UserUpdateViewModel();
		$viewModel 		= $userService->getUserId(Yii::app()->user->id, $viewModel);

		$viewModel->birthday = Yii::app()->jdate->date('Y-m-d', strtotime($viewModel->birthday));
		
		if (isset($_POST['UserUpdateViewModel']))
		{
			$viewModel->attributes = $_POST['UserUpdateViewModel'];

			if ($viewModel->validate())
			{
				if ($userService->updateProfile(Yii::app()->user->id, $viewModel))
				{
					Yii::app()->user->setFlash('success', yii::t('form', 'Changes were successfully updated.'));
					$this->redirect(array('/user/profile'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'Changes were not updated.'));
				}
			}
		}
		
		$this->render('update', array(
			'viewModel'=>$viewModel,
			'userModel'=>$userModel,
		));
	}
	
	/**
	 * change password
	*/
	public function actionPassword()
	{
		if (Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->homeUrl);
		
		$userModel 		= new User();
		$userService 	= new UserService();
		$viewModel 		= new UserPasswordViewModel();
		
		if (isset($_POST['UserPasswordViewModel']))
		{
			$viewModel->attributes = $_POST['UserPasswordViewModel'];

			if ($viewModel->validate())
			{
				if ($userService->changePassword(Yii::app()->user->id, $viewModel))
				{
					Yii::app()->user->setFlash('success', yii::t('form', 'Changes were successfully updated.'));
					$this->redirect(array('/user/profile'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'Changes were not updated.'));
				}
			}
		}
		
		$this->render('password', array(
			'viewModel'=>$viewModel,
			'userModel'=>$userModel,
		));
	}
	
	/**
	 * Forget password
	*/
	public function actionForgetPassword()
	{
		if (!Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->homeUrl);
		
		$userService 	= new UserService();
		$viewModel 		= new ForgetPasswordViewModel();
		
		if (isset($_POST['ForgetPasswordViewModel']))
		{
			$viewModel->attributes = $_POST['ForgetPasswordViewModel'];

			if ($viewModel->validate())
			{
				if ($userService->forgetPassword($viewModel))
				{
					Yii::app()->user->setFlash('success', yii::t('form', 'برای تغییر کلمه عبور، پست الکترونیکی خود را بررسی نمایید.'));
					$this->redirect(array('/user/login'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'پست الکترونیکی وارد شده در سیستم موجود نمی باشد!'));
				}
			}
		}
		
		$this->render('forget', array(
			'viewModel'=>$viewModel,
		));
	}
	
	/**
	 * Reset password
	*/
	public function actionResetPassword($key)
	{
		if (!Yii::app()->user->isGuest)
			$this->redirect(Yii::app()->homeUrl);
		
		$userService 	= new UserService();
		$viewModel 		= new ResetPasswordViewModel();
		
		if (isset($_POST['ResetPasswordViewModel']))
		{
			$viewModel->attributes = $_POST['ResetPasswordViewModel'];

			if ($viewModel->validate())
			{
				if ($userService->resetPassword($key, $viewModel))
				{
					Yii::app()->user->setFlash('success', yii::t('form', 'Changes were successfully updated.'));
					$this->redirect(array('/user/login'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('form', 'Changes were not updated.').' از صفحه فراموشی کلمه عبور دوباره تلاش کنید.');
				}
			}
		}
		
		$this->render('reset', array(
			'viewModel'=>$viewModel,
		));
	}
	
	/**
	 * Active email
	*/
	public function actionActiveEmail($key)
	{	
		$userService = new UserService();
		$userModel = $userService->activeEmail($key);
		if($userModel)
		{
			Yii::app()->user->setFlash('success', 'اکانت شما با موفقیت فعال شد.');
				
			//auto login
			$loginModel = new LoginViewModel;
			$loginModel->username = $userModel->username;
			$loginModel->password = $userModel->password;
			
			if($userService->login($loginModel, false)) {
				return $this->redirect(array('/user/profile'));
			}
			
			return $this->redirect(Yii::app()->homeUrl);
		}

		Yii::app()->user->setFlash('error', 'اکانت شما فعال نشد!');
		return $this->redirect(Yii::app()->homeUrl);
	}
}