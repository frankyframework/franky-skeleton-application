<?php

$error_code = 200;
define("REGISTRO_SUCCESS",          $error_code++);
define("REGISTRO_ERROR",            $error_code++);
define("CONSULTAS_ERR_NOROWS",$error_code++);
$error_code=200;

define ("IBD_SUCCESS",              $error_code++);
define ("IBD_ERR_CANTCONNECT",      $error_code++);
define ("IBD_ERR_CANTSELECT",       $error_code++);
define ("IBD_ERR_DBUNAVAILABLE",    $error_code++);



$error_code = 200;

define("LOGIN_SUCCESS",             $error_code++);
define("LOGIN_BADLOGIN",            $error_code++);
define("LOGIN_DBFAILURE",           $error_code++);



$error_code=200;

define ("CONSULTAS_SUCCESS",        $error_code++);


define ("PATH_ADMIN",     "admin");
?>
