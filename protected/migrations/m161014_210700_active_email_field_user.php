<?php

class m161014_210700_active_email_field_user extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_user` ADD `isVerifiedEmail` TINYINT(1) NOT NULL DEFAULT '1' AFTER `email`;
		");
	}

	public function down()
	{
		echo "m161014_210700_actove_email_field_user does not support migration down.\n";
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
