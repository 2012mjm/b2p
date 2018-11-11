<?php

class m150708_162704_withdraw extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_order` ADD `systemComission` INT( 3 ) NOT NULL DEFAULT '20' AFTER `count`;

ALTER TABLE `b2p_setting` ADD `lowWithdraw` INT NOT NULL AFTER `comission` ,
ADD `lowWithdrawBankComission` INT NOT NULL AFTER `lowWithdraw`;
				
ALTER TABLE `b2p_withdraw` ADD `answerDate` DATETIME NULL AFTER `requestDate`;
		");
	}

	public function down()
	{
		echo "m150708_162704_withdraw does not support migration down.\n";
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
