<?php

$this->siteTitle = Yii::app()->name.' - '.Yii::t('product', 'Shopping Cart');
?>

<h2><?php echo Yii::t('product', 'Shopping Cart'); ?></h2>

<br />

<blockquote>
	<p>کاربرانی که در سایت عضو هستند می توانند در بخش <?php echo CHtml::link('سفارشات من', array('/order/index')); ?>، تمامی سفارشات خود را مشاهده و پیگیری نمایند.</p>
</blockquote>


<?php if($products != null) : ?>

	<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    	'id'=>'order-form',
	    'type'=>'horizontal',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

	<?php echo $form->errorSummary($viewModel); ?>

<?php endif; ?>

<!-- <div id="shopping-cart-one"> -->
<?php
	$this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped',
		'id'=>'shopping-cart-grid',
		'dataProvider'=>new CArrayDataProvider($products),
		'enableHistory'=>true,
		'ajaxUpdate'=>'flash, shopping-cart-total, shopping-cart-message',
		'afterAjaxUpdate'=>'js:function() { flash(); priceCurrencyConvertor(); }',
		'template'=>"{items}",
		'columns'=>array(
			array(
				'name'=>'name',
				'header'=>'نام پروژه',
				'type'=>'raw',
				'value' => 'CHtml::link(CHtml::encode($data["title"]), array("product/view", "id"=>$data["id"], "title"=>Text::generateSeoUrlPersian($data["title"])))',
			),
			array(
				'name'=>'sumPrice',
				'header'=>'قیمت',
				'value'=>'Yii::app()->format->formatPrice($data["sumPrice"])',
				'type'=>'raw',
				'footer'=>Yii::t('product', 'Final price').': '.Yii::app()->format->formatPrice($totalCost),
			),
	        array(
	            'class'=>'bootstrap.widgets.TbButtonColumn',
	        	'template'=>'{delete}',
	        	'buttons' => array(
					'delete' => array(
						'url'=>'array("product/removeShoppingCart", "id"=>$data["id"])',
	       			)
	       		)
	        ),
		),
	));
?>
<?php if($products != null) : ?>

	<?php if(Yii::app()->user->isGuest) : ?>
	<br />
	
	<blockquote style="color:red">
		<p style="margin-bottom: 10px;">کاربر عزیز،</p>
		<p style="margin-bottom: 10px;">شما به صورت مهمان اقدام به خرید نموده اید، توصیه می شود ابتدا در سایت عضو شوید.</p>
		<p>با توجه به اینکه ارسال گزارش تخلف و پیگیری آن برای کاربران مهمان فقط از طریق ایمیل امکانپذیر می باشد لطفا در وارد کردن ایمیل معتبر در کادر زیر دقت لازم را داشته باشید.</p>
	</blockquote>
	<?php endif; ?>

	<br />
	
	<div>
		<?php echo $form->textFieldRow($viewModel, 'email'); ?>
		<div class="control-group ">
			<label for="" class="control-label"></label>
			<div class="controls">
				<small style="color: #878787">لطفا ایمیلی معتبر وارد نمایید.</small>
			</div>
		</div>
	</div>


	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'primary',
			'label'=>Yii::t('product', 'Next'),
			'buttonType'=>'submit',
			'size'=>'large',
		));  ?>
		<div style="float:left">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
			    'label'=>'بازگشت',
				'url'=>Yii::app()->homeUrl,
			    'type'=>'danger',
			)); ?>
		</div>
	</div>


	<?php $this->endWidget(); ?>
	</div>
<?php else : ?>

	<div class="form-actions">
		<div style="float:left">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'بازگشت',
			'url'=>Yii::app()->homeUrl,
		    'type'=>'danger',
		)); ?>
		</div>
	</div>

<?php endif; ?>

<div class="clear"></div>