<?php
$this->menu=array(
	array('label'=>'Manage Order','url'=>array('index')),
);
?>

<h1>View Order #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'name'=>'user.username',
			'value'=>CHtml::link($model->user->username, array("/admin/manageUser/view", "id"=>$model->userId)),
			'label'=>Yii::t("user", "Username"),
			'type'=>'raw',
		),
		array(
			'name'=>'product.title',
			'value'=>CHtml::link($model->product->title, array("/product/view", "id"=>$model->productId, "title"=>Text::generateSeoUrlPersian($model->product->title))),
			'label'=>Yii::t("product", "Product Title"),
			'type'=>'raw',
		),
		array(
			'name'=>'price',
			'value'=>Yii::app()->format->formatPrice($model->price),
			'type'=>'raw',
		),
		'count',
		'trackingCode',
		array(
			'label'=>'شماره تراکنش',
			'name'=>'payment.reffererCode',
		),
		array(
			'label'=>'درگاه پرداخت',
			'name'=>'payment.type',
		),
		'email',
		'ip',
		array(
			'name'=>'status',
			'value'=>Yii::t("enumItem", $model->status),
		),
        array(
        	'name'=>'creationDate',
        	'value'=>Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->creationDate)),
        ),
	),
)); ?>
