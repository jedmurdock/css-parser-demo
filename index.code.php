<?php
require_once('CssUploader.php');
require_once('CssParser.php');
require_once('CssReport.php');

$errorMsg = $successMsg = "";

// file upload
if (!empty($_FILES['uploadFile']))
{
  try
  {
    $uploader = new CssUploader();
    $parser = new CssParser( ['uploadPath' => $uploader->getFilePath()] );
    $report = new CssReport( ['parsedData' => $parser->getParsedData()] );

    $successMsg = "File successfully uploaded and parsed";
  }
  catch (Exception $ex)
  {
    $errorMsg = $ex->getMessage(); // in real life i wouldn't do this!
  }
}

