<div class="span3 menu-part">
	<ul>
		<li><?php echo CHtml::link(Yii::t('main', 'My Profile'), array('/user/profile')); ?></li>
		<li><?php echo CHtml::link(Yii::t('user', 'Edit profile'), array('/user/update')); ?></li>
		<li><?php echo CHtml::link(Yii::t('user', 'Change password'), array('/user/password')); ?></li>
	</ul>
</div>