<?php

class m161214_114203_reason_only_show_admin extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_product` ADD `reasonOnlyShowAdmin` TINYINT(1) NOT NULL DEFAULT '0' AFTER `statusReason`; 
		");
	}

	public function down()
	{
		echo "m161214_114203_reason_only_show_admin does not support migration down.\n";
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
