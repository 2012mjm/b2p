<?php
$this->siteTitle=Yii::app()->name . ' - '.yii::t('product', 'Update Product');
?>

<h1><?php echo yii::t('product', 'Update Product'); ?></h1>
<br>

<?php $this->renderPartial('//product/_myForm', array(
	'viewModel'=>$viewModel,
	'productModel'=>$productModel,
	'new'=>false,
)); ?>