<?php

class m181114_195721_description_product extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_product` CHANGE `shortDescription` `shortDescription` VARCHAR(45) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL, CHANGE `description` `description` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL;
		");
	}

	public function down()
	{
		echo "m181114_195721_description_product does not support migration down.\n";
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
