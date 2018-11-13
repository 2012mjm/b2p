<?php if($model) : ?>
	<?php $this->siteTitle = Yii::app()->name.' - '.$model->title; ?>
	<?php $this->siteDescription = $model->shortDescription; ?>
	<?php $this->siteKeywords = ProductService::generateKeywordsFromTitle($model->title); ?>
	
	<div class="row">
	
		<div class="span3" style="text-align: center">
			<div class="thumbnail">
			
				<?php if($model->photoId) : ?>
					<?php echo CHtml::link(
						CHtml::image(Yii::app()->baseUrl.@$model->photo->filePath. 't_'. @$model->photo->fileName),
						Yii::app()->baseUrl.@$model->photo->filePath.@$model->photo->fileName
					); ?>
				<?php else : ?>
					<?php echo CHtml::image(Yii::app()->theme->baseUrl.'/img/pic-product.jpg'); ?>
				<?php endif; ?>
			</div>
			
			<br>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
		            'type'=>'info',
		            'label'=>'<span style="padding-left:10px">خرید پروژه</span> '.Yii::app()->format->formatPrice($model->price),
					'url'=>array('product/addShoppingCart', 'id'=>$model->id),
					'block'=>(!$model->demoFile) ? true : false,
					'encodeLabel'=>false,
					'size'=>'large'
		        )); ?>
			
			<?php if($model->demoFile) : ?>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
			            'type'=>'primary',
			            'label'=>Yii::t('product', 'Receive demo file'),
						'url'=>$model->demoFile->filePath.$model->demoFile->fileName,
						'size'=>'large',
						'htmlOptions'=>array('style'=>'margin-top:5px')
				)); ?>
			<?php endif; ?>
		</div>
		
		<div class="span6">

			<h3><?php echo CHtml::encode($model->title); ?></h3>
			
			<?php echo Yii::t('product', 'Author'); ?>
			<?php
				$urlAuthor = array('/product/author', 'username'=>$model->user->username);
				
				if(($model->user->firstname || $model->user->lastname) AND !empty(Text::generateSeoUrlPersian($model->user->firstname.' '.$model->user->lastname))) {
					$urlAuthor = array_merge($urlAuthor, array('name'=>Text::generateSeoUrlPersian($model->user->firstname.' '.$model->user->lastname)));
				}
			?>
			
			<?php echo CHtml::link($model->user->username.(($model->user->firstname || $model->user->lastname) ? ' ('.$model->user->firstname.' '.$model->user->lastname.')' : null), $urlAuthor); ?>

			<br>
			<?php echo Yii::t('product', 'گروه‌ها'); ?>

			<?php foreach($model->product2subcategories as $product2subcategory) : ?>
				<?php $this->widget('bootstrap.widgets.TbLabel', array(
					'type'=>'info', // 'success', 'warning', 'important', 'info' or 'inverse'
					'encodeLabel'=>false,
					'label'=>CHtml::link($product2subcategory->subcategory->category->name, array('/product/category', 'id'=>$product2subcategory->subcategory->categoryId, 'title'=>Text::generateSeoUrlPersian($product2subcategory->subcategory->category->name))).'<span>&raquo;</span>'.CHtml::link($product2subcategory->subcategory->name, array('/product/category', 'id'=>$product2subcategory->subcategory->categoryId, 'subId'=>$product2subcategory->subcategoryId, 'title'=>Text::generateSeoUrlPersian($product2subcategory->subcategory->name))),
					'htmlOptions'=>array('class'=>'category-label')
				)); ?>
			<?php endforeach; ?>
			
			<?php if($model->product2tags) : ?>
				<br><br>
				<?php echo Yii::t('product', 'تگ ها'); ?> :
				
				<?php foreach ($model->product2tags as $product2tag) : ?>
					<?php $tags[] = CHtml::link('#'.$product2tag->tag->name, array('/product/tag', 'id'=>$product2tag->tagId, 'title'=>Text::generateSeoUrlPersian($product2tag->tag->name))); ?>
				<?php endforeach; ?>
				
				<?php echo implode(' , ', $tags); ?>
			<?php endif; ?>
			
			<?php /*$this->widget('bootstrap.widgets.TbLabel', array(
			    'type'=>'info', // 'success', 'warning', 'important', 'info' or 'inverse'
				'encodeLabel'=>false,
				'label'=>CHtml::link($model->subcategory->category->name, array('/product/category', 'id'=>$model->subcategory->categoryId, 'title'=>Text::generateSeoUrlPersian($model->subcategory->category->name))),
				'htmlOptions'=>array('class'=>'category-product')
			));*/ ?>
			
			<?php /*$this->widget('bootstrap.widgets.TbLabel', array(
			    'type'=>'info', // 'success', 'warning', 'important', 'info' or 'inverse'
				'encodeLabel'=>false,
			    'label'=>CHtml::link($model->subcategory->name, array('/product/category', 'id'=>$model->subcategory->categoryId, 'subId'=>$model->subcategoryId, 'title'=>Text::generateSeoUrlPersian($model->subcategory->name))),
				'htmlOptions'=>array('class'=>'subcategory-product')
			));*/ ?>

			<div style="margin-top:40px">
				<time style=""><i class="icon-time"></i> <?php echo Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->creationDate)); ?></time>
				
				<?php if($model->countSell) : ?>
					<div><i class="icon-shopping-cart"></i> خریداری شده: <?php echo $model->countSell; ?> بار</div>
				<?php endif; ?>
				
				<div><i class="icon-eye-open"></i> بازدید: <?php echo $model->visit; ?> بار</div>
			</div>
		</div>
	</div>
	
	<div class="span9">
		<hr />
		<div class="description"><h3>توضیحات</h3><?php echo ($model->description) ? $model->description : $model->shortDescription; ?></div>
	</div>

	<?php if($dataProviderRelatedProducts->getItemCount() > 0) : ?>
	<div class="span9">
		<hr />
		<h4><?php echo Yii::t('product', 'Related products'); ?></h4>
		<div style="margin: auto; width: 87%;">
			<?php
				$this->widget('bootstrap.widgets.TbThumbnails', array(
				    'dataProvider'=>$dataProviderRelatedProducts,
				    'itemView'=>'//product/_result',
					'pagerCssClass' => 'pagination',
					'enableHistory' => true,
					'template'=>"{items}",
					/*'pager'=>array(
						'class'=>'bootstrap.widgets.TbPager',
						'nextPageLabel'=>'&larr;',
						'prevPageLabel'=>'&rarr;',
						'firstPageLabel'=>Yii::t('main', '&laquo; First'),
						'lastPageLabel'=>Yii::t('main', 'Last &raquo;'),
					),*/
				));
			?>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="clear"></div>
<?php endif; ?>