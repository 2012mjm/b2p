<?php
$this->siteTitle=Yii::app()->name . ' - '.yii::t('main', 'My Projects');
?>

<?php if($model) : ?>

	<?php if($model->status == 'active') : ?>
		<h1><?php echo CHtml::link($model->title, array('/product/view', 'id'=>$model->id, 'title'=>Text::generateSeoUrlPersian($model->title))); ?></h1>
	<?php else : ?>
		<h1><?php echo $model->title; ?></h1>
	<?php endif; ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>Yii::t('product', 'Update Product'),
		'type'=>'info',
		'size'=>'small',
		'url'=>array('/product/myUpdate', 'id'=>$model->id),
	)); ?>

	<?php $this->widget('bootstrap.widgets.TbButton', array(
		'label'=>Yii::t('product', 'Delete Product'),
		'type'=>'info',
		'size'=>'small',
		'url'=>array('/product/myDelete', 'id'=>$model->id),
		'htmlOptions'=>array('onClick'=>"return confirm('".Yii::t('form', 'Are you sure?')."');"),
	)); ?>

	<br /><br />

	<?php if(!empty($model->statusReason) AND $model->reasonOnlyShowAdmin != '1') echo '<br><div class="alert alert-warning" role="alert"><strong style="color:red">یادداشت مدیر:</strong> '.$model->statusReason.'</div><br>'; ?>

	<?php foreach($model->product2subcategories as $product2subcategory) : ?>
		<?php $categories[] = CHtml::link($product2subcategory->subcategory->category->name, array('/product/category', 'id'=>$product2subcategory->subcategory->categoryId, 'title'=>Text::generateSeoUrlPersian($product2subcategory->subcategory->category->name))).'<span>&raquo;</span>'.CHtml::link($product2subcategory->subcategory->name, array('/product/category', 'id'=>$product2subcategory->subcategory->categoryId, 'subId'=>$product2subcategory->subcategoryId, 'title'=>Text::generateSeoUrlPersian($product2subcategory->subcategory->name))); ?>
	<?php endforeach; ?>

	<?php foreach($model->product2tags as $product2tag) : ?>
		<?php $tags[] = $product2tag->tag->name; ?>
	<?php endforeach; ?>

	<?php
		$this->widget('bootstrap.widgets.TbDetailView', array(
		    'data'=>$model,
		    'attributes'=>array(
				array(
					'label'=>'دسته‌ها',
					'value'=>implode('<br>',$categories),
					'type'=>'raw',
				),
				array(
					'name'=>'price',
					'value'=>Yii::app()->format->formatPrice($model->price),
					'type'=>'raw',
				),
				array(
					'name'=>'shortDescription',
				),
				array(
					'name'=>'description',
					'type'=>'raw',
				),
				array(
					'name'=>'photoId',
					'value'=>($model->photo) ? CHtml::image(Yii::app()->baseUrl.$model->photo->filePath.'t_'.$model->photo->fileName, null, array('style'=>'max-height: 100px')) : null,
					'type'=>'raw',
				),
				array(
					'name'=>'visit',
				),
				array(
					'name'=>'creationDate',
					'value'=>Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->creationDate)),
				),
				array(
					'name'=>'updateDate',
					'value'=>($model->updateDate == '0000-00-00 00:00:00') ? '' : Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->updateDate)),
				),
				array(
					'name'=>'status',
					'value'=>Yii::t("enumItem", $model->status),
					'type'=>'raw',
				),
				array(
					'name'=>'demoFileId',
					'value'=>($model->demoFile) ? CHtml::link(Yii::t('product', 'Download current file'), Yii::app()->baseUrl.$model->demoFile->filePath.$model->demoFile->fileName) : null,
					'type'=>'raw',
				),
				array(
					'name'=>'projehFileId',
					'value'=>($model->projehFile) ? CHtml::link(substr($model->projehFile->fileName, strpos($model->projehFile->fileName, '_')+1), Yii::app()->baseUrl.$model->projehFile->filePath.$model->projehFile->fileName) : null,
					'type'=>'raw',
				),
				array(
					'label'=>'تگ‌ها',
					'value'=>implode(' , ',$tags),
					'type'=>'raw',
				),
				'format',
				'countPage',
		    ),
		));
	?>

<?php else : ?>
	<?php echo Yii::t('main', 'Not Found'); ?>
<?php endif; ?>