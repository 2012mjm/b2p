<?php

class m150210_223723_product_hidden_status extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_product` CHANGE `status` `status` ENUM('active','inactive','hidden') CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'active'; 
		");
	}

	public function down()
	{
		echo "m150210_223723_product_hidden_status does not support migration down.\n";
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
