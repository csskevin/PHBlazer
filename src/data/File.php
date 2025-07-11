<?php

namespace PHBlazer\Data;

use PHBlazer\Utils\Security;

class File {
  private $source;
  public function __construct($source, private $content, private $metadata) {
    $this->source = FileInfo::fromFilename($source);
  }

  public function getContent() {
    return $this->content;
  }

  public function getMetadata() {
    return $this->metadata;
  }

  public function getSource() {
    return $this->source;
  }

  public function getArray() {
    return array(
      "content" => $this->content,
      "meta" => $this->metadata,
      "path" => $this->getSource()->getWebPath()
    );
  }

  public static function getFileList($dir, $recursive = true) {
    $filelist = [];
    Security::checkPathTraversal(APPPATH, $dir);
    foreach(glob($dir . "/*") as $file) {
      if(is_file($file)) $filelist[] = File::fromFile($file);
      if($recursive && is_dir($file)) $filelist = array_merge($filelist, File::getFileList($file));
    }
    return $filelist;
  }

  public static function fromFile($source) {
    Security::checkPathTraversal(APPPATH, $source);
    $content = file_get_contents($source);
    $headerRegex = '/^---([\s\S]*?)---/';
    preg_match($headerRegex, $content, $matches);
    if(count($matches) !== 2) return new File($source, $content, []);
    $content = str_replace($matches[0], '', $content);
    $metadata = array();
    foreach(explode("\n", $matches[1]) as $line) {
      if(str_starts_with(trim($line), "#")) continue;
      $kv = explode(":", $line);
      if(count($kv) <= 1) continue;
      $metadata[trim($kv[0])] = trim(implode(":", array_slice($kv, 1)));
    }
    return new File($source, $content, $metadata);
  }
}

