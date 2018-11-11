<?php
$this->siteTitle=Yii::app()->name . ' - '.yii::t('main', 'My Tickets');
?>

<?php if($model) : ?>

	<h1><?php echo $model->title; ?></h1>
	<br>

	<small style="padding: 3px 10px; margin-bottom: 15px; background-color: #F9F9F9; display: block;">
		<?php echo ($model->userId == 1) ? 'توسط مدیر' : 'توسط '.$model->user->username; ?> <br>
		<?php echo ($model->assignId == 1) ? 'به مدیر' : 'به '.$model->assign->username; ?> <br>
		<?php echo Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->creationDate)); ?> <br>
		<?php echo Yii::t('ticket', 'وضعیت'); ?>: <?php echo Yii::t("enumItem", $model->manageStatus); ?> <br>
		<?php echo Yii::t('ticket', 'وضعیت (کاربر)'); ?>: <?php echo Yii::t("enumItem", $model->status); ?>
	</small>

	<p><?php echo nl2br(Text::autoUrl($model->description)); ?></p>

	<?php if($model->tickets) : ?>
		<hr>
		<?php foreach($model->tickets as $i=>$ticketModel) : ?>
		
		<div class="media" style="padding: 15px 30px; <?php if($i%2==0) echo 'background-color: #F9F9F9;'?>">
		  <div class="media-body">
			<small style="padding: 3px 10px; margin-bottom: 15px; display: block;">
				<?php echo ($ticketModel->userId == 1) ? 'توسط مدیر' : 'توسط '.$ticketModel->user->username; ?> <br>
				<?php echo Yii::app()->jdate->date("j F Y - g:i a", strtotime($ticketModel->creationDate)); ?>
			</small>
			<p><?php echo nl2br(Text::autoUrl($ticketModel->description)); ?></p>
		  </div>
		</div>

		<?php endforeach; ?>
	<?php endif; ?>

	<hr>
	<div class="form">
	<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'create-ticket-form',
		'type'=>'horizontal',
		'enableClientValidation'=>true,
		'clientOptions'=>array(
			'validateOnSubmit'=>true,
		),
	)); ?>

		<?php echo $form->errorSummary($viewModel); ?>

		<?php echo $form->textAreaRow($viewModel,'description', array('class'=>'span5', 'rows'=>7)); ?>
		
		<?php //echo $form->dropDownListRow($viewModel, 'status', ZHtml::enumItem($model, 'status'), array('class'=>'span5')); ?>
		
		<?php echo $form->checkBoxRow($viewModel, 'fixed', array('value'=>true)); ?>

		<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'type'=>'primary',
			'label'=>Yii::t('form', 'Save'),
			'buttonType'=>'submit',
			'size'=>'large',
		));  ?>
		</div>

	<?php $this->endWidget(); ?>
	</div>

<?php else : ?>
	<?php echo Yii::t('main', 'Not Found'); ?>
<?php endif; ?>