<h1><?php echo Yii::t('report', 'Manage Reports'); ?></h1>


<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'report-grid',
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		//'id',
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
			'name'=>'orderId',
			'value'=>'CHtml::link($data->orderId, array("/admin/manageOrder/view", "id"=>$data->orderId))',
			'header'=>Yii::t("order", "Order Id"),
			'type'=>'raw',
		),
		//'description',
		//'type',
        array(
        	'name'=>'creationDate',
        	'value'=>'Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->creationDate))',
        ),
		array(
			'name'=>'status',
			'header'=>'وضعیت',
			'value'=>'($data->status == "new") ? "<strong>".Yii::t("enumItem", $data->status)."</strong>" : (($data->status == "fixed") ? "پاسخ داده شده" : Yii::t("enumItem", $data->status))',
			'type'=>'raw',
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
	        'template'=>'{view}',
		),
	),
)); ?>
