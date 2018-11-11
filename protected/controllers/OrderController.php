<?php

class OrderController extends Controller
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
						'actions' => array('index', 'view', 'report'),
				),
				array('allow', // allow all users to access all actions.
						'users' => array('*'),
						'actions' => array('verify'),
				),
				array('deny', // allow all visitors to access all actions.
						'users' => array('*'),
				),
		);
	}

	public function actionIndex()
	{
		$orderService = new OrderService();
		$viewModelReport = new ReportViewModel(); 

		// get orders user
		$orderDataProvider = $orderService->getOrdersByUserId(Yii::app()->user->id);

		$this->render('index', array(
			'orderDataProvider'=>$orderDataProvider,
			'viewModelReport'=>$viewModelReport,
		));
	}

	/**
	 * *************************************************
	 */
	public function actionView($id)
	{
		$orderService = new OrderService();

		// get order user
		$model = $orderService->getOrderById($id, Yii::app()->user->id);
		
		// get products
		$getProductsOrder = $orderService->getProductsOrder($model);
		
		$this->render('view', array(
			'model'=>$model,
			'products'=>$getProductsOrder['arrayProducts'],
			'totalCount'=>$getProductsOrder['totalCount'],
			'totalCost'=>$getProductsOrder['totalCost'],
			'updateStatusOrder'=>$updateStatusOrder
		));
	}
	
	/**
	 * **************** ZARIN PAL *********************************
	 */
// 	public function actionVerify()
// 	{
// 		$results = array();

// 		if(isset($_GET['Status']))
// 		{
// 			$orderService = new OrderService();
// 			$paymentModel = $orderService->getPayment($_GET['Authority']);
	
// 			if($_GET['Status'] == 'OK' AND $paymentModel != null) {
// 				$receive = $orderService->receiveFromZarinPal($_GET['Authority'], $paymentModel->price, $_GET['Status']); //$paymentModel->price : Rial
	
// 				if($receive['statusCode'] == 100) {
// 					//update orders
// 					$results = $orderService->completeOrdersAndGetLinksDownload($paymentModel->id);
						
// 					//give download link
// 					$message = 'پرداخت با موفقیت انجام شد ، شماره رسید پرداخت : '.$receive['reffererCode'].' ،  مبلغ پرداختی : '.Yii::app()->format->formatPrice($paymentModel->price/10); //$receive['payPrice'] : Toman, convert Rial to Toman

// 					//empty basket
// 					Yii::app()->shoppingCart->clear();
// 				}
// 				else {
// 					$message = 'خطا در پردازش عملیات پرداخت ، نتیجه پرداخت '.$receive['statusCode'];
// 				}
	
// 				$reffererCode = $receive['reffererCode'];
// 			}
// 			else {
// 				$message = 'بازگشت از عمليات پرداخت، خطا در انجام عملیات پرداخت ( پرداخت ناموق ) !';
// 			}
				
