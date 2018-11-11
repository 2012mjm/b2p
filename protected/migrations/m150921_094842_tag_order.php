<?php

class m150921_094842_tag_order extends CDbMigration
{
	public function up()
	{
		$this->execute("
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

ALTER TABLE `b2p_order` 
ADD COLUMN `ip` VARCHAR(15) NOT NULL AFTER `email`,
ADD COLUMN `isRead` TINYINT(1) NOT NULL DEFAULT 0 AFTER `ip`;

CREATE TABLE IF NOT EXISTS `b2p_tag` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `b2p_product2tag` (
  `id` INT(11) NOT NULL,
  `productId` INT(11) NOT NULL,
  `tagId` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_b2p_product2tag_b2p_tag1_idx` (`tagId` ASC),
  INDEX `fk_b2p_product2tag_b2p_product1_idx` (`productId` ASC),
  CONSTRAINT `fk_b2p_product2tag_b2p_tag1`
    FOREIGN KEY (`tagId`)
    REFERENCES `b2p_tag` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_b2p_product2tag_b2p_product1`
    FOREIGN KEY (`productId`)
    REFERENCES `b2p_product` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

ALTER TABLE `b2p_order` CHANGE `ip` `ip` VARCHAR( 15 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL;

ALTER TABLE `b2p_product2tag` CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT; 

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
		");
	}

	public function down()
	{
		echo "m150921_094842_tag_order does not support migration down.\n";
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
