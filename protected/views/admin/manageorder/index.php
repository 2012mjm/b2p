<h1><?php echo Yii::t('order', 'Manage Orders'); ?></h1>
<br>

<blockquote>
	<p>مجموع پورسانت: <span style="color:green"><?php echo Yii::app()->format->formatPrice($totalComission); ?></span></p>
</blockquote>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'order-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name'=>'user.username',
			'header'=>Yii::t("user", "Username"),
		),
		array(
			'name'=>'product.title',
			'value'=>'CHtml::link(mb_substr($data->product->title, 0, 20, "UTF-8").((strlen($data->product->title) > 20) ? " . . ." : ""), array("/product/view", "id"=>$data->productId, "title"=>Text::generateSeoUrlPersian($data->product->title)))',
			'header'=>Yii::t("product", "Product Title"),
			'type'=>'raw',
		),
		array(
			'name'=>'price',
			'value'=>'Yii::app()->format->formatPrice($data->price)',
			'type'=>'raw',
		),
		//'count',
		//'email',
		array(
			'header'=>'شماره تراکنش',
			'name'=>'payment.reffererCode',
		),
		array(
			'header'=>'درگاه پرداخت',
			'name'=>'payment.type',
		),
		array(
			'name'=>'status',
			'value'=>'Yii::t("enumItem", $data->status)',
		),
        array(
        	'name'=>'creationDate',
        	'value'=>'Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->creationDate))',
        ),
		array(
			'name'=>'isRead',
			'header'=>'وضعیت خواندن',
			'type'=>'raw',
			'value'=>'($data->isRead) ? "<span style=\"color:green\">خوانده شده</span>" : "<span style=\"color:red\">خوانده نشده</span>"',
		),
		array(
			'name'=>'product.title',
			'value'=>'($data->status == "accepted") ? Yii::app()->format->formatPrice($data->price*Yii::app()->setting->comission/100) : "-"',
			'header'=>Yii::t("product", "پورسانت"),
			'type'=>'raw',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
	        'template'=>'{view}',
		),
	),
)); ?>
