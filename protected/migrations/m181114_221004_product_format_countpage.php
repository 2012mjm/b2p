<?php

class m181114_221004_product_format_countpage extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_product` ADD `format` VARCHAR(128) NULL AFTER `countSell`, ADD `countPage` INT NULL AFTER `format`;
ALTER TABLE `b2p_setting` ADD `projehFormat` VARCHAR(255) NOT NULL AFTER `facenamaPageUrl`;		
		");
	}

	public function down()
	{
		echo "m181114_221004_product_format_countpage does not support migration down.\n";
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
