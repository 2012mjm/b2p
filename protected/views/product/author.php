<?php

$this->siteTitle 	= Yii::app()->name.' - '.$username.(($name) ? ' - '.$name : null);

?>

<?php if(Yii::app()->user->id == 1) : ?>
<h2>
	<?php if(yii::app()->user->getId() == 1) echo '#'.$userModel->id.' -'; ?>
	<?php echo CHtml::link(CHtml::encode($username).(($name) ? ' :: '.CHtml::encode($name) : null), array('/admin/manageuser/view', 'id'=>$userModel->id)); ?>
</h2>
<?php else : ?>
<h2>
	<?php echo CHtml::encode($username).(($name) ? ' :: '.CHtml::encode($name) : null); ?>
</h2>
<?php endif; ?>

<?php
	$this->widget('bootstrap.widgets.TbThumbnails', array(
	    'dataProvider'=>$productsDataProvider,
	    'itemView'=>'//product/_result',
		'pagerCssClass' => 'pagination',
		'enableHistory' => true,
		'template'=>"{items}{pager}",
	    //'template'=>"{items}\n{pager}",
		'pager'=>array(
			'class'=>'bootstrap.widgets.TbPager',
//			'displayFirstAndLast'=>true,
			'nextPageLabel'=>'&larr;',
			'prevPageLabel'=>'&rarr;',
			'firstPageLabel'=>Yii::t('main', '&laquo; First'),
			'lastPageLabel'=>Yii::t('main', 'Last &raquo;'),
		),
	));
?>