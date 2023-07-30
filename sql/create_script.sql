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

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  `role` enum('member','admin') COLLATE utf8_czech_ci NOT NULL DEFAULT 'member',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', 'admin', '$2y$10$h8vmMU0yHJ4jFOpfxrZO0eIW3qgnRFXsdi4G9DKzXaHuo9OLPuPJu', 'admin');
INSERT INTO `user` VALUES ('2', 'test', '$2y$10$Re6SSHFjyr25eaddRBQHP.tvQ0nUr0EqUK05y12bGhgM.MzeHa5c6', 'member');