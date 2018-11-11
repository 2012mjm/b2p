<?php

class m150911_215528_social extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_setting`
	ADD `instagaramPageUrl` VARCHAR( 225 ) NULL AFTER `twitterPageUrl` ,
	ADD `googlePlusPageUrl` VARCHAR( 225 ) NULL AFTER `instagaramPageUrl` ,
	ADD `youtubePageUrl` VARCHAR( 225 ) NULL AFTER `googlePlusPageUrl` ,
	ADD `cloobPageUrl` VARCHAR( 225 ) NULL AFTER `youtubePageUrl` ,
	ADD `aparatPageUrl` VARCHAR( 225 ) NULL AFTER `cloobPageUrl` ,
	ADD `lenzorPageUrl` VARCHAR( 225 ) NULL AFTER `aparatPageUrl` ,
	ADD `facenamaPageUrl` VARCHAR( 225 ) NULL AFTER `lenzorPageUrl`;
		");
	}

	public function down()
	{
		echo "m150911_215528_social does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
