


/*Table structure for table `cms` */

DROP TABLE IF EXISTS `cms`;

CREATE TABLE `cms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `friendly` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `template` text COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `meta_titulo` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `meta_descripcion` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `cms` */

/*Table structure for table `comentarios` */

DROP TABLE IF EXISTS `comentarios`;

CREATE TABLE `comentarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(200) NOT NULL,
  `email` varchar(250) NOT NULL,
  `asunto` varchar(200) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `comentario` text NOT NULL,
  `fecha` datetime NOT NULL,
  `ip` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `comentarios` */


/*Table structure for table `emails` */

DROP TABLE IF EXISTS `emails`;

CREATE TABLE `emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `emails` */

/*Table structure for table `franky` */

DROP TABLE IF EXISTS `franky`;

CREATE TABLE `franky` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `php` varchar(255) NOT NULL,
  `css` text NOT NULL,
  `js` text NOT NULL,
  `jquery` text NOT NULL,
  `permisos` text NOT NULL,
  `constante` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `nombre` varchar(250) NOT NULL,
  `ajax` text NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `editable` int(11) NOT NULL DEFAULT '1',
  `modulo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Data for the table `franky` */

insert  into `franky`(`id`,`php`,`css`,`js`,`jquery`,`permisos`,`constante`,`url`,`nombre`,`ajax`,`status`,`editable`,`modulo`) values (1,'home.php','','','[\"flexslider\"]','[]','HOME','home','home','',1,0,'base'),(2,'404.php','','','','','ERR_404','404/','404','',1,0,'base'),(3,'frmlogin.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','','LOGIN','login/','login','',1,0,'base'),(4,'frmforgot.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','','FORGOT','forgot/','Olvido su contraseña','',1,0,'base'),(5,'contactanos.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[]','CONTACTANOS','contactanos/','Contactanos','',1,0,'base'),(6,'admin/index.php','','','[]','[\"1\",\"2\",\"3\"]','ADMIN','admin/','Administracion','[\"base/ajax.common.js\"]',1,0,'base'),(7,'admin/users/lista.php','','','[]','[\"1\"]','LISTA_OPERADORES','admin/operadores/','Administrar operadores','[\"base/ajax.admin.js\"]',1,0,'base'),(8,'admin/users/form.users.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[\"1\",\"2\",\"3\"]','FRM_OPERADORES','admin/operadores/frm/','Formulario operadores','',1,0,'base'),(9,'registro/form.users.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','','REGISTRO','registro/','Registro de usuarios','',1,0,'base'),(10,'admin/users/form.pass.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[\"1\",\"2\",\"3\"]','FRM_PASS_OPERADORES','admin/operadores/pass/','Cambiar contraseña','',1,0,'base'),(11,'/admin/mailing/lista.php','','','','[\"1\"]','MAILING','admin/mailing/','lista de emails','[\"base/ajax.admin.js\"]',1,0,'base'),(12,'admin/contacto/lista.php','','','','[\"1\"]','CONTACTOS_LIST','admin/contactanos/','Lista contactos','[\"base/ajax.admin.js\"]',1,0,'base'),(13,'/admin/users/form.delete.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[\"1\",\"2\",\"3\"]','FRM_ELIMINAR_USER','admin/operadores/eliminar-cuenta/','Formulario para eliminar cuenta','',1,0,'base'),(14,'admin/template_email/lista.php','','','[]','[1]','LISTA_EMAIL_TEMPLATE','admin/email-template/','Administrar email templates','[\"base/ajax.admin.js\"]',1,0,'base'),(15,'admin/template_email/form.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[1]','FRM_EMAIL_TEMPLATE','admin/email-template/frm/','Formulario de templates email','',1,0,'base'),(16,'admin/cms/lista.php','','','[]','[1,2]','LISTA_CMS_TEMPLATE','admin/cms/','Administracion de CMS','[\"base/ajax.admin.js\"]',1,0,'base'),(17,'admin/cms/form.php','','[\"validaciones.js\"]','[\"jquery-validate\",\"flexslider\"]','[1,2]','FRM_CMS_TEMPLATE','admin/cms/frm/','Formulario de administracion CMS','',1,0,'base'),(18,'cms.php','','','[\"flexslider\"]','','CMS','[titulo_cms]/','Front CMS','',1,0,'base'),(19,'gracias.php','','','','','GRACIAS','gracias/','gracias','',1,0,'base'),(21,'admin/shell/shell.php','[\"shell.css\"]','','','[1,2]','SHELL','admin/shell/','SHELL','',1,0,'developer'),(22,'admin/franky/lista.php','','','[]','[\"1\"]','LISTA_PAGINAS','admin/paginas/','Lista de paginas','[\"base/ajax.admin.js\"]',1,0,'developer'),(23,'admin/franky/form.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[\"1\"]','FRM_PAGINAS','admin/paginas/frm/','Formulario de paginas','',1,0,'developer'),(24,'admin/ftp/ftp.php','[\"shell.css\"]','','[\"jquery-validate\"]','[1,2]','ADMIN_FTP','admin/ftp/','FTP','[\"developer/ajax.ftp.js\"]',1,0,'developer'),(25,'admin/blog/categorias/lista.php','','','[]','[1,2]','ADMIN_LISTA_CATEGORIAS_BLOG','admin/categorias-blog/','Administrar categorias del blog','[\"base/ajax.admin.js\",\"blog/ajax.admin.js\"]',1,0,'blog'),(26,'admin/blog/categorias/form.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[1,2]','ADMIN_FRM_CATEGORIAS_BLOG','admin/categorias-blog/frm/','Formulario categoria blog','',1,0,'blog'),(27,'admin/blog/articulos/lista.php','','','[]','[1,2]','ADMIN_LISTA_ARTICULOS_BLOG','admin/articulos-blog/','Administrar articulos del blog','[\"base/ajax.admin.js\",\"blog/ajax.admin.js\"]',1,0,'blog'),(28,'admin/blog/articulos/form.php','','[\"validaciones.js\"]','[\"jquery-validate\",\"tags\"]','[1,2]','ADMIN_FRM_ARTICULOS_BLOG','admin/articulos-blog/frm/','Formulario articulos blog','',1,0,'blog'),(29,'blog/articulos/detalle.php','','','[\"jquery-validate\",\"flexslider\"]','','BLOG_DETALLE','blog/[categoria]/[articulo]/','Detalle del articulo del blog','[\"blog/ajax.blog.js\"]',1,0,'blog'),(30,'admin/blog/calificaciones/lista.php','','','','[1,2,3]','ADMIN_LISTA_CALIFICACIONES_ARTICULOS_BLOG','admin/calificaciones-blog/','Lista de las calificacionesdel blog','[\"base/ajax.admin.js\",\"blog/ajax.admin.js\"]',1,0,'blog'),(31,'admin/blog/comentarios/lista.php','','','[]','[1,2,3]','ADMIN_LISTA_OPINIONES_ARTICULOS_BLOG','admin/comentarios-blog/','Lista de comentarios del blog','[\"base/ajax.admin.js\",\"blog/ajax.admin.js\"]',1,0,'blog'),(32,'blog/articulos/lista.php','','','','','BLOG_CATEGORIA','blog/[categoria]/','Lista de articulos blog por categoria','',1,0,'blog'),(33,'blog/articulos/lista.php','','','','','BLOG','blog/','Lista de articulos blog','',1,0,'blog');

