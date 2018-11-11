<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->siteTitle=Yii::app()->name . ' - '.yii::t('main', 'My Orders');

switch ($model->trackingImcStatus) {
	case 'معلق' :
		$descStatus = 'سفارش ثبت شده است ولی فروشنده تاکنون اقدامی برای ارسال آن انجام نداده است.';
		break;
	case 'آماده به ارسال' :
		$descStatus = 'سفارش توسط فروشنده بسته بندی شده است و به زودی به مامور پست تحویل داده می شود.';
		break;
	case 'ارسال شده' :
		$descStatus = 'توسط پست مبدا به آدرس مقصد ارسال شده است و به زودی تحویل خریدار خواهد شد. برای اطلاع دقیق از وضعیت سفارش میتوانید با مراجعه به سایت پست به آدرس <a href="http://tntsearch.post.ir" target="_blank">http://tntsearch.post.ir</a> و یا با تماس تلفنی با اداره پست منطقه خود و با ارائه کد ره گیری پستی، سفارش خود را رهگیری نمایید.';
		break;
	case 'توزیع شده' :
		$descStatus = 'سفارش به دست خریدار رسیده است.';
		break;
	case 'وصول شده' :
		$descStatus = 'مبلغ سفارش وصول شده است.';
		break;
	case 'برگشتي' :
		$descStatus = 'سفارش توسط پست مقصد برگشت شده و تحویل فروشنده شده است.';
		break;
	case 'انصرافي' :
		$descStatus = 'فروشنده از ارسال سفارش خود داری نموده است.';
		break;
}
?>

<h1><?php echo CHtml::link(yii::t('main', 'My Orders'), array('/order/index')); ?></h1>
<br />

<?php if($model) : ?>
	
	<?php if($updateStatusOrder) : ?>
		<blockquote>
			<p>وضعیت این سفارش در تاریخ <strong style="background-color: #F8F8F8"><?php echo Yii::app()->jdate->date("j F Y"); ?></strong> و در ساعت <strong style="background-color: #F8F8F8"><?php echo Yii::app()->jdate->date("g:i a"); ?></strong> بروز رسانی شد.</p>
		</blockquote>
		<br />
	<?php endif; ?>
	
	<?php
		$this->widget('bootstrap.widgets.TbDetailView', array(
		    'data'=>$model,
		    'attributes'=>array(
		        'vendorName',
		        'trackingImcCode',
		        array(
		        	'name'=>'trackingImcStatus',
		        	'value'=>$model->trackingImcStatus.'<br /><blockquote style="margin: 0"><small>'.$descStatus.'</small></blockquote>',
		        	'type'=>'raw',
		       	),
		        'trackingPostalCode',
		        array(
		        	'name'=>'postType',
		        	'value'=>Yii::t('order', $model->postType),
		       	),
		        array(
		        	'name'=>'costSend',
		        	'value'=>Yii::app()->format->formatPrice($model->costSend),
		        	'type'=>'raw',
		       	),
		        array(
		        	'name'=>'costService',
		        	'value'=>Yii::app()->format->formatPrice($model->costService),
		        	'type'=>'raw',
		       	),
		        array(
		        	'name'=>'costTotal',
		        	'value'=>Yii::app()->format->formatPrice($model->costTotal),
		        	'type'=>'raw',
		       	),
		        array(
		        	'name'=>'creationDate',
		        	'value'=>Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->creationDate)),
		        	'type'=>'raw',
		       	),
		        'dateLastChangeStatus',
		        'reasonDissuasion',
		    ),
		));
	?>
	
	<br />
	<blockquote>
		<h3>مشخصات فروشنده</h3>
	</blockquote>
	
	<?php
		$this->widget('bootstrap.widgets.TbDetailView', array(
		    'data'=>$model,
		    'attributes'=>array(
		        'sellerName',
		        'sellerMobile',
		        'sellerPhone',
		        'sellerEmail',
		    ),
		));
	?>
	
	<br />
	<blockquote>
		<h3>مشخصات خریدار</h3>
	</blockquote>
	
	<?php
		$this->widget('bootstrap.widgets.TbDetailView', array(
		    'data'=>$model,
		    'attributes'=>array(
		        'firstName',
		        'lastName',
		        'phoneHome',
		        'phoneWork',
		        'mobile',
		        'email',
		        'province.name',
		        'city.name',
		        'postalCode',
		        'address',
		    ),
		));
	?>
	
	<br />
	<blockquote>
		<h3>مشخصات محصولات</h3>
	</blockquote>

	<?php
		$this->widget('bootstrap.widgets.TbGridView', array(
			'type'=>'striped',
			'id'=>'products-order-grid',
			'dataProvider'=>new CArrayDataProvider($products),
			'template'=>"{items}",
			'columns'=>array(
				array(
					'name'=>'name',
					'header'=>Yii::t('product', 'Product Name'),
					'type'=>'raw',
					'value' => 'CHtml::link(CHtml::encode($data["title"]), array("product/view", "vendor"=>$data["vendorId"], "id"=>$data["imcId"], "title"=>Text::generateSeoUrlPersian($data["title"])))',
				),
				array(
					'name'=>'price',
					'header'=>Yii::t('product', 'Unit price'),
					'value'=>'Yii::app()->format->formatPrice($data["price"])',
					'type'=>'raw',
				),
				array(
					'name'=>'quantity',
					'header'=>Yii::t('product', 'Quantity'),
					'value'=>'$data["quantity"]',
					'type'=>'raw',
					'footer'=>Yii::t('product', 'Total').': '.$totalCount,
				),
				array(
					'name'=>'sumPrice',
					'header'=>Yii::t('product', 'Sum price'),
					'value'=>'Yii::app()->format->formatPrice($data["sumPrice"])',
					'type'=>'raw',
					'footer'=>Yii::t('product', 'Final price').': '.Yii::app()->format->formatPrice($totalCost),
				),
			),
		));
	?>

<?php else : ?>
	<?php echo Yii::t('main', 'Not Found'); ?>
<?php endif; ?>