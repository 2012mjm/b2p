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
		</div>
		
		<div class="span6">

			<h3><?php echo CHtml::encode($model->title); ?></h3>
			

			<div>
				<div style="width:50px; float:right"><?php echo Yii::t('product', 'قیمت'); ?></div>
				<div style="width:500px; float:right">
					<?php $this->widget('bootstrap.widgets.TbLabel', array( 
						'type'=>'important', // 'success', 'warning', 'important', 'info' or 'inverse' 
						'encodeLabel'=>false, 
						'label'=>Yii::app()->format->formatPrice($model->price), 
						'htmlOptions'=>array('class'=>'price-product price-product-large') 
					)); ?> 
				</div>
			</div>

			<div>
				<div style="width:50px; float:right"><?php echo Yii::t('product', 'گروه‌ها'); ?></div>
				<div style="width:500px; float:right">
					<?php foreach($model->product2subcategories as $product2subcategory) : ?>
						<?php $this->widget('bootstrap.widgets.TbLabel', array(
							'type'=>'info',
							'encodeLabel'=>false,
							'label'=>CHtml::link($product2subcategory->subcategory->category->name, array('/product/category', 'id'=>$product2subcategory->subcategory->categoryId, 'title'=>Text::generateSeoUrlPersian($product2subcategory->subcategory->category->name))).'<span>&raquo;</span>'.CHtml::link($product2subcategory->subcategory->name, array('/product/category', 'id'=>$product2subcategory->subcategory->categoryId, 'subId'=>$product2subcategory->subcategoryId, 'title'=>Text::generateSeoUrlPersian($product2subcategory->subcategory->name))),
							'htmlOptions'=>array('class'=>'category-label')
						)); ?>
						<br>
					<?php endforeach; ?>
				</div>
			</div>
			
			<div class="clearfix"></div>
			<?php if($model->product2tags) : ?>
				<div class="tags-label">
					<div style="width:50px; float:right"><?php echo Yii::t('product', 'تگ ها'); ?></div>
					<div style="width:500px; float:right">
						<?php foreach ($model->product2tags as $product2tag) : ?>
							<?php $this->widget('bootstrap.widgets.TbLabel', array(
								'label' => CHtml::link('# '.$product2tag->tag->name, array('/product/tag', 'id'=>$product2tag->tagId, 'title'=>Text::generateSeoUrlPersian($product2tag->tag->name))),
								'encodeLabel'=>false,
							)); ?>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<hr />
	<div class="row">
		<div class="span3" style="padding-top: 11px;">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'type'=>'info',
				'label'=>'خرید پروژه',
				'url'=>array('product/addShoppingCart', 'id'=>$model->id),
				'block'=>(!$model->demoFile) ? true : false,
				'size'=>'large'
			)); ?>
			
			<?php if($model->demoFile) : ?>
				<?php $this->widget('bootstrap.widgets.TbButton', array(
						'type'=>'primary',
						'label'=>Yii::t('product', 'Receive demo file'),
						'url'=>$model->demoFile->filePath.$model->demoFile->fileName,
						'size'=>'large',
				)); ?>
			<?php endif; ?>
		</div>
		<div class="span2" style="line-height: 25px;">
			<time style=""><i class="icon-time"></i> <?php echo Yii::app()->jdate->date("j F Y", strtotime($model->creationDate)); ?></time>	
			<div><i class="icon-shopping-cart"></i> خریداری شده: <?php echo $model->countSell; ?> بار</div>
			<div><i class="icon-eye-open"></i> بازدید: <?php echo $model->visit; ?> بار</div>
		</div>
		<div class="span4" style="line-height: 25px;">

			<div><i class="icon-user"></i>  ایجاد شده توسط: 
				<?php
					$urlAuthor = array('/product/author', 'username'=>$model->user->username);
					if(($model->user->firstname || $model->user->lastname) AND !empty(Text::generateSeoUrlPersian($model->user->firstname.' '.$model->user->lastname))) {
						$urlAuthor = array_merge($urlAuthor, array('name'=>Text::generateSeoUrlPersian($model->user->firstname.' '.$model->user->lastname)));
					}
					echo CHtml::link($model->user->username.(($model->user->firstname || $model->user->lastname) ? ' ('.$model->user->firstname.' '.$model->user->lastname.')' : null), $urlAuthor);
				?>
			</div>

			<?php if($model->format) : ?>
				<div><i class="icon-th-large"></i> فرمت‌های پروژه
					<?php foreach(explode(',', $model->format) as $format) : ?>
						<?php $this->widget('bootstrap.widgets.TbLabel', array('label'=>$format)); ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php if($model->countPage > 0) : ?>
				<div><i class="icon-file"></i> تعداد <?php echo $model->countPage; ?> صفحه</div>
			<?php endif; ?>
		</div>
	</div>

	<hr />
	
	<div style="background-color: #49afcd14;padding: 10px 10px 1px;border-right: 5px solid #49afcd; margin-bottom: 15px;">
		<p><?php echo (empty($model->shortDescription)) ? trim(Text::ellipsis(strip_tags($model->description), 100)) : $model->shortDescription; ?></p>
	</div>
	
	<div class="description" style="text-align: justify;">
		<?php echo str_replace(array('<hr>','<hr />','<hr/>'), '', $model->description); ?>
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
				));
			?>
		</div>
	</div>
	<?php endif; ?>
	
	<div class="clear"></div>
<?php endif; ?>