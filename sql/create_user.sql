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