<?php

$this->siteTitle = Yii::app()->name.' - '.Yii::t('product', 'Track Orders');
?>

<h2><?php echo Yii::t('product', 'Track Orders'); ?></h2>
<br />

<blockquote>
	<p>کاربران عضو <?php echo Yii::app()->setting->siteName; ?> در صفحه <?php echo CHtml::link('سفارشات من', array('/order/index')); ?> می توانند سفارشات خود را مشاهده و وضعیت آن ها پیگیری نمایند.</p>
</blockquote>

    <?php if($model) : ?>
		<?php
			$this->widget('bootstrap.widgets.TbDetailView', array(
			    'data'=>$model,
			    'attributes'=>array(
					array(
						'name'=>'product.title',
						'value'=>CHtml::link(CHtml::encode($model->product->title), array("/product/view", "id"=>$model->productId, "title"=>Text::generateSeoUrlPersian($model->product->title))),
						'type'=>'raw',
					),
					array(
						'name'=>'linkDownload',
						'value'=>($model->status == 'accepted') ? CHtml::link(Yii::t("order", "Receive"), array("/main/download", "key"=>$model->linkDownload)) : '-',
						'type'=>'raw',
					),
			        'trackingCode',
					array(
						'name'=>'price',
						'value'=>Yii::app()->format->formatPrice($model->price),
						'type'=>'raw',
					),
					array(
						'name'=>'creationDate',
						'value'=>Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->creationDate)),
					),
					array(
						'name'=>'status',
						'value'=>Yii::t("enumItem", $model->status),
					),
			    ),
			));
		?>
    <?php else : ?>
    	<p>موردی یافت نشد.</p>
    <?php endif; ?>