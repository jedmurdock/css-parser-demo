<?php
/**
 * CssParser
 *
 * this isn't a real parser, just generates some stats based on a couple of regexes
 * and creates a 'result.json' file
 *
 */
class CssParser
{
  protected $parsedData = array();
  protected $uploadPath;

  public function __construct(array $params)
  {
    if (!isset($params['uploadPath']))
    {
      throw new Exception("'uploadPath' is a required parameter");
    }
    $this->uploadPath = $params['uploadPath'];

    $this->parse();
  }

  /**
   * handle the file parsing from css into json
   *
   * @throws Exception
   */
  public function parse()
  {
    $contents = file_get_contents($this->uploadPath);
    if ($contents === false)
    {
      throw new Exception("SYSTEM: Can't read temp file");
    }

    $comments = array();
    $css = array();
    $fontFamilies = array();
    $colors = array();

    // store and remove comments - found this regex on official CSS 2.1 spec page
    preg_match_all('|\/\*[^*]*\*+([^/*][^*]*\*+)*\/|',$contents, $comments, PREG_SET_ORDER);
    $contents = preg_replace('|\/\*[^*]*\*+([^/*][^*]*\*+)*\/|','',$contents);

    // strip newlines
    $contents = preg_replace('/\n/','',$contents);

    // can't take credit for this regex, found on stackexchange
    preg_match_all('/([^{]+)\s*\{\s*([^}]+)\s*}/',$contents, $css, PREG_SET_ORDER);

    // also can't take credit for this regex
    preg_match_all('/font-family\s*?:.*?(;|(?=""|\'|;))/',$contents, $fontFamilies, PREG_SET_ORDER);

    // a couple more random data points
    preg_match_all('/color\s*?:.*?(;|(?=""|\'|;))/',$contents, $colors, PREG_SET_ORDER);


    $this->parsedData['comments'] = $comments;
    $this->parsedData['css'] = $css;
    $this->parsedData['font_families'] = $fontFamilies;
    $this->parsedData['colors'] = $colors;

  }

  public function getParsedData()
  {
    return $this->parsedData;
  }


}