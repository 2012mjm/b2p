<?php

class m160630_202729_status_reason_product extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_product` ADD `statusReason` VARCHAR( 255 ) NULL DEFAULT NULL;
		");
	}

	public function down()
	{
		echo "m160630_202729_status_reason_product does not support migration down.\n";
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
