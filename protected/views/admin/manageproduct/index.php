<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Products'=>array('index'),
	'Manage product',
);
?>

<h1><?php echo Yii::t('product', 'Manage Products'); ?></h1>
<br>

<blockquote>
	<p>با استفاده از کلید ( <i class="icon-comment"></i> ) در مقابل هر پروژه، قادر خواهید بود که در رابطه با یک پروژه خاص به صاحب آن تیکت بزنید.</p>
	<p>با استفاده از کلید ( <i class="icon-file"></i> ) میتوانید یک یادداشت برای خود و برای صاحب پروژه درج نمایید.</p>
</blockquote>
<hr>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'product-grid',
	'dataProvider'=>$dataProvider,
	//'filter'=>$model,
	'enableHistory'=>true,
	'ajaxUpdate'=>'flash',
	'afterAjaxUpdate'=>'js:function() { flash(); priceCurrencyConvertor(); }',
	'selectableRows' => 2,
	'columns'=>array(
		array(
            'id' => 'selected-ids',
            'class' => 'CCheckBoxColumn'
        ),
		//'id',
		'title',
        'user.username',
        array(
        	'name'=>'price',
        	'value'=>'Yii::app()->format->formatPrice($data->price)',
        	'type'=>'raw'
        ),
		'countSell',
        array(
        	'name'=>'subcategory.categoryId',
        	'value'=>'$data->subcategory->category->name',
        ),
        array(
        	'name'=>'subcategoryId',
        	'value'=>'$data->subcategory->name',
        ),
        array(
        	'name'=>'creationDate',
        	'value'=>'Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->creationDate))',
        ),
		array(
			'name'=>'status',
			'value'=>'($data->status == "hidden") ? "<span style=\"color:red\">". Yii::t("enumItem", $data->status) ."</span>" : (($data->status == "active") ? "<span style=\"color:green\">". Yii::t("enumItem", $data->status) ."</span>" : "<span style=\"color:#848484\">". Yii::t("enumItem", $data->status) ."</span>")',
			//'filter'=>ZHtml::enumItem($model, 'status'),
			'type'=>'raw',
		),
		array(
			'name'=>'statusReason',
			'value'=>'Text::ellipsis($data->statusReason, 20)',
		),
        array(
            'class'=>'bootstrap.widgets.TbButtonColumn',
        	'template'=>'{ticket} {view} {update} {delete} {statusReason}',
        	'buttons' => array(
				'ticket' => array(
					'url'=>'array("/admin/manageticket/create", "pid"=>$data->id)',
        			'icon'=>'comment',
       			),
				'statusReason' => array(
					'url'=>'array("/admin/manageProduct/statusReason", "id"=>$data->id)',
        			'icon'=>'file',
       			),
       		)
        ),
	),
)); ?>


<?php
	echo CHtml::ajaxButton(Yii::t('form', 'Delete selected datas'), array('deletes'),
		array(
			'type'=>'POST',
			'data'=>'js:{selectedIds : $.fn.yiiGridView.getChecked("product-grid","selected-ids").toString()}',
        	'success'=>'function() { $.fn.yiiGridView.update("product-grid"); }',
		),
		array('confirm'=>Yii::t('zii', 'Are you sure you want to delete this item?'))
	);

	echo CHtml::dropDownList('status', '', 
		array(''=>Yii::t('product', 'Status')) + ZHtml::enumItem($model, 'status'),
		array(
			'ajax'=>array(
				'type'=>'POST',
				'url'=>array('statuses'),
				'data'=>'js:{selectedIds : $.fn.yiiGridView.getChecked("product-grid","selected-ids").toString(), selectedStatus : $(this).val()}',
	        	'success'=>'function() { 
	        		$.fn.yiiGridView.update("product-grid");
	        		$("#statuses").val("");
	        	}',
			),
			'id'=>'statuses',
		)
	);
?>