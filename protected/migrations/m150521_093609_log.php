<?php

class m150521_093609_log extends CDbMigration
{
	public function up()
	{
		$this->execute("
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
				
CREATE TABLE IF NOT EXISTS `b2p_log` (
  `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` VARCHAR(15) NOT NULL,
  `userId` INT(11) NULL DEFAULT NULL,
  `title` VARCHAR(45) NOT NULL, 
  `pageRoute` VARCHAR(45) NULL DEFAULT NULL,
  `pageParams` VARCHAR(255) NULL DEFAULT NULL,
  `description` VARCHAR(255) NOT NULL,
  `creationDate` datetime NOT NULL,
  `isRead` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX `fk_b2p_log_b2p_user1_idx` (`userId` ASC),
  CONSTRAINT `fk_b2p_log_b2p_user1`
    FOREIGN KEY (`userId`)
    REFERENCES `b2p_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
		");
	}

	public function down()
	{
		echo "m150521_093609_log does not support migration down.\n";
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
