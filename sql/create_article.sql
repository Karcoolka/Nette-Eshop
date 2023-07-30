SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `article`
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `article_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `content` text COLLATE utf8_czech_ci,
  `url` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`article_id`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('1', 'Úvod', '<div class=\"jumbotron\">\n<h1>Vítejte v našem e-shopu!</h1>\n<p>Tento internetový obchod je součástí výukového seriálu ze sítě ITnetwork.cz a vztahuje se na něj&nbsp;<a href=\"http://www.itnetwork.cz/licence\" target=\"_blank\">licence Premium no-reselling.</a></p>\n<p>Veškeré informace pro zprovoznění obchodu jsou k dispozici v&nbsp;<a href=\"http://www.itnetwork.cz/php/nette/e-shop\" target=\"_blank\">příslušném seriálu</a>.</p>\n<p><a class=\"btn btn-primary btn-lg\" href=\"http://www.itnetwork.cz\" target=\"_blank\">ITnetwork.cz</a></p>\n</div>', 'uvod', 'Úvodní článek na webu v Nette v PHP');
INSERT INTO `article` VALUES ('2', 'Stránka nebyla nalezena', '<p>Litujeme, ale požadovaná stránka nebyla nalezena. Zkontrolujte prosím URL adresu.</p>', 'chyba', 'Stránka nebyla nalezena.');