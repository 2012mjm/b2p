<?php
$this->breadcrumbs=array(
	'Withdraws'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);
?>

<h1>Update Withdraw <?php echo $model->id; ?></h1>

<?php if($model->credit < Yii::app()->setting->lowWithdraw) : ?>
<br>
<blockquote>
	<p style="color: #DC0000">توجه: مبلغ این درخواست کمتر از <?php echo Yii::app()->format->formatPrice(Yii::app()->setting->lowWithdraw); ?> می باشد پس باید مبلغ <?php echo Yii::app()->format->formatPrice($model->credit - Yii::app()->setting->lowWithdrawBankComission); ?> واریز شود و <?php echo Yii::app()->format->formatPrice(Yii::app()->setting->lowWithdrawBankComission); ?> کارمزد بانک می باشد.</p>
</blockquote>
<?php endif; ?>


<br>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'label'=>'مبلغ درخواستی',
			'value'=>Yii::app()->format->formatPrice($model->credit),
			'type'=>'raw',
		),
		array(
			'name'=>'user.username',
			'value'=>CHtml::link($model->user->username, array('admin/manageuser/view', 'id'=>$model->userId)),
			'type'=>'raw',
		),
		array(
			'label'=>'نام',
			'value'=>$model->user->firstname.' '.$model->user->lastname
		),
		array(
			'name'=>'user.email',
			'label'=>Yii::t("user", "Email"),
		),
		array(
			'name'=>'user.phone',
			'label'=>Yii::t("user", "Phone"),
		),
		array(
			'name'=>'user.mobile',
			'label'=>Yii::t("user", "Mobile"),
		),
		array(
			'label'=>Yii::t("user", "Bank Name"),
			'value'=>Yii::t('enumItem', $model->user->bankName),
		),
		array(
			'name'=>'user.bankAccountNumber',
			'label'=>Yii::t("user", "Bank Account Number"),
		),
		array(
			'name'=>'user.bankCardNumber',
			'label'=>Yii::t("user", "Bank Card Number"),
		),
		array(
			'label'=>'ملبغ قابل برداشت (با احتساب درصد کارمزد)',
			'value'=>Yii::app()->format->formatPrice($blockCredit + $model->user->virtualCredit),
			'type'=>'raw',
		),
	),
)); ?>

<hr>
<?php echo $this->renderPartial('_form',array('model'=>$model, 'withdrawModel'=>$withdrawModel)); ?>