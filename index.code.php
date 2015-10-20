<?php
require_once('CssUploadPage.php');

$errorMsg = $successMsg = "";

if (!empty($_FILES['uploadFile']))
{
  $page = new CssUploadPage();

  if ($page->load())
  {
    $successMsg = "File successfully uploaded and parsed";
  }
  elseif (!$page->isValid())
  {
    // I realize I'm stopping page load on any error so there will never be more
    // than one listed here, but maybe I'll change my mind
    foreach ($page->getErrors() as $error)
    {
      $errorMsg .= $error;
    }
  }
  else
  {
    throw new Exception("Barf");
  }
}
