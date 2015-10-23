<?php
/**
 * Basic File Upload Class for CSS Parser Demo
 *
 * Given more time I'd not rely on the uploaded file name, or do something to prevent
 * duplicates, and allow more than one result set to be saved.
 *
 *
 * - jed
 */
class CssUploader
{
  // uploader
  protected $uploadDir = "upload";
  protected $resultsDir = "results";
  protected $resultsFile = "results.json";
  protected $tmpFile;
  protected $filepath;
  protected $fileInfo;
  protected $parser;

  public function __construct()
  {
    $this->upload();
  }

  /**
   * handles the file upload
   *
   * @throws Exception
   */
  public function upload()
  {
    if (!ini_get('file_uploads'))
    {
      throw new Exception("Server setting forbids file uploads");
    }
    if (empty($_FILES['uploadFile']))
    {
      throw new Exception("No file uploaded");
    }

    $this->fileInfo = $_FILES['uploadFile'];

    if ($this->fileInfo['error'] != UPLOAD_ERR_OK)
    {
      if ($this->fileInfo['error'] == UPLOAD_ERR_INI_SIZE)
      {
        throw new Exception("File too big");
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_FORM_SIZE)
      {
        throw new Exception("File too big");
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_PARTIAL)
      {
        throw new Exception("Incomplete file upload");
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_NO_FILE)
      {
        throw new Exception("No file selected or uploaded");
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_NO_TMP_DIR)
      {
        throw new Exception("SYSTEM: Missing upload temp directory");
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_CANT_WRITE)
      {
        throw new Exception("SYSTEM: Can't write to upload directory");
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_EXTENSION)
      {
        throw new Exception("SYSTEM: Stopped by PHP extension");
      }
    }

    if ($this->fileInfo['type'] != 'text/css'){
      throw new Exception("Plain vanilla CSS files only please");
    }

    $this->tmpFile = $this->fileInfo['tmp_name'];

    // would need to spend some time to get this nailed down. returing text/x-c++ on sample css files I've tried
    /*
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    echo "<br/>MIME: " . finfo_file($finfo, $tmpFile);
    finfo_close($finfo);
    */

    if (!is_uploaded_file($this->tmpFile))
    {
      throw new Exception("SYSTEM: Temp file is not a legitimate uploaded file");
    }

    if (!is_dir($this->uploadDir))
    {
      throw new Exception("SYSTEM: Can't find upload dir");
    }

    // save uploaded file
    $this->filepath = $this->uploadDir . DIRECTORY_SEPARATOR . $this->fileInfo['name'];

    if (!move_uploaded_file($this->tmpFile, $this->filepath))
    {
      throw new Exception("SYSTEM: Unable to move temp file to upload dir");
    }
  }

  public function getFilePath()
  {
    return $this->filepath;
  }
}