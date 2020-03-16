<?php
class OrderService
{
	public function __construct() {
	}

	/**
	 * ************************************
	 */
	public static function fillPostalBuy($orderViewModel) {
		$userModel = User::model()->findByPk(Yii::app()->user->id);

		$orderViewModel->email = $userModel->email;
		
		return $orderViewModel;
	}
	
	/**
	 * ************************************
	 */
	public function savePayment() {
		$model = new Payment();
			
		$model->trackingCode 	= $this->generateTrackingCodePayment();
		$model->reffererCode 	= '0';
		$model->price 			= 0;
		$model->statusCode 		= 0;
// 		$model->type			= 'zarinpal';
		$model->type			= 'parspal';

		if($model->save()) {	
			return $model;
		}
		return false;
	}
	
	/**
	 * ************************************
	 */
	public function getPayment($trackingCode)
	{
		if($trackingCode == null || empty($trackingCode) || !$trackingCode || $trackingCode == '')
			return null;
	
		$model = Payment::model()->findByAttributes(array('trackingCode'=>$trackingCode));
		return $model;
	}
	
	/**
	 * ************************************
	 */
	public function saveOrder($paymentId, $id, $count, $viewModel) {
		$model = new Order();

		$model->setAttributes($viewModel->attributes);
		
		$productModel = ProductService::getProductDetail($id);
		if($productModel == null)
			return false;
			
		$model->paymentId 		= $paymentId;
		$model->productId 		= $productModel->id;
		$model->projehFileId 	= $productModel->projehFileId;
		$model->price 			= $productModel->price;
		$model->count 			= $count;
		$model->trackingCode 	= $this->generateTrackingCode();
		$model->linkDownload 	= $this->generateDownloadLink();
		$model->systemComission	= Yii::app()->setting->comission;
		$model->ip 				= Yii::app()->request->userHostAddress;
		$model->productOwnerIsRead = 0;

		if($model->save()) {
			return $count * $model->price;
		}
		
		return false;
	}

	// get orders user
	public function getOrdersByUserId($userId)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('t.userId', $userId);
		$criteria->order = 't.id DESC';
		$criteria->limit = 10;
		
		$orderDataProvider = new CActiveDataProvider('Order', array(
			'criteria'=>$criteria,
		    'pagination'=>array(
		        'pageSize'=>10,
		    ),
		));
		
