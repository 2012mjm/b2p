<?php

class m150828_203200_reason_reject_withdraw extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_withdraw` CHANGE `rejectReason` `rejectReason` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
		");
	}

	public function down()
	{
		echo "m150828_203200_reason_reject_withdraw does not support migration down.\n";
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
