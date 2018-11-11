<?php

$this->siteTitle = Yii::app()->name.' - '.Yii::t('ticket', 'Tickets');
?>

<h2><?php echo Yii::t('ticket', 'Tickets'); ?></h2>

<br />

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label'=>Yii::t('ticket', 'Create Ticket'),
    'type'=>'info',
    'size'=>'small',
	'url'=>array('create'),
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
				'value'=>'($data->manageStatus == "new") ? "<strong>".CHtml::link($data->title, array("view", "id"=>$data->id))."</strong>" : CHtml::link($data->title, array("view", "id"=>$data->id))',
				'type'=>'raw',
			),
			array(
				'header'=>Yii::t('user', 'Username'),
				'value'=>'($data->assignId == 1) ? $data->user->username : $data->assign->username',
			),
			array(
				'name'=>'manageStatus',
				'header'=>Yii::t("main", "وضعیت"),
				'value'=>'($data->manageStatus == "new") ? "<strong>".Yii::t("enumItem", $data->manageStatus)."</strong>" : Yii::t("enumItem", $data->manageStatus)',
				'type'=>'raw',
			),
			array(
				'name'=>'status',
				'header'=>Yii::t("main", "وضعیت (کاربر)"),
				'value'=>'($data->manageStatus == "new") ? "<strong>".Yii::t("enumItem", $data->status)."</strong>" : Yii::t("enumItem", $data->status)',
				'type'=>'raw',
			),
	        array(
	            'class'=>'bootstrap.widgets.TbButtonColumn',
	        	'template'=>'{view}',
	        	'buttons' => array(
					'view' => array(
						'url'=>'array("view", "id"=>$data->id)',
	       			),
	       		)
	        ),
		),
	));
?>

<div class="clear"></div>