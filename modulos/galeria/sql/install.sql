

DROP TABLE IF EXISTS `albumes_galeria`;

CREATE TABLE `albumes_galeria` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) DEFAULT NULL,
  `friendly` varchar(250) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `orden` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;



DROP TABLE IF EXISTS `fotos_galeria`;

CREATE TABLE `fotos_galeria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_album` int(11) DEFAULT NULL,
  `foto` varchar(250) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `fecha` datetime DEFAULT NULL,
  `orden` int(10) DEFAULT NULL,
  `descripcion` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=723 DEFAULT CHARSET=utf8;


insert  into `franky`(`php`,`css`,`js`,`jquery`,`permisos`,`constante`,`url`,`nombre`,`ajax`,`status`,`editable`,`modulo`) values ('admin/galeria/albumes.php','','[\"galeria.js\"]','[\"jquery-validate\"]','[1,2]','ANMIN_ALBUM_GALERIA','admin/galeria/albumes/','Albumes','[\"base/ajax.admin.js\",\"galeria/ajax.admin.js\"]',1,0,'galeria'),
('admin/galeria/fotos.php','[\"galeria.css\"]','[\"galeria.js\"]','[\"photoswipe\",\"ajaxform\"]','[1,2]','ADMIN_FOTOS_GALERIA','admin/galeria/albumes/fotos/','Fotos','[\"base/ajax.admin.js\",\"galeria/ajax.admin.js\"]',1,0,'galeria'),
('galeria/albumes.php','','','[]','','GALERIA','galeria/','Galeria','',1,0,'galeria'),
('galeria/fotos.php','','','[\"photoswipe\"]','','GALERIA_DETALLE','galeria/[album]/','Album','',1,0,'galeria');

