<?php
if($page != 1) {
	$pageTitle = ' - '.Yii::t('main', 'Page').' '.$page;
}
else {
	$pageTitle = null;
}

$this->siteTitle 	= Yii::app()->name;
$this->siteTitle 	.= $pageTitle;
?>

<h2><?php echo Yii::t('product', 'New Products')?></h2>

<?php if($products) : ?>
	<div class="items">
		<ul class="thumbnails">
			
			<?php foreach ($products as $product) : ?>
				<?php $this->renderPartial('//product/_result', array('product'=>$product)); ?>
			<?php endforeach; ?>
		</ul>
	</div>
<?php else : ?>
	<p>موردی یافت نشد.</p>
<?php endif; ?>

<br />

<?php if($pageCount > 1) : ?>
	<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
	    'buttons'=>$pages
	)); ?>
<?php endif; ?>