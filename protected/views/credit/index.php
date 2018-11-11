<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->siteTitle=Yii::app()->name . ' - '.yii::t('main', 'My Credit');
?>

<h1><?php echo yii::t('main', 'My Credit'); ?></h1>

<br />

<blockquote>
	<p>پس از ثبت درخواست واریز وجه مورد نظر به حساب شما، ابتدا وجه مورد نظر از حساب مجازی شما کسر شده و پس از تایید مدیر به حساب بانکی شما واریز خواهد شد.</p>
	<p>جهت ویرایش شماره حساب بانکی خود <?php echo CHtml::link('اینجا', '/user/update'); ?> کلیک نمائید.</p>
	<br>
	<p style="color: #DC0000">توجه: برای درخواست های کمتر از <?php echo Yii::app()->format->formatPrice(Yii::app()->setting->lowWithdraw); ?>، مبلغ <?php echo Yii::app()->format->formatPrice(Yii::app()->setting->lowWithdrawBankComission); ?> کارمزد تعلق می گیرد.</p>
</blockquote>

<hr>

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
	
	<div>
		<div class="control-group">
			<label for="" class="control-label"><?php echo Yii::t('withdraw', 'اعتبار قابل برداشت:'); ?></label>
			<div class="controls">
				<?php echo Yii::app()->format->formatPrice($userModel->virtualCredit); ?>
			</div>
		</div>
	</div>
	
	<div>
		<div class="control-group">
			<?php echo $form->labelEx($viewModel, 'credit', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($viewModel, 'credit'); ?>
				<?php echo Yii::t('main', 'Toman'); ?>
			</div>
		</div>
	</div>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'primary',
			'label'=>Yii::t('withdraw', 'Withdraw requested'),
			'buttonType'=>'submit',
			'size'=>'medium',
		)); ?>
        <?php $this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>Yii::t('form', 'Cancel'),
			'url'=>Yii::app()->homeUrl,
		    'type'=>'danger',
		)); ?>
	</div>


<?php $this->endWidget(); ?>
</div>

<?php
	$this->widget('bootstrap.widgets.TbGridView', array(
		'type'=>'striped',
		'id'=>'orders-grid',
		'dataProvider'=>$creditDataProvider,
		'enableHistory'=>true,
		'afterAjaxUpdate'=>'js:function() { priceCurrencyConvertor(); }',
		'template'=>"{summary}{items}{pager}",
    	'enablePagination' => true,
		'pager'=> array(
	        'class'=>'bootstrap.widgets.TbPager',
			'nextPageLabel'=>'&larr;',
			'prevPageLabel'=>'&rarr;',
	    ),
		'columns'=>array(
			array(
				'name'=>'credit',
				'value'=>'Yii::app()->format->formatPrice($data->credit)',
				'type'=>'raw',
			),
			array(
				'name'=>'requestDate',
				'value'=>'Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->requestDate))',
			),
			array(
				'name'=>'status',
				'value'=>'Yii::t("enumItem", $data->status)',
			),
			array(
				'name'=>'answerDate',
				'value'=>'($data->answerDate) ? Yii::app()->jdate->date("j F Y - g:i a", strtotime($data->answerDate)) : "-"',
			),
			array(
				'name'=>'rejectReason',
				'value'=>'$data->rejectReason',
			),
	        /*array(
	            'class'=>'bootstrap.widgets.TbButtonColumn',
	        	'template'=>'{view}',
	        	'buttons' => array(
					'view' => array(
						'url'=>'array("order/view", "id"=>$data->id)',
	       			)
	       		)
	        ),*/
		),
	));
?>