insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/blog/categorias/lista.php','','','[]','[1,2]','ADMIN_LISTA_CATEGORIAS_BLOG','admin/categorias-blog/','Categorias','[\"base/ajax.admin.js\",\"blog/ajax.admin.js\"]','1','0','blog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/blog/categorias/form.php','','[\"validaciones.js\"]','[\"jquery-validate\",\"guillotine\"]','[1,2]','ADMIN_FRM_CATEGORIAS_BLOG','admin/categorias-blog/frm/','Alta de categorias','','1','0','blog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/blog/articulos/lista.php','','','[]','[1,2]','ADMIN_LISTA_ARTICULOS_BLOG','admin/articulos-blog/','Articulos','[\"base/ajax.admin.js\",\"blog/ajax.admin.js\"]','1','0','blog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/blog/articulos/form.php','','[\"validaciones.js\"]','[\"jquery-validate\",\"tags\",\"guillotine\"]','[1,2]','ADMIN_FRM_ARTICULOS_BLOG','admin/articulos-blog/frm/','Alta de articulos','[\"base/ajax.admin.js\"]','1','0','blog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('blog/articulos/detalle.php','','','[\"jquery-validate\",\"flexslider\"]','','BLOG_DETALLE','blog/[categoria]/[articulo]/','Articulo','[\"blog/ajax.blog.js\"]','1','0','blog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/blog/calificaciones/lista.php','','','','[1,2,3]','ADMIN_LISTA_CALIFICACIONES_ARTICULOS_BLOG','admin/calificaciones-blog/','Calificaciones','[\"base/ajax.admin.js\",\"blog/ajax.admin.js\"]','1','0','blog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/blog/comentarios/lista.php','','','[]','[1,2,3]','ADMIN_LISTA_OPINIONES_ARTICULOS_BLOG','admin/comentarios-blog/','Comentarios','[\"base/ajax.admin.js\",\"blog/ajax.admin.js\"]','1','0','blog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('blog/articulos/lista.php','','','','','BLOG_CATEGORIA','blog/[categoria]/','Categoria','','1','0','blog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('blog/articulos/lista.php','','','','','BLOG','blog/','Blog','','1','0','blog');
/*Table structure for table `blog` */

/*Table structure for table `categorias_blog` */

DROP TABLE IF EXISTS `categorias_blog`;

CREATE TABLE `categorias_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) NOT NULL,
  `imagen` varchar(255)  NULL,
  `imagen_portada` varchar(255)  NULL,
  `friendly` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `visible` int(11) NOT NULL DEFAULT '1',
  `permisos` text NOT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `categorias_blog` */

DROP TABLE IF EXISTS `blog`;

CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria` int(11) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `imagen_portada` varchar(255) NOT NULL,
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
  `visible_in_search` int(11) NOT NULL DEFAULT '1',
  `permisos` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `autor` (`autor`),
  KEY `categoria` (`categoria`),
  CONSTRAINT `blog_ibfk_2` FOREIGN KEY (`categoria`) REFERENCES `categorias_blog` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `blog_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `blog` */

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
  `nombre` varchar(50) NOT NULL,
  `comentario` varchar(140) NOT NULL,
  `titulo` varchar(100) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `reportado` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id_blog` (`id_blog`),
  KEY `usuario` (`usuario`),
  CONSTRAINT `comentarios_blog_ibfk_1` FOREIGN KEY (`id_blog`) REFERENCES `blog` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `borrador_blog`;

CREATE TABLE `borrador_blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `data` text NOT NULL,
  `fecha` datetime NOT NULL,
  `id_blog` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
