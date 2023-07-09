SET FOREIGN_KEY_CHECKS=0;

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

INSERT INTO `article` VALUES ('1', 'Úvod', '<p>Vítejte na našem webu!</p><p>Tento web je postaven na <strong>jednoduchém redakčním systému v Nette frameworku</strong>. Toto je úvodní článek, načtený z databáze.</p>', 'uvod', 'Úvodní článek na webu v Nette v PHP');
INSERT INTO `article` VALUES ('2', 'Stránka nebyla nalezena', '<p>Litujeme, ale požadovaná stránka nebyla nalezena. Zkontrolujte prosím URL adresu.</p>', 'chyba', 'Stránka nebyla nalezena.');
