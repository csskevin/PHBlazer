<?php

namespace PHBlazer\Utils;

use DevTheorem\Handlebars\Handlebars;
use DevTheorem\Handlebars\Options;
use PHBlazer\Data\File;
use PHBlazer\Data\FileList;
use PHBlazer\Data\ParsedFile;

class Generator {
  private $handlebarOptions;
  private $helpers = array();

  protected static ?Generator $instance = null;
  public static function getInstance(): Generator
  {
    if(!Generator::$instance) Generator::$instance = new Generator();
    return Generator::$instance;
  }
  
  function addHelper($name, $fn) {
    $this->helpers[$name] = $fn;
    $this->handlebarOptions = new Options(helpers: $this->helpers);
  }

  public function parseTemplate($content, $data = array()) {
    $template = Handlebars::compile($content, $this->handlebarOptions);
    return $template($data);
  }

  public function mapTemplateToContent(FileList $template, $contentData, $contentFile) {
    $list = $template->getArrayList(true, true);
    foreach($list as $key => $value) {
      $list[$key] = $this->parseTemplate(
        $value, 
        array("self" => $contentFile->getArray(), "content" => $contentData)
      );
    }
    return $list;
  }

  public function parseContentFiles() {
    $content = FileList::fromList(File::getFileList(DIR_CONTENT));
    $contentList = $content->getList();
    $contentData = $content->getArrayList();

    $template = FileList::fromList(File::getFileList(DIR_TEMPLATE));
    $template->filterExtension(array("html"));

    $parsedList = array();
    foreach($contentList as $contentFile) {
      $data = array(
        "content" => $contentData,
        "self" => $contentFile->getArray(),
        "template" => $this->mapTemplateToContent($template, $contentData, $contentFile)
      );

      $parsedContent = $this->parseTemplate($contentFile->getContent(), $data);
      $convertedContent = Converter::convertDocument($contentFile->getSource()->getExtension(), $parsedContent);
      $parsedList[] = new ParsedFile($contentFile, $convertedContent);
    }
    return $parsedList;
  }

  public function writeParsedFiles($parsedFiles) {
    foreach($parsedFiles as $parsedFile) {
      Security::checkPathTraversal(DIR_DIST, $parsedFile->getTargetPath()->getDirname());
      Security::checkPathTraversal(DIR_DIST, $parsedFile->getTargetPath()->getOriginal());
      @mkdir($parsedFile->getTargetPath()->getDirname(), 0777, true);
      file_put_contents($parsedFile->getTargetPath()->getOriginal(), $parsedFile->getParsedContent());
    }
  }

  public function clearDistFolder($dir = DIR_DIST) {
    foreach(glob($dir . "/*") as $file) {
      if(is_file($file)) {
        Security::checkPathTraversal(DIR_DIST, $file);
        unlink($file);
      } 
      if(is_dir($file)) {
        $this->clearDistFolder($file);
        rmdir($file);
      }
    }
  }

  public function prepareDistFolder($dir = DIR_PUBLIC) {
    foreach(glob($dir . "/*") as $file) {
      $target_file = str_replace(DIR_PUBLIC, DIR_DIST, $file);
      Security::checkPathTraversal(DIR_PUBLIC, $file);
      Security::checkPathTraversal(DIR_DIST, $target_file);
      if(is_file($file)) copy($file, $target_file);
      if(is_dir($file)) {
        @mkdir($target_file);
        $this->prepareDistFolder($file);
      }
    }
  }
}

