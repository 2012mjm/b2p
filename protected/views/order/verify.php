<?php
$this->siteTitle = Yii::app()->name;
?>

<blockquote>
	<p style="color: <?php echo ($results) ? 'green' : 'red'; ?>"><?php echo $message; ?></p>
	<br>
	<?php if($results) : ?><p>لطفا شماره(های) زیر را نزد خود نگه دارید تا برای رهگیری سفارش بتوانید از آنها استفاده نمایید.</p><?php endif; ?>
	<p>کاربران عضو <?php echo Yii::app()->setting->siteName; ?>، در صفحه <?php echo CHtml::link('سفارشات من', array('/order/index')); ?> می توانند سفارشات خود را مشاهده و وضعیت آن‌ها را پیگیری نمایند.</p>
</blockquote>
<br />

	<?php foreach($results as $result) : ?>
	<fieldset style="text-align: center;">
    	<legend style="text-align: right;">
    		<?php echo Yii::t('product', 'Product Title'); ?> :
    		<a target="_blank" href="<?php echo Yii::app()->createUrl('/product/view', array('id'=>$result['productId'], 'title'=>Text::generateSeoUrlPersian($result['productTitle']))); ?>"><strong><?php echo $result['productTitle']; ?></strong></a>
    	</legend>

		<div class="form-horizontal">
			<div class="control-group" style="margin-bottom: 10px;">
		    	<div class="controls" style="padding-top: 4px;">
		    		<h3><?php echo CHtml::link(Yii::t('product', 'Download Link'), array('/main/download', 'key'=>$result['linkDownload']), array('target'=>'_blank')); ?></h3>
		    	</div>
	    	</div>
			<div class="control-group" style="margin-bottom: 10px;">
		    	<div class="controls" style="padding-top: 4px;">
		    		شناسه سفارش <?php echo CHtml::textField('trackingCode', $result['trackingCode'], array('readonly'=>'readonly', 'onclick'=>'this.select()', 'id'=>'trackingCode_'.$result['trackingCode'], 'class'=>'tracking-code span4', 'style'=>'text-align: center')); ?>
		    	</div>
	    	</div>
	    </div>
    	
    </fieldset>
    <br /><br />
    <?php endforeach; ?>

<div class="clear"></div>