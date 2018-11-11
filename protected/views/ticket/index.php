<?php

$this->siteTitle = Yii::app()->name.' - '.Yii::t('main', 'My Tickets');
?>

<h2><?php echo Yii::t('main', 'My Tickets'); ?></h2>

<br>

<blockquote>
	<p>این بخش برای مکاتبه با بخش پشتیبانی سایت در نظر گرفته شده است.</p>
</blockquote>

<hr>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>Yii::t('ticket', 'Create Ticket'),
    'type'=>'info',
    'size'=>'small',
	'url'=>array('/ticket/create'),
)); ?>
			
<?php
	$this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped',
		'id'=>'tickets-grid',
		'dataProvider'=>$dataProvider,
		'enableHistory'=>true,
		'template'=>"{summary}{items}{pager}",
    	'enablePagination' => true,
		'pager'=> array(
	        'class'=>'bootstrap.widgets.TbPager',
			'nextPageLabel'=>'&larr;',
			'prevPageLabel'=>'&rarr;',
	    ),
		'columns'=>array(
			array(
				'name'=>'title',
				'value'=>'($data->status == "new") ? "<strong>".CHtml::link($data->title, array("/ticket/view", "id"=>$data->id))."</strong>" : CHtml::link($data->title, array("/ticket/view", "id"=>$data->id))',
				'type'=>'raw',
			),
			array(
				'name'=>'status',
				'value'=>'($data->status == "new") ? "<strong>".Yii::t("enumItem", $data->status)."</strong>" : Yii::t("enumItem", $data->status)',
				'type'=>'raw',
			),
	        array(
	            'class'=>'bootstrap.widgets.TbButtonColumn',
	        	'template'=>'{view}',
	        	'buttons' => array(
					'view' => array(
						'url'=>'array("ticket/view", "id"=>$data->id)',
	       			),
	       		)
	        ),
		),
	));
?>

<div class="clear"></div>