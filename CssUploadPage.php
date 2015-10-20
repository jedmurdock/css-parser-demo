<?php
/**
 * Basic Page Load Class for CSS Parser Demo
 *
 * Given more time I'd not rely on the uploaded file name, or do something to prevent
 * duplicates, and allow more than one result set to be saved.
 *
 * - jed
 */
class CssUploadPage
{
  protected $errors = array();
  protected $uploadDir = "upload";
  protected $resultsFile = "results.json";
  protected $tmpFile = "";
  protected $filepath = "";
  protected $fileInfo;

  public function __construct()
  {
    // this space intentionally left blank
  }

  /**
   * load the page - upload and process file if submitted
   *
   * $_FILES should be present in form submit before calling
   *
   * @return bool - successful upload and parse
   */
  public function load()
  {
    if (!$this->upload())
    {
      return false;
    }
    if (!$this->parse())
    {
      return false;
    }
    if (!$this->finish())
    {
      return false;
    }

    return true;
  }

  /**
   * handles the file upload
   *
   * @return bool - successful upload
   */
  public function upload()
  {
    if (!ini_get('file_uploads'))
    {
      $this->error("Server setting forbids file uploads");
      return false;
    }
    if (empty($_FILES['uploadFile']))
    {
      $this->error("No file uploaded");
      return false;
    }

    $this->fileInfo = $_FILES['uploadFile'];
    //print_r($this->fileInfo);

    if ($this->fileInfo['error'] != UPLOAD_ERR_OK)
    {
      if ($this->fileInfo['error'] == UPLOAD_ERR_INI_SIZE)
      {
        $this->error("File too big");
        return false;
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_FORM_SIZE)
      {
        $this->error("File too big");
        return false;
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_PARTIAL)
      {
        $this->error("Incomplete file upload");
        return false;
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_NO_FILE)
      {
        $this->error("No file selected or uploaded");
        return false;
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_NO_TMP_DIR)
      {
        $this->error("SYSTEM: Missing upload temp directory");
        return false;
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_CANT_WRITE)
      {
        $this->error("SYSTEM: Can't write to upload directory");
        return false;
      }
      elseif ($this->fileInfo['error'] == UPLOAD_ERR_EXTENSION)
      {
        $this->error("SYSTEM: Stopped by PHP extension");
        return false;
      }
    }

    if ($this->fileInfo['type'] != 'text/css'){
      $this->error("Plain vanilla CSS files only please");
      return false;
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
      $this->error("SYSTEM: Temp file is not a legitimate uploaded file");
      return false;
    }

    if (!is_dir($this->uploadDir))
    {
      $this->error("SYSTEM: Can't find upload dir");
      return false;
    }

    return true;
  }

  /**
   * handle the file parsing from css into json
   *
   * @return bool - successful parse
   */
  public function parse()
  {
    // would probably do this line by line instead of all at once for better memory perf
    $contents = file($this->tmpFile, FILE_IGNORE_NEW_LINES & FILE_SKIP_EMPTY_LINES);

    $json = array();

    foreach ($contents as $line)
    {
      print "  $line<br/>";

    }
    return true;
  }

  /**
   * save copy of input file, any other final tasks
   *
   * @return bool - successful finish
   */
  public function finish()
  {
    $this->filepath = $this->uploadDir . DIRECTORY_SEPARATOR . $this->fileInfo['name'];

    if (!move_uploaded_file($this->tmpFile, $this->filepath))
    {
      $this->error("SYSTEM: Unable to move temp file to upload dir");
      return false;
    }

    return true;
  }


  public function error($msg)
  {
    $this->errors []= $msg;
  }

  public function isValid()
  {
    return sizeof($this->errors) === 0;
  }

  public function getErrors()
  {
    return $this->errors;
  }
}