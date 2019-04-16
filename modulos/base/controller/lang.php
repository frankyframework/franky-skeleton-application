<?php
$callback = $MyRequest->getRequest("callback");
$lang = $MyRequest->getRequest("lang");
$MyRequest->redirect($callback,'301');
?>