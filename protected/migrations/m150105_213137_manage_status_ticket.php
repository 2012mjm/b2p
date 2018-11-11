<?php

class m150105_213137_manage_status_ticket extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_ticket` ADD `manageStatus` ENUM( 'new', 'read', 'fixed' ) NULL AFTER `status`;
		");
	}

	public function down()
	{
		echo "m150105_213137_manage_status_ticket does not support migration down.\n";
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
