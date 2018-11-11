<?php

class m150211_010002_add_other_to_bankname extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_user` CHANGE `bankName` `bankName` ENUM('melli','saderat','tejarat','mellat','refah','sepah','maskan','keshavarzi','parsian','saman','pasargad','other') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL; 
		");
	}

	public function down()
	{
		echo "m150211_010002_add_other_to_bankname does not support migration down.\n";
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
