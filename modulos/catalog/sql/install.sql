
/*Table structure for table `catalog_category` */

DROP TABLE IF EXISTS `catalog_category`;

CREATE TABLE `catalog_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `visible_in_search` int(11) NOT NULL DEFAULT 1,
  `users` text DEFAULT NULL,
  `meta_title` varchar(60) DEFAULT NULL,
  `meta_description` varchar(140) DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `url_key` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `createdAt` datetime NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `catalog_product_related` */

DROP TABLE IF EXISTS `catalog_product_related`;

CREATE TABLE `catalog_product_related` (
  `id_parent` int(11) NOT NULL,
  `id_product` int(11) NOT NULL,
  PRIMARY KEY (`id_parent`,`id_product`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*Table structure for table `catalog_products` */

DROP TABLE IF EXISTS `catalog_products`;

CREATE TABLE `catalog_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `category` text NOT NULL,
  `visible_in_search` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `images` text DEFAULT NULL,
  `videos` text DEFAULT NULL,
  `url_key` varchar(255) NOT NULL,
  `meta_title` varchar(60) DEFAULT NULL,
  `meta_keyword` text DEFAULT NULL,
  `meta_description` varchar(160) DEFAULT NULL,
  `price` varchar(15) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `iva` int(11) DEFAULT NULL,
  `incluye_iva` int(11) DEFAULT NULL,
  `createdAt` datetime NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `in_stock` int(11) NOT NULL DEFAULT 1,
  `saleable` int(11) DEFAULT 0,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Table structure for table `catalog_subcategory` */

DROP TABLE IF EXISTS `catalog_subcategory`;

CREATE TABLE `catalog_subcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_category` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `visible_in_search` int(11) NOT NULL DEFAULT 1,
  `users` text DEFAULT NULL,
  `meta_title` varchar(60) DEFAULT NULL,
  `meta_description` varchar(140) DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `url_key` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `createdAt` datetime NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Table structure for table `catalog_subcategory_product` */

DROP TABLE IF EXISTS `catalog_subcategory_product`;

CREATE TABLE `catalog_subcategory_product` (
  `id_subcategory` int(11) NOT NULL,
  `id_product` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `catalog_wishlist`;

CREATE TABLE `catalog_wishlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `status` int(11) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/catalog_category/lista.php','','','[]','[1,2]','ADMIN_CATALOG_CATEGORY','admin/catalog-category/','Categorias del catalogo','[\"base/ajax.admin.js\"]','1','0','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/catalog_subcategory/lista.php','','','[]','[1,2]','ADMIN_CATALOG_SUBCATEGORY','admin/catalog-subcategory/','Subcategorias del catalogo','[\"base/ajax.admin.js\"]','1','0','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/catalog_category/form.php','','[\"validaciones.js\"]','[\"jquery-validate\",\"tags\"]','[1,2]','FRM_CATALOG_CATEGORY','admin/catalog-category/frm/','Alta de categorias del catalogo','','1','0','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/catalog_subcategory/form.php','','[\"validaciones.js\"]','[\"jquery-validate\",\"tags\"]','[1,2]','FRM_CATALOG_SUBCATEGORY','admin/catalog-subcategory/frm/','Alta de subcategorias del catalogo','','1','0','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/catalog_products/lista.php','','','[]','[1,2]','ADMIN_CATALOG_PRODUCTS','admin/catalog-products/','Productos','[\"base/ajax.admin.js\"]','1','0','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/catalog_products/form.php','','[\"validaciones.js\"]','[\"jquery-validate\",\"tags\"]','[1,2]','FRM_CATALOG_PRODUCTS','admin/catalog-products/frm/','Alta de productos','[\"base/ajax.admin.js\",\"catalog/ajax.admin.js\"]','1','0','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('products/lista.php','','','','','CATALOG_SEARCH','productos/','Lista de resultados de productos','','1','1','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('products/view.php','','','[\"jquery-validate\",\"slick\",\"photoswipe\"]','','CATALOG_VIEW','productos/[friendly].html','Detalle del producto','','1','1','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('admin/wishlist/lista.php','','','','[1,2]','ADMIN_WISHLIST','admin/wishlist/','Administras whishlist','[\"base/ajax.admin.js\"]','1','1','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('products/lista.php','','','','','CATALOG_SEARCH_CATEGORY','productos/[categoria]/','Lista de resultados de productos','','1','1','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('products/lista.php','','','','','CATALOG_SEARCH_SUBCATEGORY','productos/[categoria]/[subcategoria]/','Lista de resultados de productos','','1','1','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('products/view.php','','','[\"jquery-validate\",\"slick\",\"photoswipe\"]','','CATALOG_VIEW_CAT','productos/[categoria]/[friendly].html','Detalle del producto landing categoria','','1','1','catalog');
insert into `franky` ( `php`, `css`, `js`, `jquery`, `permisos`, `constante`, `url`, `nombre`, `ajax`, `status`, `editable`, `modulo`) values('products/view.php','','','[\"jquery-validate\",\"slick\",\"photoswipe\"]','','CATALOG_VIEW_SUBCAT','productos/[categoria]/[subcategoria]/[friendly].html','Detalle del producto landing subcategoria','','1','1','catalog');
