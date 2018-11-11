<?php
$facebookPageUrl 	= Yii::app()->setting->facebookPageUrl;
$twitterPageUrl 	= Yii::app()->setting->twitterPageUrl;
$instagramPageUrl 	= Yii::app()->setting->instagaramPageUrl;
$googlePlusPageUrl 	= Yii::app()->setting->googlePlusPageUrl;
$youtubePageUrl 	= Yii::app()->setting->youtubePageUrl;
$cloobPageUrl 		= Yii::app()->setting->cloobPageUrl;
$aparatPageUrl 		= Yii::app()->setting->aparatPageUrl;
$lenzorPageUrl 		= Yii::app()->setting->lenzorPageUrl;
$facenamaPageUrl 	= Yii::app()->setting->facenamaPageUrl;
?>

<?php if($facebookPageUrl || $twitterPageUrl || $instagaramPageUrl || $googlePlusPageUrl || $youtubePageUrl || $cloobPageUrl || $aparatPageUrl || $lenzorPageUrl || $facenamaPageUrl) : ?>
<div style="float:left">

	<?php echo Yii::t('contact', 'Follow us on'); ?>

	<?php if($facebookPageUrl) : ?>
		<a class="follow-facebook" href="<?php echo $facebookPageUrl; ?>" target="_blank"><?php echo Yii::t('contact', 'facebook'); ?></a>
	<?php endif; ?>
	
	<?php if($twitterPageUrl) : ?>
		<a class="follow-twitter" href="<?php echo $twitterPageUrl; ?>" target="_blank"><?php echo Yii::t('contact', 'twitter'); ?></a>
	<?php endif; ?>
	
	<?php if($instagramPageUrl) : ?>
		<a class="follow-instagram" href="<?php echo $instagramPageUrl; ?>" target="_blank"><?php echo Yii::t('contact', 'instagram'); ?></a>
	<?php endif; ?>
	
	<?php if($googlePlusPageUrl) : ?>
		<a class="follow-google-plus" href="<?php echo $googlePlusPageUrl; ?>" target="_blank"><?php echo Yii::t('contact', 'google plus'); ?></a>
	<?php endif; ?>
	
	<?php if($youtubePageUrl) : ?>
		<a class="follow-youtube" href="<?php echo $youtubePageUrl; ?>" target="_blank"><?php echo Yii::t('contact', 'youtube'); ?></a>
	<?php endif; ?>
	
	<?php if($cloobPageUrl) : ?>
		<a class="follow-cloob" href="<?php echo $cloobPageUrl; ?>" target="_blank"><?php echo Yii::t('contact', 'cloob'); ?></a>
	<?php endif; ?>
	
	<?php if($aparatPageUrl) : ?>
		<a class="follow-aparat" href="<?php echo $aparatPageUrl; ?>" target="_blank"><?php echo Yii::t('contact', 'aparat'); ?></a>
	<?php endif; ?>
	
	<?php if($lenzorPageUrl) : ?>
		<a class="follow-lenzor" href="<?php echo $lenzorPageUrl; ?>" target="_blank"><?php echo Yii::t('contact', 'lenzor'); ?></a>
	<?php endif; ?>
	
	<?php if($facenamaPageUrl) : ?>
		<a class="follow-facenama" href="<?php echo $facenamaPageUrl; ?>" target="_blank"><?php echo Yii::t('contact', 'facenama'); ?></a>
	<?php endif; ?>
</div>
<?php endif; ?>