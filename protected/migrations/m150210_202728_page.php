<?php

class m150210_202728_page extends CDbMigration
{
	public function up()
	{
		$this->execute("
--
-- Table structure for table `b2p_page`
--

CREATE TABLE IF NOT EXISTS `b2p_page` (
`id` int(11) NOT NULL,
  `title` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `context` text COLLATE utf8_unicode_ci NOT NULL,
  `visit` int(11) NOT NULL DEFAULT '0',
  `creationDate` datetime NOT NULL,
  `updateDate` datetime DEFAULT NULL,
  `type` enum('system','normal') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'normal'
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Dumping data for table `b2p_page`
--

INSERT INTO `b2p_page` (`id`, `title`, `key`, `context`, `visit`, `creationDate`, `updateDate`, `type`) VALUES
(1, 'راهنمایی خرید', 'buy-help', 'راهنما', 0, '2015-02-10 00:00:00', NULL, 'system');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `b2p_page`
--
ALTER TABLE `b2p_page`
 ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `b2p_page`
--
ALTER TABLE `b2p_page`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
		");
	}

	public function down()
	{
		echo "m150210_202728_page does not support migration down.\n";
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
