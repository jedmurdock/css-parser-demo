<?php
/**
 * CssReport
 *
 *
 */
class CssReport
{
  protected $report = "";
  protected $parsedData;
  protected $reportData;
  const reportDir = "results";
  const reportFile = "report.json";

  function __construct(array $params)
  {
    if (!isset($params['parsedData']))
    {
      throw new Exception("'parsedData' is a required parameter");
    }
    $this->parsedData = $params['parsedData'];

    $this->makeReport();
    $this->saveReport();
  }
  /**
   * generate report
   *
   * in PHP 7 we'll no longer have to do this 'isset' business
   * thanks to the new null coalese operator '??'
   *
   * @throws Exception
   */
  public function makeReport()
  {
    $this->reportData['summary']['num_comments']
      = isset($this->parsedData['comments']) ? count ( $this->parsedData['comments'] ) : 0;

    $this->reportData['summary']['num_selectors']
      = isset($this->parsedData['css']) ? count ( $this->parsedData['css'] ) : 0;

    $this->reportData['summary']['num_font_families']
      = isset($this->parsedData['font_families']) ? count ( $this->parsedData['font_families'] ) : 0;

    $this->reportData['summary']['num_colors']
      = isset($this->parsedData['colors']) ? count( $this->parsedData['colors'] ) : 0;
  }

  /**
   * save report to json file
   *
   * @throws Exception
   */
  public function saveReport()
  {
    if (!is_dir(self::reportDir))
    {
      throw new Exception("SYSTEM: Can't find results dir");
    }

    if ( file_put_contents($this->getReportFilePath(), json_encode(['status'=>'success','data'=>$this->reportData],JSON_FORCE_OBJECT)) === false)
    {
      throw new Exception("SYSTEM: Can't save results file");
    }
  }

  /**
   * retrieve report file
   *
   * @return string - json formatted report data
   */
  public static function getReport()
  {
    if (!is_readable(self::getReportFilePath()))
    {
      return json_encode(['status' => 'unavailable']);
    }
    return file_get_contents(self::getReportFilePath());
  }
  /**
   * @return string
   */
  public static function getReportFilePath()
  {
    return self::reportDir . DIRECTORY_SEPARATOR . self::reportFile;
  }
}