<?php

class m181111_153311_multi_category extends CDbMigration
{
	public function up()
	{
		$this->execute("
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;

ALTER TABLE `b2p_product` 
DROP FOREIGN KEY `fk_pas_product_pas_subcategory1`;

ALTER TABLE `b2p_product` 
DROP INDEX `fk_pas_product_pas_subcategory1_idx` ;

ALTER TABLE `b2p_withdraw` 
COLLATE = utf8_general_ci ;

CREATE TABLE IF NOT EXISTS `b2p_product2subcategory` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `productId` INT(11) NOT NULL,
  `subcategoryId` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_b2p_product2subcategory_b2p_subcategory1_idx` (`subcategoryId` ASC),
  INDEX `fk_b2p_product2subcategory_b2p_product1_idx` (`productId` ASC),
  CONSTRAINT `fk_b2p_product2subcategory_b2p_subcategory1`
    FOREIGN KEY (`subcategoryId`)
    REFERENCES `b2p_subcategory` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_b2p_product2subcategory_b2p_product1`
    FOREIGN KEY (`productId`)
    REFERENCES `b2p_product` (`id`)
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
		echo "m181111_153311_multi_category does not support migration down.\n";
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
