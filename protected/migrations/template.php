<?php

class {ClassName} extends CDbMigration
{
	public function up()
	{
		$this->execute("
				
		");
	}

	public function down()
	{
		echo "{ClassName} does not support migration down.\n";
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
