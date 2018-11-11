<?php

class SaleController extends Controller
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

	public function actionIndex()
	{
		$userService = new UserService();

		$id = Yii::app()->user->id;

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

		$this->render('index',array(
			'dataProviderOrder'=>$dataProviderOrder,
			'totalCount'=>$totalCount,
			'totalSalePrice'=>$totalSalePrice,
			'totalSalePriceWithCommission'=>$totalSalePriceWithCommission,
		));
	}
}

?>