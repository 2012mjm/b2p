<?php
$this->breadcrumbs=array(
	'Withdraws',
);
?>

<h1>Withdraws</h1>

<?php
	$this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped',
		'id'=>'orders-grid',
		'dataProvider'=>$creditDataProvider,
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
				'name'=>'userId',
				'value'=>'CHtml::link($data->user->username." (".$data->user->firstname." ".$data->user->lastname.")", array("admin/manageuser/view", "id"=>$data->userId))',
				'type'=>'raw',
			),
			array(
				'name'=>'credit',
				'value'=>'Yii::app()->format->formatPrice($data->credit)',
				'type'=>'raw',
			),
			array(
				'name'=>'requestDate',
				'value'=>'Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->requestDate))',
			),
			array(
				'name'=>'status',
				'value'=>'Yii::t("enumItem", $data->status)',
			),
			array(
				'name'=>'answerDate',
				'value'=>'($data->answerDate) ? Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->answerDate)) : "-"',
			),
			array(
				'name'=>'rejectReason',
				'value'=>'$data->rejectReason',
			),
	        array(
	            'class'=>'bootstrap.widgets.TbButtonColumn',
	        	'template'=>'{update}',
	        	'buttons' => array(
					'update' => array(
						'visible'=>'($data->status == "pending")',
	       			),
	       		)
	        ),
		),
	));
?>