/*Table structure for table `mailing` */

DROP TABLE IF EXISTS `mailing`;

CREATE TABLE `mailing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `mailing` */

/*Table structure for table `redirecciones` */

DROP TABLE IF EXISTS `redirecciones`;

CREATE TABLE `redirecciones` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `redireccion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `redirecciones` */

/*Table structure for table `templates_email` */

DROP TABLE IF EXISTS `templates_email`;

CREATE TABLE `templates_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `template` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `fecha` datetime NOT NULL,
  `Asunto` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `destinatario` text COLLATE utf8_unicode_ci NOT NULL,
  `cc` text COLLATE utf8_unicode_ci,
  `bcc` text COLLATE utf8_unicode_ci,
  `name_from` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `email_from` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `reply` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `editable` int(11) NOT NULL DEFAULT '1',
  `html` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `templates_email` */

insert  into `templates_email`(`id`,`nombre`,`template`,`status`,`fecha`,`Asunto`,`destinatario`,`cc`,`bcc`,`name_from`,`email_from`,`reply`,`editable`,`html`) values (1,'Registro sin confirmación de email','mailnuevousuariosimple.tpl',1,'2015-03-01 00:00:00','Alta de usuario','[\"{email}\"]','[\"\"]','[\"\"]','Webmaster','webmaster@test.com','webmaster@test.com',0,''),(2,'Registro con confirmacion de email','mailnuevousuario.tpl',1,'2015-03-01 00:00:00','Alta de usuario con confirmacion de email','[\"{email}\"]','[]','[]','Webmaster','webmaster@test.com','webmaster@test.com',0,''),(3,'Verificacion de email','verificar.usuariosonly.tpl',1,'2015-03-01 00:00:00','Verificacion de Registro','[\"{email}\"]','[]','[]','Webmaster','webmaster@test.com','webmaster@test.com',0,''),(4,'Recuperar contraseña','mailolvidopass.tpl',1,'2015-03-01 00:00:00','Recuperar contraseña','[\"{email}\"]','[]','[]','Webmaster','webmaster@test.com','webmaster@test.com',0,''),(5,'Contactanos','contacto.tpl',1,'2015-03-01 00:00:00','Contactanos','[\"ussiel@gmail.com\"]','[\"\"]','[\"\"]','Webmaster','webmaster@test.com','{email}',0,'<table style=\"font-family: Arial, Helvetica, sans-serif; color: #333;\" border=\"0\" width=\"500\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td style=\"font-size: 25px; font-family: \'Times New Roman\', Times, serif;\" width=\"80%\">{sitio_titulo}</td>\r\n<td style=\"background: #A00; color: #fff; font-size: 15px; text-align: right; padding-right: 5px;\" width=\"20%\">Cont&aacute;ctanos</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table style=\"font-family: Arial, Helvetica, sans-serif; color: #000; font-size: 14px;\" border=\"0\" width=\"500\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"right\" width=\"100\">Nombre:</td>\r\n<td style=\"color: #333;\" align=\"left\">{nombre}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">E-Mail:</td>\r\n<td style=\"color: #333;\" align=\"left\">{email}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">Tel&eacute;fono:</td>\r\n<td style=\"color: #333;\" align=\"left\">{telefono}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">Asunto:</td>\r\n<td style=\"color: #333;\" align=\"left\">{asunto}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">Comentarios:</td>\r\n<td style=\"color: #333;\" align=\"left\">{comentarios}</td>\r\n</tr>\r\n</tbody>\r\n</table>');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) NOT NULL,
  `contrasena` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nivel` int(2) NOT NULL DEFAULT '0',
  `fecha` date NOT NULL,
  `ultimoAcceso` date DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `nombre` varchar(255) NOT NULL,
  `fecha_nacimiento` date DEFAULT NULL,
  `sexo` char(1) DEFAULT 'h',
  `telefono` varchar(21) DEFAULT NULL,
  `verificado` int(11) NOT NULL,
  `biografia` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

