<?php
require_once('CssReport.php');
header('Content-type: application/json');
echo CssReport::getReport();
?>