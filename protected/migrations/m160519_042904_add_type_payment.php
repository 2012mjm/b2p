<?php

class m160519_042904_add_type_payment extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_payment` ADD `type` ENUM( 'parspal', 'zarinpal' ) NOT NULL DEFAULT 'parspal';
ALTER TABLE `b2p_setting` ADD `zarinPalMerchantID` VARCHAR( 45 ) NULL AFTER `parsPalPassword`;
ALTER TABLE `b2p_payment` CHANGE `trackingCode` `trackingCode` VARCHAR( 45 ) CHARACTER SET utf8 COLLATE utf8_persian_ci NOT NULL;
ALTER TABLE `b2p_payment` CHANGE `trackingCode` `trackingCode` VARCHAR( 45 ) CHARACTER SET utf8 COLLATE utf8_persian_ci NULL; 
		");
	}

	public function down()
	{
		echo "m160519_042904_add_type_payment does not support migration down.\n";
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
