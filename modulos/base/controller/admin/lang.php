<?php
$callback = $MyRequest->getReferer();
$_SESSION["lang_admin"] = $MyRequest->getRequest("lang_admin");
$MyRequest->redirect($callback,'301');
?>