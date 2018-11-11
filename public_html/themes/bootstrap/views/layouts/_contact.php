<?php
$yahooID = Yii::app()->setting->yahooID;
?>

<div class="row" id="support">
	<?php 
	/*<i class="icon-red-phone"></i>
	<span class="tel"><?php echo Yii::app()->setting->adminPhone; ?></span>
	*/
	?>

	<i class="icon-red-email"></i>
	<span class="email">support [at] Bia2projeh [dot] ir</span>
<?php /*
	<?php if(!$this->isLocal) : ?>
		<?php if($yahooID) : ?>
			<?php $ymsgr = ContactService::checkYmsgr($yahooID); ?>
			<a class="ymsgr-<?php echo $ymsgr; ?>" href="ymsgr:sendIM?<?php echo $yahooID; ?>">
				<?php echo Yii::t('contact', $ymsgr); ?>
			</a>
		<?php endif; ?>
	<?php endif; ?>
*/ ?>
</div>
