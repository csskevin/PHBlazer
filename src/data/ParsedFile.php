<?php

namespace PHBlazer\Data;

use PHBlazer\Utils\ConverterResult;

class ParsedFile {
  /** @var SiteFile */
  private $file;
  /** @var ConverterResult */
  private $convertedDocument;

  public function __construct($file, $document){
    $this->file = $file;
    $this->convertedDocument = $document;
  }

  public function getParsedContent() {
    return $this->convertedDocument->getContent();
  }

  public function getTargetPath() {
    $source = $this->file->getSource();
    $targetPath = $source->getDirname() . "/" . $source->getFilename() . "." . $this->convertedDocument->getExtension();
    $targetPath = str_replace(DIR_CONTENT, "", $targetPath);
    return FileInfo::fromFilename(DIR_DIST . $targetPath);
  }
}
