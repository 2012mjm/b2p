<?php
$this->siteTitle=Yii::app()->name . ' - '.yii::t('main', 'فروش من');
?>

<h1><?php echo yii::t('main', 'فروش من'); ?></h1>

<br />
<blockquote>
	<p>اعتبار قابل برداشت: <?php echo Yii::app()->format->formatPrice(UserService::getvirtualCredit()); ?></p>
	<br>
	<p>برای درخواست واریز وجه به حساب بانکی خود می توانید به <?php echo CHtml::link('این صفحه', array('/credit/index')); ?> مراجعه نمایید.</p>
</blockquote>

<hr>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'order-grid',
	'dataProvider'=>$dataProviderOrder,
	'columns'=>array(
		array(
			'name'=>'product.title',
			'value'=>'CHtml::link(mb_substr($data->product->title, 0, 20, "UTF-8").((strlen($data->product->title) > 20) ? " ..." : ""), array("/product/view", "id"=>$data->productId, "title"=>Text::generateSeoUrlPersian($data->product->title)))',
			'header'=>Yii::t("product", "Product Title"),
			'type'=>'raw',
		),
		array(
			'name'=>'price',
			'value'=>'Yii::app()->format->formatPrice($data->price)',
			'type'=>'raw',
		),
		array(
			'name'=>'count',
			'footer'=>Yii::t('product', 'تعداد کل: ').$totalCount,
		),
		array(
			'header'=>'مبلغ کل',
			'value'=>'Yii::app()->format->formatPrice($data->price * $data->count)',
			'type'=>'raw',
		),
		array(
			'header'=>'کارمزد سیستم',
			'value'=>'Yii::app()->format->formatPrice($data->price * $data->count * $data->systemComission / 100) . " (" . $data->systemComission . "%)"',
			'type'=>'raw',
		),
        array(
        	'header'=>'تاریخ فروش',
        	'value'=>'Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->creationDate))',
			'footer'=>Yii::t('product', 'Final price').': '.Yii::app()->format->formatPrice($totalSalePrice).'<br>'.Yii::t('product', 'جمع کل با احتساب کارمزد').': '.Yii::app()->format->formatPrice($totalSalePriceWithCommission),
        ),
	),
)); ?>