		return $orderDataProvider;
	}
	
	// update orders user
	public function updateStatusOrders($userId)
	{
		$flagUpdate = false;
		
		$criteria = new CDbCriteria();
		$criteria->compare('t.userId', $userId);
		$criteria->compare('t.trackingImcStatus', '<>انصرافي');
		
		$models = Order::model()->findAll($criteria);
		if($models)
		{
			foreach ($models as $model) {
				$result = $this->trackingCheck($model->trackingImcCode);

				if($result) {
					//update status
					$model->trackingImcStatus 		= $result['trackingImcStatus']['value'];
					$model->dateLastChangeStatus 	= $result['dateLastChangeStatus']['value'];
					$model->sellerName 				= $result['sellerName']['value'];
					$model->sellerMobile 			= $result['sellerMobile']['value'];
					$model->sellerPhone 			= $result['sellerPhone']['value'];
					$model->sellerEmail 			= $result['sellerEmail']['value'];
					$model->trackingPostalCode 		= $result['trackingPostalCode']['value'];
					$model->reasonDissuasion 		= (isset($result['reasonDissuasion']['value'])) ? $result['reasonDissuasion']['value'] : null;

					$model->update();
					$flagUpdate = true;
				}
			}
		}

		return $flagUpdate;
	}
	
	// get order by id
	public function getOrderById($id, $userId=null)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('t.id', $id);

		if($userId) {
			$criteria->compare('t.userId', $userId);
		}
		
		$model = Order::model()->find($criteria);
		
		return $model;
	}
	
	// check order by order id & product id
	public function checkOrderByIdAndPidForReport($orderId, $productId)
	{
		$criteria = new CDbCriteria();
		$criteria->compare('t.id', $orderId);
		$criteria->compare('t.productId', $productId);
		$criteria->compare('t.userId', Yii::app()->user->getId());
		$criteria->compare('t.status', 'accepted');
		$criteria->with[] = 'reports';
		$criteria->together = true;
		
		$model = Order::model()->find($criteria);
		
		if($model AND $model->reports == null) {
			return true;
		}
		
		return false;
	}
	
	// get products of order
	public function getProductsOrder($orderModel)
	{
		$arrayProducts 	= array();
		$totalCount 	= 0;
		$totalCost		= 0;

		if($orderModel) {
			foreach ($orderModel->orderProducts as $product) {
				$arrayProducts[] = array(
					'id'=>$product->vendorId.$product->imcId,
					'imcId'=>$product->imcId,
					'title'=>$product->title,
					'vendor'=>$product->vendorName,
					'vendorId'=>$product->vendorId,
					'price'=>$product->price,
					'quantity'=>$product->count,
					'sumPrice'=>$product->price * $product->count,
				);
				
				$totalCount += (int) $product->count;
				$totalCost += (int) $product->price * $product->count;
			}
		}
		
		return array(
			'arrayProducts'=>$arrayProducts,
			'totalCount'=>$totalCount,
			'totalCost'=>$totalCost,
		);
	}
	
	// update order user
	public function updateStatusOrderById($id, $userId=null)
	{
		$flagUpdate = false;
		
		$criteria = new CDbCriteria();
		$criteria->compare('t.id', $id);
		$criteria->compare('t.trackingImcStatus', '<>انصرافي');

		if($userId) {
			$criteria->compare('t.userId', $userId);
		}
		
		$model = Order::model()->find($criteria);
		if($model)
		{
			$result = $this->trackingCheck($model->trackingImcCode);

			if($result) {
				//update status
				$model->trackingImcStatus 		= $result['trackingImcStatus']['value'];
				$model->dateLastChangeStatus 	= $result['dateLastChangeStatus']['value'];
				$model->sellerName 				= $result['sellerName']['value'];
				$model->sellerMobile 			= $result['sellerMobile']['value'];
				$model->sellerPhone 			= $result['sellerPhone']['value'];
				$model->sellerEmail 			= $result['sellerEmail']['value'];
				$model->trackingPostalCode 		= $result['trackingPostalCode']['value'];
				$model->reasonDissuasion 		= $result['reasonDissuasion']['value'];

				$model->update();
				$flagUpdate = true;
			}
		}

		return $flagUpdate;
	}
	
	/**
	 * ******************************************
	 */
	public function generateTrackingCode() {
		do {
			$trackingCode = '14-'.rand(1000, 9999).'-'.rand(1000, 9999).'-'.rand(100000, 999999);
		}
		while($this->checkUniqueTrackingCode($trackingCode));
		
		return $trackingCode;
	}
	
	private function checkUniqueTrackingCode($trackingCode) {
		if(Order::model()->findByAttributes(array('trackingCode'=>$trackingCode)))
			return true;
		else 
			return false;
	}
	
	/**
	 * ******************************************
	 */
	public static function generateDownloadLink() {
		do {
			$downloadLink = self::createRandomName(rand(15, 20));
		}
		while(self::checkUniqueDownloadLink($downloadLink));
		
		return $downloadLink;
	}
	
	private static function checkUniqueDownloadLink($downloadLink) {
		if(Order::model()->findByAttributes(array('linkDownload'=>$downloadLink)))
			return true;
		else 
			return false;
	}
	
	/**
	 * ******************************************
	 */
	private static function createRandomName($length)
	{
	    $key = '';
	    $keys = array_merge(range(0, 9), range('a', 'z'));
	
	    for ($i = 0; $i < $length; $i++) {
	        $key .= $keys[array_rand($keys)];
	    }
	
	    return $key;
	}
	
	/**
	 * ******************************************
	 */
	public function generateTrackingCodePayment() {
		do {
			$trackingCode = rand(1000000000, 9999999999);
		}
		while($this->checkUniqueTrackingCodePayment($trackingCode));
		
		return $trackingCode;
	}
	
	private function checkUniqueTrackingCodePayment($trackingCode) {
		if(Payment::model()->findByAttributes(array('trackingCode'=>$trackingCode)))
			return true;
		else 
			return false;
	}
	
	/**
	 * ************* PARS PAL ****************
	 */
	public function sendToParsPal($paymentModel)
	{
		$client = new SoapClient('http://merchant.arianpal.com/WebService.asmx?wsdl');

		$res = $client->RequestPayment(array(
			'MerchantID' 	=> Yii::app()->setting->parsPalMerchantID,
			'Password' 		=> Yii::app()->setting->parsPalPassword,
			'Price' 		=> $paymentModel->price/10,
			'ReturnPath' 	=> Yii::app()->createAbsoluteUrl('order/verify'),
			'ResNumber' 	=> $paymentModel->trackingCode,
			'Description' 	=> null,
			'Paymenter' 	=> Yii::app()->setting->adminName,
			'Email' 		=> Yii::app()->setting->adminEmail,
			'Mobile'	 	=> Yii::app()->setting->adminPhone
		));

		$PayPath = $res->RequestPaymentResult->PaymentPath;
		$Status = $res->RequestPaymentResult->ResultStatus;
	
		if($Status == 'Succeed') {
			$cHttpRequest = new CHttpRequest;
			$cHttpRequest->redirect($PayPath);
			//die ("<html><head><title>Connecting ....</title><head><body onload=\"javascript:window.location='$PayPath'\" style=\"font-family:tahoma; text-align:center;font-waight:bold;direction:rtl\">درحال اتصال به درگاه پرداخت پارس پال ...</body></html>"); 
		} else {
			return $Status; 
		}
	}
	
	/**
	 * ************* PARS PAL ****************
	 */
	public function sendToRestParsPal($paymentModel)
	{
		$postData = array(
			'amount' 		=> $paymentModel->price/10,
			'return_url' 	=> Yii::app()->createAbsoluteUrl('order/verify'),
			'order_id' 		=> $paymentModel->trackingCode,
			'description' 	=> null,
			'reserve_id' 	=> null,
		);

		$curl = curl_init();

		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_URL, "https://api.parspal.com/v1/payment/request");
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    		"APIKEY: " . Yii::app()->setting->parsPalMerchantID,
    		"Content-Type: application/json"
		));

		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$result = curl_exec($curl);

		if (!$result) {
    		return "در ارتباط با سیستم پرداخت بانک مشکلی پیش آمده است!";
		}

		curl_close($curl);
		$response = json_decode($result, true);
		$status  = $response["status"];
		if ($status != "ACCEPTED") {
			$message = $response["message"];// توضیحات فارسی در رابطه با وضعیت درخواست
			return "خطا در ثبت درخواست پرداخت! وضعیت خطا : " . $status . " - توضیحات : " . $message;	
		}

		$payment_link = $response["link"];// مسیر پرداخت
		$payment_id   = $response["payment_id"];// شناسه یا کد پیگیری درخواست پرداخت که می توانید در بازگشت و یا در مواردی برای استعلام از آن استفاده نمایید

		$cHttpRequest = new CHttpRequest;
		return $cHttpRequest->redirect($payment_link);
	}

	/**
	 * *************** ZARIN PAL **************
	 */
	public function sendToZarinPal($paymentModel)
	{
		//German node
		$client = new SoapClient('https://de.zarinpal.com/pg/services/WebGate/wsdl', array('encoding' => 'UTF-8'));
	
		//Iran node
		//$client = new SoapClient('https://ir.zarinpal.com/pg/services/WebGate/wsdl', array('encoding' => 'UTF-8'));
	
		$result = $client->PaymentRequest(array(
			'MerchantID' 	=> Yii::app()->setting->zarinPalMerchantID,
			'Amount' 		=> $paymentModel->price/10,
			'Description' 	=> 'درگاه پرداخت '.Yii::app()->setting->siteName,
			'Email' 		=> Yii::app()->setting->adminEmail,
			'Mobile'	 	=> Yii::app()->setting->adminPhone,
			'CallbackURL' 	=> Yii::app()->createAbsoluteUrl('order/verify'),
		));
	
		if($result->Status == 100)
		{
			//update payment with tarcking code
			$paymentModel->trackingCode = $result->Authority;
			if(!$paymentModel->save()) {
				return 'payment not save in database';
			}
	
			//Redirect to URL
			$cHttpRequest = new CHttpRequest;
			$cHttpRequest->redirect('https://www.zarinpal.com/pg/StartPay/'.$result->Authority);
		}
		else {
			return $result->Status;
		}
	}
	
	/**
	 * *********************** PARS PAL ************************
	 * @param unknown $post
	 * @param unknown $price
	 * @return multitype:number unknown unknown
	 */
	public function receiveFromParsPal($post, $price)
	{
		$StatusCode = $post['status'];
		$Refnumber 	= $post['refnumber'];
		$Resnumber 	= $post['resnumber'];

		$client = new SoapClient('http://merchant.arianpal.com/WebService.asmx?wsdl');
		
		$res = $client->VerifyPayment(array(
			"MerchantID" 	=> Yii::app()->setting->parsPalMerchantID,
			"Password" 		=> Yii::app()->setting->parsPalPassword,
			"Price" 		=> $price/10, //convert Rial to Toman
			"RefNum" 		=> $Refnumber
		));
		
		$StatusRes = $res->verifyPaymentResult->ResultStatus;
		$PayPrice = $res->verifyPaymentResult->PayementedPrice;

		return array(
			'payPrice'=>$PayPrice*10, //convert Toman to Rial
			'status'=>$StatusRes,
			'reffererCode'=>$Refnumber,
			'trackingCode'=>$Resnumber,
			'price'=>$price, //$price : Rial
			'statusCode'=>$StatusCode,
		);
	}

	/**
	 * *********************** PARS PAL ************************
	 * @param unknown $post
	 * @param unknown $price
	 * @return multitype:number unknown unknown
	 */
	public function receiveRestFromParsPal($post, $price)
	{
		$receiptNumber = $post["receipt_number"];
		$orderId       = $post["order_id"];
		$statusCode    = $post["status"];

		$postData = array(
			'amount' => $price/10,
			'receipt_number' => $receiptNumber
		);

		$curl = curl_init();
		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_URL, 'https://api.parspal.com/v1/payment/verify');
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			"APIKEY: " . Yii::app()->setting->parsPalMerchantID,
			"Content-Type: application/json"
		));
		curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($postData));
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

		$result = curl_exec($curl);
		if (!$result) {
			return "خطای درگاه بانک";
		}

		curl_close($curl);
		$response = json_decode($result, true);
		$status  = $response["status"];

		// if ($status == "SUCCESSFUL") {
		// 	echo "پرداخت با شماره رسید " . $receiptNumber . " با موفقیت تایید گردید";
		// } else {
		// 	$message = $response["message"];// توضیحات فارسی در رابطه با وضعیت درخواست
		// 	echo "خطا در تایید رسید پرداخت ! وضعیت خطا : " . $status . " - توضیحات : " . $message;
		// }

		return array(
			'payPrice'		=> $price,
			'status'		=> $status,
			'reffererCode'	=> $receiptNumber,
			'trackingCode'	=> $orderId,
			'price'			=> $price,
			'statusCode'	=> $statusCode,
		);
	}
	
	/**
	 * *****************************
	 * only for test
	 */
	public function receiveFromParsPal2($post, $price)
	{
		$StatusCode = $post['status'];
		$Refnumber 	= $post['refnumber'];
		$Resnumber 	= $post['resnumber'];

		/*$client = new SoapClient('http://merchant.parspal.org/WebService.asmx?wsdl');
		
		$res = $client->VerifyPayment(array(
			"MerchantID" 	=> Yii::app()->setting->parsPalMerchantID,
			"Password" 		=> Yii::app()->setting->parsPalPassword,
			"Price" 		=> $price,
			"RefNum" 		=> $Refnumber
		));*/
		
		$StatusRes = 'success';
		$PayPrice = $price;
		
		return array(
			'payPrice'=>$PayPrice,
			'status'=>$StatusRes,
			'reffererCode'=>$Refnumber,
			'trackingCode'=>$Resnumber,
			'price'=>$price,
			'statusCode'=>$StatusCode,
		);
	}

	/**
	 * ************************* ZARIN PAL *********************
	 * @param unknown $Authority
	 * @param unknown $price
	 * @param unknown $StatusRes
	 * @return multitype:number unknown NULL
	 */
	public function receiveFromZarinPal($Authority, $price, $StatusRes)
	{
		//German node
		$client = new SoapClient('https://de.zarinpal.com/pg/services/WebGate/wsdl', array('encoding' => 'UTF-8'));
		
		//Iran node
		//$client = new SoapClient('https://ir.zarinpal.com/pg/services/WebGate/wsdl', array('encoding' => 'UTF-8'));
	
		$result = $client->PaymentVerification(array(
				"MerchantID" 	=> Yii::app()->setting->zarinPalMerchantID,
				"Amount" 		=> $price/10, //convert Rial to Toman
				"Authority" 	=> $Authority
		));
	
		return array(
			'status'=>$StatusRes,
			'reffererCode'=>$result->RefID,
			'trackingCode'=>$Authority,
			'statusCode'=>$result->Status,
		);
	}
	
	
	/**
	 * *****************************
	 */
	public function completeOrdersAndGetLinksDownload($paymentId)
	{
		$results = array();
		$models = Order::model()->with(array('product', 'product.user'))->findAllByAttributes(array('paymentId'=>$paymentId));
		
		if($models) {
			foreach($models as $model) {
				$model->status = 'accepted';
				$model->save();
				
				//add count sell "product" table
				$model->product->countSell += $model->count;
				$model->product->save();
				
				//add virtual credit author product "user" table
				$comissionSystem = Yii::app()->setting->comission;
				$comissionSystemCal = (100 - $comissionSystem) / 100;
				$model->product->user->virtualCredit += $comissionSystemCal * $model->price * $model->count;
				$model->product->user->save();
				
				//send mail
				$to = $model->product->user->email;
				$subject = "خرید پروژه ". $model->product->title ." در بیا تو پروژه";
				$message = "پروژه شما با عنوان ".$model->product->title." در سایت بیا تو پروژه به فروش رفته است." . "\r\n";
				$message .= "برای اطلاعات بیشتر <a href=\"". Yii::app()->createAbsoluteUrl('/sale/index') ."\">اینجا</a> کلیک کنید.";
				$headers = "From: " . Yii::app()->setting->adminEmail . "\r\n" .
						"Content-type: text/html; charset=UTF-8";
				mail($to,$subject,$message,$headers);
				
				$results[] = array(
					'linkDownload'=>$model->linkDownload,
					'trackingCode'=>$model->trackingCode,
					'productId'=>$model->productId,
					'productTitle'=>$model->product->title,
					'buyerEmail'=>$model->email,
				);
			}
		}
		
		return $results;
	}
	
	public function sendMail($results)
	{
		foreach($results as $result)
		{
			$message .= '<strong>'.Yii::t('product', 'Product Title').'</strong>: ';
			$message .= '<a target="_blank" href="'.Yii::app()->createAbsoluteUrl('/product/view', array('id'=>$result['productId'], 'title'=>Text::generateSeoUrlPersian($result['productTitle']))).'"><strong>'.$result['productTitle'].'</strong></a>';
			$message .= '<br>';
			$message .= '<a target="_blank" href="'.Yii::app()->createAbsoluteUrl('/main/download', array('key'=>$result['linkDownload'])).'"><strong>'.Yii::t('product', 'Download Link').'</strong></a>';
			$message .= '<br>';
			$message .= 'کد پیگیری: '.$result['trackingCode'];
			$message .= '<br><hr><br>';
			
			if(!empty($result['buyerEmail'])) {
				$buyerEmail = $result['buyerEmail'];
			}
		}
		
		if(!empty($buyerEmail)) {
			$to = $buyerEmail;
			$subject = "لینک دانلود پروژه در سایت بیا تو پروژه";
			$headers = "From: " . Yii::app()->setting->adminEmail . "\r\n" .
					"Content-type: text/html; charset=UTF-8";
			
			return mail($to,$subject,$message,$headers);
		}
		return false;
	}
	
	
	/**
	 * *****************************
	 */
	public function updateVirtualCredit($userId, $credit)
	{
		$model = User::model()->findByPk($userId);
		$model->virtualCredit += $credit;
		$model->save();
	}
	
	/**
	 * *****************************
	 */
	public function download($key)
	{
		if($key == null || empty($key) || !$key || $key == '')
			return null;
	
		$model = Order::model()->with('projehFile')->findByAttributes(array('linkDownload'=>$key));
		return $model;
	}
	
	
	
	// tracking check
	public function trackingCheck($code)
	{
		$model = Order::model()->with('product')->findByAttributes(array('trackingCode'=>$code));
		return $model;
	}
	
	public static function countManageUnread()
	{
		$criteria = new CDbCriteria;
		$criteria->compare('isRead', '0');
		$criteria->compare('status', 'accepted');

		return Order::model()->count($criteria);
	}
	
	public static function countOwnerUnread()
	{
		$criteria = new CDbCriteria;
		$criteria->with[] = 'product';
		$criteria->compare('t.status', 'accepted');
		$criteria->compare('t.productOwnerIsRead', '0');
		$criteria->compare('product.userId', Yii::app()->user->id);

		return Order::model()->count($criteria);
	}
	
	public static function isReadOwnerUnread()
	{
		// update all is read
		$criteria = new CDbCriteria;
		$criteria->with[] = 'product';
		$criteria->compare('t.status', 'accepted');
		$criteria->compare('t.productOwnerIsRead', '0');
		$criteria->compare('product.userId', Yii::app()->user->id);
		$modelsUnread = Order::model()->findAll($criteria);
		if($modelsUnread) {
			foreach ($modelsUnread as $modelUnread) {
				$modelUnread->productOwnerIsRead = 1;
				$modelUnread->save();
			}
		}
	}
	
	/**
	 * get sum order
	 */
	public function getTotalPay()
	{
		$criteria = new CDbCriteria();
		$criteria->compare('t.status', 'accepted');
		$criteria->select = 'SUM(t.count * t.price) AS price, COUNT(t.id) AS id';
		
		$model = Order::model()->find($criteria);
		
		if($model) {
			return array(
				'count' => $model->id,
				'total' => $model->price,
				'comission' => $model->price * Yii::app()->setting->comission / 100
			);
		}
		return 0;
	}
}
?>