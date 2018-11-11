<?php

$this->siteTitle = Yii::app()->name.' - '.Yii::t('ticket', 'Logs');
?>

<h2><?php echo Yii::t('ticket', 'Logs'); ?></h2>

<br />
			
<?php
	$this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped',
		'id'=>'logs-grid',
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
				'name'=>'ip',
			),
			array(
				'header'=>Yii::t('user', 'Username'),
				'name'=>'user.username',
			),
			array(
				'name'=>'title',
			),
	        array(
	        	'name'=>'creationDate',
	        	'value'=>'Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->creationDate))',
	        ),
			array(
				'name'=>'isRead',
				'header'=>Yii::t("main", "وضعیت"),
				'value'=>'($data->isRead == 1) ? "<span>".Yii::t("enumItem", "خوانده شده")."</span>" : "<span style=\"color:red\">".Yii::t("enumItem", "خوانده نشده")."</span>"',
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