insert  into `users`(`id`,`usuario`,`contrasena`,`email`,`nivel`,`fecha`,`ultimoAcceso`,`status`,`nombre`,`fecha_nacimiento`,`sexo`,`telefono`,`verificado`,`biografia`) values (1,'Molder','e10adc3949ba59abbe56e057f20f883e','ussiel@gmail.com',777,'0000-00-00','2016-06-06',1,'ussiel','0000-00-00','h','',0,NULL),(2,'alberto','2c670abaab2f82977e9a172ffed23de4','oxtlimail@gmail.com',777,'2013-03-05','2015-11-23',1,'','0000-00-00','','',0,NULL);

/*Table structure for table `verificaciones_pendientes` */

DROP TABLE IF EXISTS `verificaciones_pendientes`;

CREATE TABLE `verificaciones_pendientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `id_user` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `verificaciones_pendientes_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Table structure for table `avatares` */

DROP TABLE IF EXISTS `avatares`;

CREATE TABLE `avatares` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `name` varchar(25) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `avatares_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `avatares` */

insert  into `avatares`(`id`,`id_user`,`name`,`url`,`status`) values (1,1,'gravatar','https://www.gravatar.com/avatar/d15d103f43c648abf5af15d2a6b8fcdf',0),(2,2,'gravatar','https://www.gravatar.com/avatar/8a561ae0822d948a4a0beb5b47e5d228',0);


/*Table structure for table `blog` */
/*Table structure for table `categorias_blog` */

DROP TABLE IF EXISTS `categorias_blog`;

CREATE TABLE `categorias_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `friendly` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `categorias_blog` */

