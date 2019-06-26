insert  into `franky`(`php`,`css`,`js`,`jquery`,`permisos`,`constante`,`url`,`nombre`,`ajax`,`status`,`editable`,`modulo`) values ('admin/301/lista.php','','','[]','[1,2]','LISTA_REDIRECCIONES_301','admin/redireccion-301/','Redirecciones','[\"base/ajax.admin.js\"]',1,0,'seo');
insert  into `franky`(`php`,`css`,`js`,`jquery`,`permisos`,`constante`,`url`,`nombre`,`ajax`,`status`,`editable`,`modulo`) values ('admin/301/form.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[1,2]','FRM_REDIRECCIONES_301','admin/redireccion-301/frm/','Alta de 301','',1,0,'seo');
insert  into `franky`(`php`,`css`,`js`,`jquery`,`permisos`,`constante`,`url`,`nombre`,`ajax`,`status`,`editable`,`modulo`) values('admin/seo/lista.php','','','[]','[1,2]','ADMIN_SEO','admin/seo/metatags/','Metatags','[\"base/ajax.admin.js\"]',1,0,'seo');
insert  into `franky`(`php`,`css`,`js`,`jquery`,`permisos`,`constante`,`url`,`nombre`,`ajax`,`status`,`editable`,`modulo`) values('admin/seo/form.php','','[\"validaciones.js\"]','[\"jquery-validate\",\"tags\"]','[1,2]','FRM_SEO','admin/seo/metatags/frm/','Alta de metetags','',1,0,'seo');

/*Table structure for table `seo` */

DROP TABLE IF EXISTS `seo`;

CREATE TABLE `seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_franky` int(11) DEFAULT NULL,
  `lang` char(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'es_MX',
  `titulo` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8_unicode_ci NOT NULL,
  `keywords` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `fecha` datetime NOT NULL,
  `extra` text DEFAULT NULL,
  `updateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_franky` (`id_franky`),
  CONSTRAINT `seo_ibfk_1` FOREIGN KEY (`id_franky`) REFERENCES `franky` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `seo` */
