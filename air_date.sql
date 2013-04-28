# Dump of table air_times
# ------------------------------------------------------------

DROP TABLE IF EXISTS `air_times`;

CREATE TABLE `air_times` (
  `air_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `air_times` WRITE;
/*!40000 ALTER TABLE `air_times` DISABLE KEYS */;

INSERT INTO `air_times` (`air_date`)
VALUES
	('2013-05-5 19:00:00');

/*!40000 ALTER TABLE `air_times` ENABLE KEYS */;
UNLOCK TABLES;