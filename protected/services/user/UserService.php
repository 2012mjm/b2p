<?php
class UserService
{
	/**
	 * Update last login time
	 */
	function updateLastVisitedTime() {
		$model = User::model()->findByPk(Yii::app()->user->id);
		$model->lastVisit = date('Y-m-d H:i:s');
		$model->update($model);
	}
	
	/**
	 * Login
	 */
	public function login($viewModel, $fromUser=true)
	{
		if($fromUser) {
			$password = Encrypt::encryptPassword(strtolower($viewModel->password));
		} else {
			$password = $viewModel->password;
		}

		$identity = new UserIdentity($viewModel->username, $password);
		$identity->authenticate();
		
		if($identity->errorCode === UserIdentity::ERROR_NONE)
		{
			$duration = $viewModel->rememberMe ? 3600*24*30 : 0; // 30 days

			Yii::app()->user->login($identity, $duration);
			$this->updateLastVisitedTime();
			return true;
		}
		else
		{
			return false;
		}
	}
	
	/**
	 * Signup
	 */
	public function signup($viewModel) {
		
		$userModel = new User;
		$userModel->attributes = $viewModel->attributes;

		//birthday
		if($viewModel->birthday) {
			list($y, $m, $d) = explode('-', $viewModel->birthday);
			list($gy, $gm, $gd) = Yii::app()->jdate->toGregorian($y, $m, $d);
			$userModel->birthday = $gy.'-'.$gm.'-'.$gd;
		} else {
			$userModel->birthday = null;
		}
		
		$userModel->password = Encrypt::encryptPassword($viewModel->password);
		$userModel->registrationDate = Yii::app()->jdate->date('Y-m-d H:i:s');
		$userModel->lastVisit = null;
		$userModel->status = 'inactive';
		$userModel->isVerifiedEmail = '0';
		
		if($userModel->save()) {
			return $userModel;
		}
		
		return false;
	}

	/**
	 * send mail for active email
	 * @param User $userModel
	 */
	public function sendMailForActiveEmail($userModel)
	{
		$userModel->randomKey 		= md5(time().'bia2projeh'.$userModel->email);
		$userModel->expiryRandomKey = date('Y-m-d H:i:s', time()+(3600*24));
	
		//send mail
		$to = $userModel->email;
		$subject = "بیا تو پروژه - فعال سازی پست الکترونیکی";
		$message = "دوست عزیز،<br><br>
ثبت نام حساب بیاتوپروژه شما با موفقیت انجام شد! برای فعالسازی حساب کاربری خود فقط کافیست روی لینک زیر کلیک نمایید:<br>
<a href=\"". Yii::app()->createAbsoluteUrl('/user/activeEmail', array('key'=>$userModel->randomKey)) ."\">لینک فعال سازی</a><br><br>
یا می‌توانید آدرس زیر را در مرورگر خود وارد نمایید:<br>
". Yii::app()->createAbsoluteUrl('/user/activeEmail', array('key'=>$userModel->randomKey));
		$headers = "From: " . Yii::app()->setting->adminEmail . "\r\n" .
				"Content-type: text/html; charset=UTF-8";

		mail($to,$subject,$message,$headers);
	
		return $userModel->save();
	}
	
	/**
	 * updateProfile user
	 */
	public function updateProfile($userId, $viewModel)
	{
		$userModel = User::model()->findByPk($userId);
		$userModel->attributes = $viewModel->attributes;

		//birthday
		if($viewModel->birthday) {
			list($y, $m, $d) = explode('-', $viewModel->birthday);
			list($gy, $gm, $gd) = Yii::app()->jdate->toGregorian($y, $m, $d);
			$userModel->birthday = $gy.'-'.$gm.'-'.$gd;
		} else {
			$userModel->birthday = null;
		}
		
		return $userModel->save();
	}
	
	/**
	 * updateProfile user
	 */
	public function changePassword($userId, $viewModel)
	{
		$userModel = User::model()->findByPk($userId);
		
		$oldPassword = Encrypt::encryptPassword($viewModel->oldPassword);
		if($userModel->password != $oldPassword) {
			return false;
		}

		$newPassword = Encrypt::encryptPassword($viewModel->password);
		$userModel->password = $newPassword;
		
		return $userModel->save();
	}
	
	/**
	 * Logout
	 */
	public function logout() {
		return Yii::app()->user->logout();
	}
	
