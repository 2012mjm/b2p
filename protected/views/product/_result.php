<div class="span2 span2-custom">
	<div class="thumbnail product-item">
		<?php echo CHtml::link(CHtml::image(($data->photoId) ? Yii::app()->baseUrl.@$data->photo->filePath .'t_'. @$data->photo->fileName : Yii::app()->theme->baseUrl.'/img/pic-product.jpg'), array('/product/view', 'id'=>$data->id, 'title'=>Text::generateSeoUrlPersian($data->title)), array('class'=>'pic-product-index')); ?>
		
		<h3 class="title-product"><?php echo CHtml::link(CHtml::encode($data->title), array('/product/view', 'id'=>$data->id, 'title'=>Text::generateSeoUrlPersian($data->title)), array('rel'=>'tooltip', 'data-title'=>$data->title)); ?></h3>
		
		<?php /*$this->widget('bootstrap.widgets.TbLabel', array(
		    'type'=>'important', // 'success', 'warning', 'important', 'info' or 'inverse'
			'encodeLabel'=>false,
		    'label'=>Yii::app()->format->formatPrice($data->price),
			'htmlOptions'=>array('class'=>'price-product')
		));*/ ?>
		
		<div class="description-product"><?php echo (!$data->shortDescription) ? trim(Text::ellipsis(strip_tags($data->description), 100)) : $data->shortDescription; ?></div>
		
		<div class="button-product">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
	            'type'=>'danger',
				'size'=>'small',
				'block'=>true,
	            'label'=>'خرید '.Yii::app()->format->formatPrice($data->price),
				'url'=>array('product/addShoppingCart', 'id'=>$data->id),
				'encodeLabel'=>false,
				'htmlOptions'=>array('style'=>'font-size:16px')
	        )); ?>
	     </div>
	</div>
</div>