insert  into `categorias_blog`(`id`,`nombre`,`friendly`,`status`,`fecha`) values (1,'Framework Franky','framework-franky',1,'2017-06-20 16:41:33');



DROP TABLE IF EXISTS `blog`;

CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `destacado` int(11) NOT NULL DEFAULT '0',
  `friendly` varchar(255) NOT NULL,
  `comentarios` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `fecha_modificado` datetime DEFAULT NULL,
  `status` int(11) NOT NULL,
  `autor` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `meta_titulo` varchar(255) NOT NULL,
  `meta_descripcion` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `autor` (`autor`),
  KEY `categoria` (`categoria`),
  CONSTRAINT `blog_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categorias_blog` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `blog` */

insert  into `blog`(`id`,`categoria`,`titulo`,`contenido`,`destacado`,`friendly`,`comentarios`,`fecha`,`fecha_modificado`,`status`,`autor`,`keywords`,`meta_titulo`,`meta_descripcion`) values (2,1,'Nuevo sitio','<p>Para crear nuevos sitios framework franky cuenta con automatizacion de procesos dentro del modulo developer para hacer de esta tarea algo mas rapido y preciso.</p>\r\n<p>1.- Entramos en el path framework_franky/modulos/developer/shell</p>\r\n<p>2.- Ejecutamos el comando \"php nuevo-modulo.php\" para obtener la lista de parametros necesarios.</p>\r\n<p><img src=\"http://local.franky/public/upload/franky/blog/framework_franky/nuevo_sitio/nuevo-modulo-help.png\" alt=\"\" width=\"872\" height=\"429\" /></p>\r\n<p>&nbsp;</p>\r\n<p>3.- Ejecutamos nuevo-modulo.php con los parametros correspondientes, crearemos el modulo de un sitio demo llamado local.franky para el cual necesitaremos crear un modulo principal llamado franky, este modulo puede llamarse como tu quieras pero es buena idea ponerle el mismo nombre que el el sitio.</p>\r\n<p>&nbsp;</p>\r\n<p><img src=\"http://local.franky/public/upload/franky/blog/framework_franky/nuevo_sitio/nuevo-modulo.png\" alt=\"\" width=\"872\" height=\"465\" /></p>\r\n<p>4.- En tu maquina crea un virtualHost para tu sitio (local.franky en este caso), configura una base de datos vacia.</p>\r\n<p>5.- Tu sitio se configura a travez de un archivo ubicado en&nbsp; framework_franky/configure/data.php</p>\r\n<p><code>\'local.franky\' =&gt; <br />&nbsp; array (<br />&nbsp;&nbsp;&nbsp; \'cliente\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp; \'produccion\' =&gt; false,<br />&nbsp;&nbsp;&nbsp; \'path\' =&gt; \'franky\',<br />&nbsp;&nbsp;&nbsp; \'conexion_bd\' =&gt; <br />&nbsp;&nbsp;&nbsp; array (<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'usuario\' =&gt; \'root\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'password\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'basedatos\' =&gt; \'franky\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'host\' =&gt; \'localhost\',<br />&nbsp;&nbsp;&nbsp; ),<br />&nbsp;&nbsp;&nbsp; \'conexion_ftp\' =&gt; <br />&nbsp;&nbsp;&nbsp; array (<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'usuario\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'password\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'host\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp; ),<br />&nbsp;&nbsp;&nbsp; \'modulos\' =&gt; <br />&nbsp;&nbsp;&nbsp; array (<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 0 =&gt; \'developer\',1 =&gt; \'blog\'<br />&nbsp;&nbsp;&nbsp; ),<br />&nbsp;&nbsp;&nbsp; \'conexion_social\' =&gt; <br />&nbsp;&nbsp;&nbsp; array (<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'facebook\' =&gt; <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; array (<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'key\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'consumer\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ),<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'twitter\' =&gt; <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; array (<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'key\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'consumer\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ),<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'google\' =&gt; <br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; array (<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'key\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'consumer\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ),<br />&nbsp;&nbsp;&nbsp; ),<br />&nbsp;&nbsp;&nbsp; \'tinyurl\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp; \'analytics\' =&gt; \'\',<br />&nbsp; ),</code></p>\r\n<p>6.- Llenamos la configuracion de base de datos con los valores correspondientes.</p>\r\n<p><code>\'conexion_ftp\' =&gt; <br />&nbsp;&nbsp;&nbsp; array (<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'usuario\' =&gt; \'root\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'password\' =&gt; \'\',<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; \'host\' =&gt; \'localhost\',<br />&nbsp;&nbsp;&nbsp; ),</code></p>\r\n<p>7.- ejecutamos los script sql de instalacion con ayuda de qsl-install.php ubicado en framework_franky/modulos/developer/shell/sql-install.php. Ejecuta el script para ver la lista de parametros.</p>\r\n<p><img src=\"http://local.franky//public/upload/franky/blog/framework_franky/nuevo_sitio/sql-install-help.png\" alt=\"\" width=\"872\" height=\"465\" /></p>\r\n<p>8.- Ejecutamos sql-install.php para el modulo base, este modulo estara presente en todos los sitios y te servira como punto de partida para tus desarrollos, cuenta con algunos modulos como registro de ususarios, panel de administracion, etc.</p>\r\n<p>&nbsp;</p>\r\n<p><img src=\"http://local.franky//public/upload/franky/blog/framework_franky/nuevo_sitio/sql-install.png\" alt=\"\" width=\"872\" height=\"465\" /></p>\r\n<p>&nbsp;</p>\r\n<p>9.- Ejecutamos sql-install.php para el modulo developer este modulo estara presente en todos los sitios en modo developer y tiene herramientas que te ayudaran en tu desarrollo</p>\r\n<p>&nbsp;<img src=\"http://local.franky//public/upload/franky/blog/framework_franky/nuevo_sitio/sql-install-developer.png\" alt=\"\" width=\"872\" height=\"465\" /></p>\r\n<p>&nbsp;</p>',0,'nuevo-sitio',0,'2017-06-20 17:06:08',NULL,1,1,'framework franky','Documentacion Franky Nuevo Sitio','Documentacion para uso de franky framework, Como crear un nuevo sitio');

/*Table structure for table `calificaciones_blog` */

DROP TABLE IF EXISTS `calificaciones_blog`;

CREATE TABLE `calificaciones_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_blog` int(11) NOT NULL,
  `calificacion` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_blog` (`id_blog`),
  KEY `usuario` (`usuario`),
  CONSTRAINT `calificaciones_blog_ibfk_1` FOREIGN KEY (`id_blog`) REFERENCES `blog` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `calificaciones_blog_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `calificaciones_blog` */

/*Table structure for table `comentarios_blog` */

DROP TABLE IF EXISTS `comentarios_blog`;

CREATE TABLE `comentarios_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_blog` int(11) NOT NULL,
  `usuario` int(11) NOT NULL,
  `comentario` varchar(140) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `reportado` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_blog` (`id_blog`),
  KEY `usuario` (`usuario`),
  CONSTRAINT `comentarios_blog_ibfk_1` FOREIGN KEY (`id_blog`) REFERENCES `blog` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `comentarios_blog_ibfk_2` FOREIGN KEY (`usuario`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `comentarios_blog` */