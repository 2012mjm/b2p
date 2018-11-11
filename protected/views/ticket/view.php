<?php
$this->siteTitle=Yii::app()->name . ' - '.yii::t('main', 'My Tickets');
?>

<?php if($model) : ?>

	<h1><?php echo $model->title; ?></h1>
	<br>

	<small style="padding: 3px 10px; margin-bottom: 15px; background-color: #F9F9F9; display: block;">
		<?php echo ($model->userId == 1) ? 'توسط مدیر' : 'توسط شما'; ?> |
		<?php echo Yii::app()->jdate->date("j F Y - g:i a", strtotime($model->creationDate)); ?> |
		<?php echo Yii::t('ticket', 'Status'); ?>: 
			<?php if($model->status == 'fixed') : ?>
				<strong style="color: green">
			<?php endif; ?>
			<?php echo Yii::t("enumItem", $model->status); ?>
			<?php if($model->status == 'fixed') : ?>
				</strong>
			<?php endif; ?>
	</small>

	<p><?php echo nl2br(Text::autoUrl($model->description)); ?></p>

	<?php if($model->tickets) : ?>
		<hr>
		<?php foreach($model->tickets as $i=>$ticketModel) : ?>
		
		<div class="media" style="padding: 15px 30px; <?php if($i%2==0) echo 'background-color: #F9F9F9;'?>">
		  <div class="media-body">
			<small style="padding: 3px 10px; margin-bottom: 15px; display: block;">
				<?php echo ($ticketModel->userId == 1) ? 'توسط مدیر' : 'توسط شما'; ?> |
				<?php echo Yii::app()->jdate->date("j F Y - g:i a", strtotime($ticketModel->creationDate)); ?>
			</small>
			<p><?php echo nl2br(Text::autoUrl($ticketModel->description)); ?></p>
		  </div>
		</div>

		<?php endforeach; ?>
	<?php endif; ?>

	<?php if($model->status != 'fixed') : ?>
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
	
			<div class="form-actions">
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'type'=>'primary',
				'label'=>Yii::t('form', 'Save'),
				'buttonType'=>'submit',
			));  ?>
			<?php $this->widget('bootstrap.widgets.TbButton', array(
				'label'=>Yii::t('form', 'Cancel'),
				'url'=>array('/ticket/index'),
				'type'=>'danger',
			)); ?>
			</div>
	
		<?php $this->endWidget(); ?>
		</div>
	<?php endif; ?>

<?php else : ?>
	<?php echo Yii::t('main', 'Not Found'); ?>
<?php endif; ?>