	/**
	 * get user with id
	 */
	public function getUserId($id, $viewModel=null)
	{
		$model = User::model()->findByPk($id);
		
		if($viewModel !== null) {
			$viewModel->attributes = $model->attributes;
			return $viewModel;
		}
		else {
			return $model;
		}
	}
	
	/**
	 * get sum order seller
	 */
	public function getSumOrderSeller($sellerId)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('product.userId', $sellerId);
		$criteria->compare('t.status', 'accepted');
		$criteria->select = 'SUM(t.count * t.price) AS id';
		$criteria->together = true;
		$criteria->with[] = 'product';
		
		$model = Order::model()->find($criteria);
		
		if($model) {
			return $model->id;
		}
		return 0;
	}
	
	/**
	 * get users
	 */
	public function getUsers()
	{
		return User::model()->find();
	}
	
	/**
	 * Update User
	 */
	public function update($viewModel) {
		
		$userModel = new User;
		
		$userModel->attributes = $viewModel->attributes;
		$userModel->id = $viewModel->id;

		$userModel->setIsNewRecord(false);
		return $userModel->save(true);
	}
	
	/**
	 * Delete User
	 */
	public function delete($id)
	{	
		if($id != 1)
		{
			$model = User::model()->findByPk($id);
			if($model != null) {
				return $model->delete();
			}
		}
		
		return false;
	}

	/**
	 * Delete Users
	 * @param array $items
	 * example: array('2', '5')
	 */
	public function deletes($items)
	{	
		// unset admin in array
		if(($key = array_search('1', $items)) !== false) {
    		unset($items[$key]);
		}

		if($items != null)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id', $items);
			return User::model()->deleteAll($criteria);
		}
		
		return false;
	}

	/**
	 * change status Users
	 * @param array $items
	 * example: array('2', '5')
	 */
	public function statuses($items, $status)
	{	
		// unset admin in array
		if(($key = array_search('1', $items)) !== false) {
    		unset($items[$key]);
		}

		if($items != null)
		{
			$criteria = new CDbCriteria;
			$criteria->addInCondition('id', $items);
			//$criteria->compare('status', $status);
			return User::model()->updateAll(array('status'=>$status), $criteria);
		}
		
		return false;
	}
	
	public static function getvirtualCredit() {
		$model = User::model()->findByPk(Yii::app()->user->id);
		return $model->virtualCredit;
	}
	
	public function ordersSallerCriteria($sellerId)
	{
		$criteria = new CDbCriteria;
		$criteria->order = 't.id DESC';
		$criteria->together = true;
		$criteria->with[] = 'product';
		$criteria->compare('t.status', 'accepted');
		$criteria->compare('product.userId', $sellerId);
		return $criteria;
	}
	
	public function forgetPassword($viewModel)
	{
		$userModel = User::model()->findByAttributes(array('email'=>trim($viewModel->email)));
		if($userModel == null) return false;

		$userModel->randomKey 		= md5(time().'bia2projeh'.$userModel->email);
		$userModel->expiryRandomKey = date('Y-m-d H:i:s', time()+3600);
		
		//send mail
		$to = $userModel->email;
		$subject = "بیا تو پروژه - فراموشی کلمه عبور";
		$message = "برای تغییر کلمه عبور <a href=\"". Yii::app()->createAbsoluteUrl('/user/resetPassword', array('key'=>$userModel->randomKey)) ."\">اینجا</a> کلیک کنید.";
		$headers = "From: " . Yii::app()->setting->adminEmail . "\r\n" .
				"Content-type: text/html; charset=UTF-8";
		
		mail($to,$subject,$message,$headers);

		return $userModel->save();
	}
	
	public function resetPassword($key, $viewModel)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('randomKey', $key);
		$criteria->compare('expiryRandomKey', '>='.date('Y-m-d H:i:s'));
		
		$userModel = User::model()->find($criteria);
		if($userModel == null) return false;

		$userModel->randomKey 		= null;
		$userModel->expiryRandomKey = null;
		$userModel->password 		= Encrypt::encryptPassword($viewModel->password);

		return $userModel->save();
	}
	
	public function activeEmail($key)
	{
		$criteria = new CDbCriteria;
		$criteria->compare('randomKey', $key);
		$criteria->compare('expiryRandomKey', '>='.date('Y-m-d H:i:s'));
		
		$userModel = User::model()->find($criteria);
		if($userModel == null) return false;

		$userModel->randomKey 		= null;
		$userModel->expiryRandomKey = null;
		$userModel->isVerifiedEmail = '1';
		$userModel->status = 'active';

		if($userModel->save()) {
			return $userModel;
		}
		
		return false;
	}
}
?>