// 			//update payment
// 			$paymentModel->reffererCode = (isset($receive['reffererCode'])) ? $receive['reffererCode'] : '0';
// 			$paymentModel->statusCode 	= (isset($receive['statusCode'])) ? $receive['statusCode'] : 0;
// 			$paymentModel->status 		= (isset($receive['status'])) ? $receive['status'] : $_GET['Status'];
// 			$paymentModel->save();
// 		}
// 		else {
// 			$message = 'درخواستی از سیستم پرداخت بانک دریافت نشد!';
// 		}
	
	
// 		$this->render('verify', array(
// 			'results'=>$results,
// 			'message'=>$message,
// 		));
// 	}

	/**
	 * **************** PARS PAL *********************************
	 */
	public function actionVerify()
	{
		$results = array();
	
// 		$_POST = array('status'=>100, 'refnumber'=>'764123452', 'resnumber'=>'1206959891');
		if(isset($_POST['status']))
		{
			$orderService = new OrderService();
			$paymentModel = $orderService->getPayment($_POST['resnumber']);
		
			if($_POST['status'] == 100 AND $paymentModel != null) {
				$receive = $orderService->receiveFromParsPal($_POST, $paymentModel->price); //$paymentModel->price : Rial
				
				if(strtolower($receive['status']) == 'success') {
					if($receive['payPrice'] >= $receive['price'])
					{
						//update orders
						$results = $orderService->completeOrdersAndGetLinksDownload($paymentModel->id);
						
						//send mail
						$orderService->sendMail($results);
					
						//give download link
						$message = 'پرداخت با موفقیت انجام شد ، شماره رسید پرداخت : '.$receive['reffererCode'].' ،  مبلغ پرداختی : '.Yii::app()->format->formatPrice($receive['payPrice']); //$receive['payPrice'] : Toman, convert Rial to Toman
					
						if (!Yii::app()->user->isGuest && $receive['payPrice'] > $receive['price']) {
							$orderService->updateVirtualCredit(Yii::app()->user->id, $receive['payPrice'] - $receive['price']);
						}

						//empty basket
						Yii::app()->shoppingCart->clear();
					}
					else {
						$message = 'پرداخت با موفقیت انجام شد ، شماره رسید پرداخت : '.$receive['reffererCode'].' ،  مبلغ پرداختی : '.Yii::app()->format->formatPrice($receive['payPrice']).'<br>'; //$receive['payPrice'] : Rial, convert Rial to Toman
						$message .= 'شما هزینه ای کمتر از هزینه این سفارش پرداخت کرده اید!<br>';
						$message .= 'اگر مشکلی وجود دارد با مدیریت سایت تماس بگیرید.';
						
						if (!Yii::app()->user->isGuest) {
							$orderService->updateVirtualCredit(Yii::app()->user->id, $receive['payPrice']); //$receive['payPrice'] : Rial
						}
					}
				}
				else {
					$message = 'خطا در پردازش عملیات پرداخت ، نتیجه پرداخت '.$receive['status'];
				}

				$reffererCode = $receive['reffererCode'];
			}
			else {
				$message = 'بازگشت از عمليات پرداخت، خطا در انجام عملیات پرداخت ( پرداخت ناموق ) !';
			}
			
			//update payment
			$paymentModel->reffererCode = (isset($receive['reffererCode'])) ? $receive['reffererCode'] : '0';
			$paymentModel->statusCode 	= $_POST['status'];
			$paymentModel->status 		= (isset($receive['status'])) ? $receive['status'] : null;
			$paymentModel->save();
		}
		else {
			$message = 'درخواستی از سیستم پرداخت بانک دریافت نشد!';
		}
		
		
		$this->render('verify', array(
			'results'=>$results,
			'message'=>$message,
		));
	}

	/**
	 * *************************************************
	 */
	public function actionReport($id, $pid)
	{
		$reportService = new ReportService();
		$orderService = new OrderService();
		
		if(!$orderService->checkOrderByIdAndPidForReport($id, $pid)) {
			Yii::app()->user->setFlash('error', yii::t('report', 'Access deny!'));
			$this->redirect('index');
		}

		$viewModelReport = new ReportViewModel();
		if(isset($_POST['ReportViewModel']))
		{
			$viewModelReport->setAttributes($_POST['ReportViewModel']);
			$viewModelReport->orderId = $id;
			$viewModelReport->productId = $pid;
			
			if($viewModelReport->validate())
			{
				if($reportService->create($viewModelReport)) {
					Yii::app()->user->setFlash('success', yii::t('report', 'You have successfully submitted a report for management.'));
				}
				else {
					Yii::app()->user->setFlash('error', yii::t('report', 'Problem sending Report.'));
				}
			}
			else {
				Yii::app()->user->setFlash('error', $viewModelReport->getError('description'));
			}
		}
		
		$this->redirect(array('index'));
	}
}

?>