<?php

class m170303_161953_add_answer_report extends CDbMigration
{
	public function up()
	{
		$this->execute("
ALTER TABLE `b2p_report` ADD `answer` TEXT NULL AFTER `status`;
		");
	}

	public function down()
	{
		echo "m170303_161953_add_answer_report does not support migration down.\n";
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
