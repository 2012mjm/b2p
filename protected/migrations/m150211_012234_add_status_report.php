<?php

class m150211_012234_add_status_report extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_report` ADD `status` ENUM('new', 'read', 'fixed') NOT NULL DEFAULT 'new' AFTER `creationDate`; 
		");
	}

	public function down()
	{
		echo "m150211_012234_add_status_report does not support migration down.\n";
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
