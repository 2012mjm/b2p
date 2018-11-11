<?php

if($subCategoryName != null) {
	$subCategoryTitle = ' - '.$subCategoryName;
	$subCategoryHead = ' :: '.$subCategoryName;
}
else {
	$subCategoryTitle = null;
	$subCategoryHead = null;
}

$this->siteTitle 	= Yii::app()->name.' - '.$categoryName;
$this->siteTitle 	.= $subCategoryTitle;
?>

<h2><?php echo $categoryName.$subCategoryHead; ?></h2>

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