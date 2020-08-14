DROP TABLE IF EXISTS cms;

CREATE TABLE cms (
  id int(11) NOT NULL AUTO_INCREMENT,
  titulo varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  mostrar_titulo int(11) DEFAULT '0',
  friendly varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  template text COLLATE utf8_unicode_ci NOT NULL,
  fecha datetime NOT NULL,
  status int(11) NOT NULL DEFAULT '1',
  meta_titulo varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  meta_descripcion varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table 'cms' */
insert into `cms` (`id`, `titulo`, `friendly`, `template`, `fecha`, `status`, `meta_titulo`, `meta_descripcion`) values('1','Condiciones de uso','/condiciones-de-uso/','<div class=\"col1\">&nbsp;</div>\r\n<div class=\"col2\">\r\n<div class=\"output-container\">\r\n<div id=\"output\">\r\n<p>Lorem ipsum dolor sit amet consectetur adipiscing elit feugiat augue blandit non ad egestas, bibendum velit varius auctor aliquam fringilla ultrices phasellus tincidunt tempus nec orci, posuere torquent sapien dapibus potenti maecenas consequat himenaeos facilisis eros suspendisse eu. Semper ligula netus convallis nibh hac pharetra aptent integer, urna turpis lacus est torquent leo varius mollis, nam ut sollicitudin mus nostra sodales morbi hendrerit, gravida tempus quisque elementum suspendisse per euismod. Nullam mollis blandit lacus curabitur ut per dis, habitant libero convallis eu platea torquent cras aliquet, facilisi quis sociosqu vitae scelerisque placerat.</p>\r\n<p>Vivamus felis condimentum sem bibendum rutrum porttitor, vel egestas massa blandit euismod, venenatis in augue elementum facilisi. Sapien eu orci ornare class pulvinar penatibus viverra vel, volutpat dignissim sed netus per erat vehicula facilisi mollis, sem tempor quis tortor felis morbi mi. Molestie urna taciti varius vel sagittis suspendisse eu vivamus mattis ridiculus, pretium dapibus auctor lectus vulputate cubilia etiam commodo cum duis velit, dictum hendrerit magna tempus nascetur natoque sociis et justo. Purus sollicitudin justo mi nascetur semper, augue ut cubilia nisi porta, ridiculus curae ad suspendisse.</p>\r\n</div>\r\n</div>\r\n</div>','2018-06-14 14:42:37','1','Condiciones de uso','Condiciones de uso');
insert into `cms` (`id`, `titulo`, `friendly`, `template`, `fecha`, `status`, `meta_titulo`, `meta_descripcion`) values('2','Aviso de privacidad','/aviso-de-privacidad/','<div class=\"col1\">&nbsp;</div>\r\n<div class=\"col2\">\r\n<div class=\"output-container\">\r\n<div id=\"output\">\r\n<p>Lorem ipsum dolor sit amet consectetur adipiscing elit feugiat augue blandit non ad egestas, bibendum velit varius auctor aliquam fringilla ultrices phasellus tincidunt tempus nec orci, posuere torquent sapien dapibus potenti maecenas consequat himenaeos facilisis eros suspendisse eu. Semper ligula netus convallis nibh hac pharetra aptent integer, urna turpis lacus est torquent leo varius mollis, nam ut sollicitudin mus nostra sodales morbi hendrerit, gravida tempus quisque elementum suspendisse per euismod. Nullam mollis blandit lacus curabitur ut per dis, habitant libero convallis eu platea torquent cras aliquet, facilisi quis sociosqu vitae scelerisque placerat.</p>\r\n<p>Vivamus felis condimentum sem bibendum rutrum porttitor, vel egestas massa blandit euismod, venenatis in augue elementum facilisi. Sapien eu orci ornare class pulvinar penatibus viverra vel, volutpat dignissim sed netus per erat vehicula facilisi mollis, sem tempor quis tortor felis morbi mi. Molestie urna taciti varius vel sagittis suspendisse eu vivamus mattis ridiculus, pretium dapibus auctor lectus vulputate cubilia etiam commodo cum duis velit, dictum hendrerit magna tempus nascetur natoque sociis et justo. Purus sollicitudin justo mi nascetur semper, augue ut cubilia nisi porta, ridiculus curae ad suspendisse.</p>\r\n</div>\r\n</div>\r\n</div>','2020-03-08 23:35:10','1','Aviso de privacidad','Aviso de privacidad');
/*Table structure for table 'comentarios' */

DROP TABLE IF EXISTS comentarios;

CREATE TABLE comentarios (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(200) NOT NULL,
  email varchar(250) NOT NULL,
  asunto varchar(200) NOT NULL,
  telefono varchar(50) DEFAULT NULL,
  comentario text NOT NULL,
  fecha datetime NOT NULL,
  ip varchar(15) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;



/*Table structure for table 'emails' */

DROP TABLE IF EXISTS emails;

CREATE TABLE emails (
  id int(11) NOT NULL AUTO_INCREMENT,
  email varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table 'emails' */

/*Table structure for table 'franky' */

DROP TABLE IF EXISTS franky;

CREATE TABLE franky (
  id int(11) NOT NULL AUTO_INCREMENT,
  php varchar(255) NOT NULL,
  css text NOT NULL,
  js text NOT NULL,
  jquery text NOT NULL,
  permisos text NOT NULL,
  constante varchar(100) NOT NULL,
  url varchar(100) NOT NULL,
  nombre varchar(250) NOT NULL,
  ajax text NOT NULL,
  status int(11) NOT NULL DEFAULT '1',
  editable int(11) NOT NULL DEFAULT '1',
  modulo varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table 'franky' */

insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('home.php','','','[\"flexslider\"]','[]','HOME','home','home','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('404.php','','','','','ERR_404','404/','404','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('frmlogin.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','','LOGIN','login/','login','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('frmforgot.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','','FORGOT','forgot/','Olvido su contraseña','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('contactanos.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[]','CONTACTANOS','contactanos/','Contactanos','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/index.php','','','[]','[\"1\",\"2\",\"3\"]','ADMIN','admin/','Administracion','[\"base/ajax.common.js\"]',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/users/lista.php','','','[]','[\"1\"]','LISTA_OPERADORES','admin/operadores/','Usuaruis','[\"base/ajax.admin.js\"]',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/users/form.users.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[\"1\",\"2\",\"3\"]','FRM_OPERADORES','admin/operadores/frm/','Alta de usuarios','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('registro/form.users.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','','REGISTRO','registro/','Registro de usuarios','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/users/form.pass.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[\"1\"]','FRM_PASS_OPERADORES','admin/operadores/cambiar-contrasena/','Cambiar contraseña','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/users/form.pass.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[\"1\",\"2\",\"3\"]','FRM_MY_PASSWORD','admin/cambiar-mi-contrasena/','Cambiar mi contraseña','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('/admin/mailing/lista.php','','','','[\"1\"]','MAILING','admin/mailing/','Newsletter','[\"base/ajax.admin.js\"]',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/contacto/lista.php','','','','[\"1\"]','CONTACTOS_LIST','admin/contactanos/','Contactanos','[\"base/ajax.admin.js\"]',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('/admin/users/form.delete.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[\"1\",\"2\",\"3\"]','FRM_ELIMINAR_USER','admin/eliminar-mi-cuenta/','Eliminar cuenta','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/template_email/lista.php','','','[]','[1]','LISTA_EMAIL_TEMPLATE','admin/email-template/','Transaccionales','[\"base/ajax.admin.js\"]',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/template_email/form.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[1]','FRM_EMAIL_TEMPLATE','admin/email-template/frm/','Alta transaccionales','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/cms/lista.php','','','[]','[1,2]','LISTA_CMS_TEMPLATE','admin/cms/','CMS','[\"base/ajax.admin.js\"]',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/cms/form.php','','[\"validaciones.js\"]','[\"jquery-validate\",\"flexslider\"]','[1,2]','FRM_CMS_TEMPLATE','admin/cms/frm/','Alta CMS','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('cms.php','','','[\"flexslider\"]','','CMS','cms/','CMS','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('gracias.php','','','','','GRACIAS','gracias/','gracias','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/url_internacional/lista.php','','','[]','[1,2]','ADMIN_URL_INTERNACIONAL','admin/url-internacional/','URL internacional','[\"base/ajax.admin.js\"]',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values ('admin/url_internacional/form.php','','[\"validaciones.js\"]','[\"jquery-validate\"]','[1,2]','FRM_URL_INTERNACIONAL','admin/url-internacional/frm/','Alta de URL internacional','',1,0,'base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values('admin/users/avatar.php','','','[]','[\"1\",\"2\",\"3\"]','ADMIN_AVATAR','admin/avatar/','Administracion de avatar','[\"base/ajax.common.js\"]','1','0','base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values('admin/core_config/form.php','','','[\"jquery-validate\"]','[\"1\"]','ADMIN_CORE_CONFIG','admin/core-config/','Administracion de sistema','','1','0','base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values('admin/core_config/form.php','','','[\"jquery-validate\"]','[\"1\"]','ADMIN_CORE_CONFIG_SECCION','admin/core-config/[seccion]/','Administracion de sistema','','1','0','base');
insert into franky (php, css, js, jquery, permisos, constante, url, nombre, ajax, status, editable, modulo) values('admin/devices/lista.php','','','','[\"1\",\"2\",\"3\"]','ADMIN_DEVICES','admin/devices/','Administracion de dispositivos','','1','0','base');

/*Table structure for table 'seo' */

/*Table structure for table 'mailing' */

DROP TABLE IF EXISTS mailing;

CREATE TABLE mailing (
  id int(11) NOT NULL AUTO_INCREMENT,
  email varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  fecha datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table 'mailing' */

/*Table structure for table 'redirecciones' */

DROP TABLE IF EXISTS redirecciones;

CREATE TABLE redirecciones (
  id int(11) NOT NULL AUTO_INCREMENT,
  url varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  redireccion varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  status int(11) NOT NULL DEFAULT '1',
  fecha datetime NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table 'redirecciones' */



/*Table structure for table 'templates_email' */

DROP TABLE IF EXISTS secciones_transaccionales;

CREATE TABLE secciones_transaccionales (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(200) NOT NULL,
  frinedly varchar(200) NOT NULL,
  status int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table 'secciones_transaccionales' */

insert  into secciones_transaccionales(id,nombre,frinedly,status) values
  (1,'Registro de usuario Frontend','registro-de-usuario-frontend',1),
  (2,'Registro de usuario backend','registro-de-usuario-backend',1),
  (3,'Confirmacion de email','confirmacion-de-email',1),
  (4,'Recuperar contraseña','recuperar-contrasena',1),
  (5,'Contactanos','contactanos',1),
  (6,'Nuevo dispositivo','nuevo-dispositivo',1),
  (7,'Notificacion de contactanos para usuario','contactanos-user-notification',1);

/*Table structure for table 'templates_email' */

DROP TABLE IF EXISTS templates_email;

CREATE TABLE templates_email (
  id int(11) NOT NULL AUTO_INCREMENT,
  nombre varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  id_transaccional int(11) NOT NULL DEFAULT 0,
  status int(11) NOT NULL DEFAULT 1,
  fecha datetime NOT NULL,
  Asunto varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  destinatario text COLLATE utf8_unicode_ci NOT NULL,
  cc text COLLATE utf8_unicode_ci DEFAULT NULL,
  bcc text COLLATE utf8_unicode_ci DEFAULT NULL,
  name_from varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  email_from varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  reply varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  editable int(11) NOT NULL DEFAULT 1,
  html text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (id),
  KEY id_transaccional (id_transaccional),
  CONSTRAINT templates_email_ibfk_1 FOREIGN KEY (id_transaccional) REFERENCES secciones_transaccionales (id) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table 'templates_email' */

insert  into templates_email(id,nombre,id_transaccional,status,fecha,Asunto,destinatario,cc,bcc,name_from,email_from,reply,editable,html) values
  (1,'Registro sin confirmación de email',2,1,'2015-03-01 00:00:00','Alta de usuario','[\"{email}\"]','[\"\"]','[\"\"]','Webmaster','webmaster@test.com','webmaster@test.com',0,'<p>{usuario}</p><p><img src=\"http://local.inmo/upload/email_template/250px_Saiyajin.jpg\" alt=\"\" width=\"250\" height=\"411\" /><br /> Gracias por registrarte en {nombre_web}. Si usted no se ha registrado haga caso omiso de este mensaje. <br /><br /><strong> Su nombre de usuario es {usuario}</strong><br /><strong> Su clave de usuario es {contrasena}</strong> <br /><br /> Este mensaje fue generado automaticamente favor de no responderlo.</p>'),
  (2,'Registro con confirmacion de email',1,1,'2015-03-01 00:00:00','Alta de usuario con confirmacion de email','[\"{email}\"]','[]','[]','Webmaster','webmaster@test.com','webmaster@test.com',0,'{usuario}<br /><br />Gracias por registrarte en {nombre_web}.Si usted no se ha registrado haga caso omiso de este mensaje.<br /><br />Su  nombre de usuario es {usuario}<br />Su clave de usuario es {contrasena}<br /><br /><p>Para completar tu registro, te pedimos confirmar tus datos. S&oacute;lo haz click <a href=\"http://{url}/registro/verificacion.php?key={token}\" >click aqu&iacute;</a><br /><br />Este mensaje fue generado automaticamente favor de no responderlo.'),
  (3,'Verificacion de email',3,1,'2015-03-01 00:00:00','Verificacion de Registro','[\"{email}\"]','[]','[]','Webmaster','webmaster@test.com','webmaster@test.com',0,'<p>Para completar tu registro, te pedimos confirmar tus datos. S&oacute;lo haz click <a href=\"http://{url}/registro/verificacion.php?key={token}\" style=\"color:#ff7905;\">click aqu&iacute;</a></p>'),
  (4,'Recuperar contraseña',4,1,'2015-03-01 00:00:00','Recuperar contraseÃ±a','[\"{email}\"]','[]','[]','Webmaster','webmaster@test.com','webmaster@test.com',0,'{usuario}<br /><br />Este correo ha sido enviado para recordarle sus credenciales de autentificacion para {nombre_web}.Si usted no ha solicitado esta informacion haga caso omiso de este mensaje.<br /><br />Su  nombre de usuario es {usuario}<br />Su clave de usuario es {password}<br /><br />Este mensaje fue generado automaticamente favor de no responderlo.'),
  (5,'Contactanos',5,1,'2015-03-01 00:00:00','Contactanos','[\"ussiel@gmail.com\"]','[\"\"]','[\"\"]','Webmaster','webmaster@test.com','{email}',0,'<table style=\"font-family: Arial, Helvetica, sans-serif; color: #333;\" border=\"0\" width=\"500\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td style=\"font-size: 25px; font-family: \'Times New Roman\', Times, serif;\" width=\"80%\">{sitio_titulo}</td>\r\n<td style=\"background: #A00; color: #fff; font-size: 15px; text-align: right; padding-right: 5px;\" width=\"20%\">ContÃ¡ctanos</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table style=\"font-family: Arial, Helvetica, sans-serif; color: #000; font-size: 14px;\" border=\"0\" width=\"500\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"right\" width=\"100\">Nombre:</td>\r\n<td style=\"color: #333;\" align=\"left\">{nombre}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">E-Mail:</td>\r\n<td style=\"color: #333;\" align=\"left\">{email}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">TelÃ©fono:</td>\r\n<td style=\"color: #333;\" align=\"left\">{telefono}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">Asunto:</td>\r\n<td style=\"color: #333;\" align=\"left\">{asunto}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">Comentarios:</td>\r\n<td style=\"color: #333;\" align=\"left\">{comentarios}</td>\r\n</tr>\r\n</tbody>\r\n</table>');
  insert into templates_email (id, nombre, id_transaccional, status, fecha, Asunto, destinatario, cc, bcc, name_from, email_from, reply, editable, html)
  values(6,'Nuevo dispositivo',6,'1','2019-04-10 17:07:46','Se detecto un nuevo inicio de sesion','[\"{email}\"]','','','Webmaster','webmaster@test.com','webmaster@test.com','0','<table style=\"font-family: Arial, Helvetica, sans-serif; color: #333;\" border=\"0\" width=\"500\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td style=\"font-size: 25px; font-family: \'Times New Roman\', Times, serif;\" width=\"80%\">\r\nHola {nombre} hemos detectado un nuevo inicio de sesion desde un dispositivo desconocido, entra a tu panel de control para verificar y administrar tus dispositivos\r\n</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table style=\"font-family: Arial, Helvetica, sans-serif; color: #000; font-size: 14px;\" border=\"0\" width=\"500\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"right\" width=\"100\">Sistema operativo:</td>\r\n<td style=\"color: #333;\" align=\"left\">{os}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">Tipo de dispositivo:</td>\r\n<td style=\"color: #333;\" align=\"left\">{type}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">IP:</td>\r\n<td style=\"color: #333;\" align=\"left\">{ip}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">User-Agent:</td>\r\n<td style=\"color: #333;\" align=\"left\">{user_agent}</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>');
  insert into templates_email (id, nombre, id_transaccional, status, fecha, Asunto, destinatario, cc, bcc, name_from, email_from, reply, editable, html)
  values(7,'Notificacion de contactanos para usuario',7,'1','2019-04-10 17:07:46','Tu solicitud fue recibida','[\"{email}\"]','','','Webmaster','webmaster@test.com','webmaster@test.com','0','<table style=\"font-family: Arial, Helvetica, sans-serif; color: #333;\" border=\"0\" width=\"500\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td style=\"font-size: 25px; font-family: \'Times New Roman\', Times, serif;\" width=\"80%\">{sitio_titulo}</td>\r\n<td style=\"background: #A00; color: #fff; font-size: 15px; text-align: right; padding-right: 5px;\" width=\"20%\">Información recibida</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<table style=\"font-family: Arial, Helvetica, sans-serif; color: #000; font-size: 14px;\" border=\"0\" width=\"500\" align=\"center\">\r\n<tbody>\r\n<tr>\r\n<td align=\"right\" width=\"100\">Nombre:</td>\r\n<td style=\"color: #333;\" align=\"left\">{nombre}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">E-Mail:</td>\r\n<td style=\"color: #333;\" align=\"left\">{email}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">TelÃ©fono:</td>\r\n<td style=\"color: #333;\" align=\"left\">{telefono}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">Asunto:</td>\r\n<td style=\"color: #333;\" align=\"left\">{asunto}</td>\r\n</tr>\r\n<tr>\r\n<td align=\"right\">Comentarios:</td>\r\n<td style=\"color: #333;\" align=\"left\">{comentarios}</td>\r\n</tr>\r\n</tbody>\r\n</table>');

/*Table structure for table 'users' */

DROP TABLE IF EXISTS users;

CREATE TABLE users (
  id int(11) NOT NULL AUTO_INCREMENT,
  usuario varchar(30) NOT NULL,
  contrasena varchar(255) NOT NULL,
  email varchar(100) NOT NULL,
  nivel int(2) NOT NULL DEFAULT '0',
  fecha date NOT NULL,
  ultimoAcceso date DEFAULT NULL,
  status int(1) NOT NULL DEFAULT '1',
  nombre varchar(255) NOT NULL,
  fecha_nacimiento date DEFAULT NULL,
  sexo char(1) DEFAULT 'h',
  telefono varchar(21) DEFAULT NULL,
  verificado int(11) NOT NULL,
  biografia text,
  PRIMARY KEY (id)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table 'users' */

insert  into users(id,usuario,contrasena,email,nivel,fecha,ultimoAcceso,status,nombre,fecha_nacimiento,sexo,telefono,verificado,biografia) values (1,'Molder','e10adc3949ba59abbe56e057f20f883e','ussiel@gmail.com',777,'0000-00-00','2016-06-06',1,'ussiel','0000-00-00','h','',0,NULL),(2,'alberto','2c670abaab2f82977e9a172ffed23de4','oxtlimail@gmail.com',777,'2013-03-05','2015-11-23',1,'','0000-00-00','','',0,NULL);

/*Table structure for table 'verificaciones_pendientes' */

DROP TABLE IF EXISTS verificaciones_pendientes;

CREATE TABLE verificaciones_pendientes (
  id int(11) NOT NULL AUTO_INCREMENT,
  token varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  id_user int(11) NOT NULL,
  fecha date NOT NULL,
  hora time NOT NULL,
  PRIMARY KEY (id),
  KEY id_user (id_user),
  CONSTRAINT verificaciones_pendientes_ibfk_1 FOREIGN KEY (id_user) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


DROP TABLE IF EXISTS avatares;

CREATE TABLE avatares (
  id int(11) NOT NULL AUTO_INCREMENT,
  id_user int(11) NOT NULL,
  name varchar(25) DEFAULT NULL,
  url varchar(255) DEFAULT NULL,
  status int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  KEY id_user (id_user),
  CONSTRAINT avatares_ibfk_1 FOREIGN KEY (id_user) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

insert  into avatares(id_user,name,url,status) values (1,'gravatar','https://www.gravatar.com/avatar/d15d103f43c648abf5af15d2a6b8fcdf',0);
insert  into avatares(id_user,name,url,status) values (2,'gravatar','https://www.gravatar.com/avatar/8a561ae0822d948a4a0beb5b47e5d228',0);

  /*Table structure for table 'seo' */

  DROP TABLE IF EXISTS url_internacionalizacion;

  CREATE TABLE url_internacional (
    id int(11) NOT NULL AUTO_INCREMENT,
    id_franky int(11) DEFAULT NULL,
    lang char(5) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'es_MX',
    url varchar(100) COLLATE utf8_unicode_ci NOT NULL,
    status int(1) NOT NULL DEFAULT '1',
    fecha datetime NOT NULL,
    PRIMARY KEY (id),
    KEY id_franky (id_franky),
    CONSTRAINT url_internacional_ibfk_1 FOREIGN KEY (id_franky) REFERENCES franky (id) ON DELETE CASCADE ON UPDATE CASCADE
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

  /*Data for the table 'seo' */


DROP TABLE IF EXISTS core_config;

CREATE TABLE core_config (
  id int(11) NOT NULL AUTO_INCREMENT,
  path varchar(255) NOT NULL,
  value text DEFAULT NULL,
  modulo varchar(50) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS user_device;

CREATE TABLE user_device (
  id int(11) NOT NULL AUTO_INCREMENT,
  type varchar(20) NOT NULL,
  os varchar(50) NOT NULL,
  user_agent text NOT NULL,
  ip varchar(15) NOT NULL,
  create_at datetime NOT NULL,
  access_last datetime NOT NULL,
  status int(11) NOT NULL,
  device_id varchar(255) DEFAULT NULL,
  id_user int(11) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;



/*Table structure for table `custom_attributes` */

DROP TABLE IF EXISTS `custom_attributes`;

CREATE TABLE `custom_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `label` varchar(255) NOT NULL,
  `type` varchar(20) NOT NULL,
  `data` text DEFAULT NULL,
  `source` text DEFAULT NULL,
  `entity` varchar(255) NOT NULL,
  `createdAt` datetime NOT NULL,
  `updateAt` datetime DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `custom_attributes_values`;

CREATE TABLE `custom_attributes_values` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_attribute` int(11) NOT NULL,
  `id_ref` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
