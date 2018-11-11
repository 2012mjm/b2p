<?php

$this->siteTitle = Yii::app()->name.' - '.Yii::t('main', 'My Projects');
?>

<h2><?php echo Yii::t('main', 'My Projects'); ?></h2>

<br>

<blockquote>
	<p>با استفاده از کلید ( <i class="icon-comment"></i> ) در مقابل پروژه های خود، قادر خواهید بود که در رابطه با یک پروژه خاص با بخش پشتیبانی سایت تماس حاصل نمایید.</p>
</blockquote>

<hr>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>Yii::t('product', 'Create Product'),
    'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    'size'=>'small', // null, 'large', 'small' or 'mini'
	'url'=>array('/product/myCreate'),
)); ?>
			
<?php
	$this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped',
		'id'=>'orders-grid',
		'dataProvider'=>$myProductsDataProvider,
		'enableHistory'=>true,
		'afterAjaxUpdate'=>'js:function() { priceCurrencyConvertor(); }',
		'template'=>"{summary}{items}{pager}",
    	'enablePagination' => true,
		'pager'=> array(
	        'class'=>'bootstrap.widgets.TbPager',
			'nextPageLabel'=>'&larr;',
			'prevPageLabel'=>'&rarr;',
	    ),
		'columns'=>array(
			array(
				'name'=>'subcategory.category.name',
			),
			array(
				'name'=>'subcategory.name',
			),
			array(
				'name'=>'title',
				'value'=>'CHtml::link($data->title, array("/product/view", "id"=>$data->id, "title"=>Text::generateSeoUrlPersian($data->title)))',
				'type'=>'raw',
			),
			array(
				'name'=>'price',
				'value'=>'Yii::app()->format->formatPrice($data->price)',
				'type'=>'raw',
			),
			array(
				'name'=>'visit',
			),
			array(
				'name'=>'countSell',
			),
			array(
				'name'=>'creationDate',
				'value'=>'Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->creationDate))',
			),
			array(
				'name'=>'status',
				'value'=>'Yii::t("enumItem", $data->status)',
				'type'=>'raw',
			),
			array(
				'name'=>'statusReason',
				'value'=>'($data->reasonOnlyShowAdmin != "1") ? CHtml::link(Text::ellipsis($data->statusReason, 20), array("product/myView", "id"=>$data->id)) : null',
				'type'=>'raw',
			),
	        array(
	            'class'=>'bootstrap.widgets.TbButtonColumn',
	        	'template'=>'{ticket} {view} {update} {delete}',
	        	'buttons' => array(
					'ticket' => array(
						'url'=>'array("ticket/create", "pid"=>$data->id)',
	        			'icon'=>'comment',
	       			),
					'view' => array(
						'url'=>'array("product/myView", "id"=>$data->id)',
	       			),
					'update' => array(
						'url'=>'array("product/myUpdate", "id"=>$data->id)',
	       			),
					'delete' => array(
						'url'=>'array("product/myDelete", "id"=>$data->id)',
	       			)
	       		)
	        ),
		),
	));
?>

<div class="clear"></div>