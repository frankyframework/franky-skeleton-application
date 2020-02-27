DROP TABLE IF EXISTS `calificaciones_calificaciones`;

CREATE TABLE `calificaciones_calificaciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_item` int(11) NOT NULL,
  `tabla` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `aprovado` int(11) NOT NULL DEFAULT 0,
  `calificacion` int(11) DEFAULT NULL,
  `titulo` varchar(255) DEFAULT NULL,
  `comentario` text DEFAULT NULL,
  `status_admin` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

/*Table structure for table `calificaciones_generales` */

DROP TABLE IF EXISTS `calificaciones_generales`;

CREATE TABLE `calificaciones_generales` (
  `id_item` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL,
  `tabla` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `calificaciones_guest` */

DROP TABLE IF EXISTS `calificaciones_guest`;

CREATE TABLE `calificaciones_guest` (
  `id_calificacion` int(11) NOT NULL,
  `nombre` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  KEY `id_calificacion` (`id_calificacion`),
  CONSTRAINT `calificaciones_guest_ibfk_1` FOREIGN KEY (`id_calificacion`) REFERENCES `calificaciones_calificaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Table structure for table `calificaciones_users` */

DROP TABLE IF EXISTS `calificaciones_users`;

CREATE TABLE `calificaciones_users` (
  `id_calificacion` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  KEY `id_calificacion` (`id_calificacion`),
  CONSTRAINT `calificaciones_users_ibfk_1` FOREIGN KEY (`id_calificacion`) REFERENCES `calificaciones_calificaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

