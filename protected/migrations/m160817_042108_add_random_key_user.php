<?php

class m160817_042108_add_random_key_user extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_user` ADD `randomKey` VARCHAR( 32 ) NULL AFTER `realCredit` ,
ADD `expiryRandomKey` DATETIME NULL AFTER `randomKey`;
		");
	}

	public function down()
	{
		echo "m160817_042108_add_random_key_user does not support migration down.\n";
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
