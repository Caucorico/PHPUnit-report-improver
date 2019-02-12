<?php

class XmlConvertor
{
  /**
   * @var SimpleXMLElement
   */
  private $report;

  /**
   * @var resource
   */
  private $returnFile;

  public function getReport()
  {
    return $this->report;
  }

  public function setReport($report)
  {
    $this->report = $report;
    return $this;
  }

  public function initReturnFile($fileName='report-PHPUnit-report-improver.html')
  {
    $file = fopen($fileName, 'w');
    if ( $file === false ) return false;
    $this->returnFile = $file;
    return $this->returnFile;
  }

  public function closeReturnFile()
  {
    return fclose($this->returnFile);
  }

  public function makeHtmlTree( $element )
  {
    fwrite($this->returnFile, "<ul>" );

    foreach ($element->attributes() as $key => $value)
    {
      fwrite($this->returnFile, "<li> $key = $value </li>");
    }

    fwrite($this->returnFile, "<li>");
    foreach ( $element->children() as $child )
    {
      $this->makeHtmlTree( $child );
    }
    fwrite($this->returnFile, "</li>");

    fwrite($this->returnFile, "</ul>");
  }

  public function initReport( $xmlReportFileName )
  {
    $report = simplexml_load_file( $xmlReportFileName );
    if ( $report === false ) return false;
    $this->report = $report;
    return $this->report;
  }

  public function makeBetterReport( $xmlReportFileName, $htmlReportName )
  {
    $this->initReport($xmlReportFileName);
    $this->initReturnFile($htmlReportName);
    $this->makeHtmlTree($this->report);
    $this->closeReturnFile();
  }
}

?>