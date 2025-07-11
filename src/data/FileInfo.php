<?php

namespace PHBlazer\Data;

use PHBlazer\Utils\Security;

class FileInfo {

  public function __construct(private $dirname, private $basename, private $extension, private $filename, private $original) {
  }

  public function getKey() {
    $ctx = $this->getDirname();
    $ctx = str_replace(DIR_TEMPLATE, "", $ctx);
    $ctx = str_replace(DIR_CONTENT, "", $ctx);
    if(strlen($ctx) >= 1 && $ctx[0] === "/") $ctx = substr($ctx, 1);
    return $ctx . (strlen($ctx) > 0 ? "/" : "") . $this->getFilename();
  }

  public function getDirname() {
    return $this->dirname;
  }

  public function getBasename() {
    return $this->basename;
  }

  public function getExtension() {
    return $this->extension;
  }

  public function getFilename() {
    return $this->filename;
  }

  public function getOriginal() {
    return $this->original;
  }

  public function getWebPath() {
    $ctx = $this->getDirname();
    $ctx = str_replace(DIR_CONTENT. "/", "", $ctx);
    return $ctx;
  }

  public static function fromFilename($filename) {
    Security::checkPathTraversal(APPPATH, $filename);
    $info = pathinfo($filename);
    return new FileInfo($info["dirname"], $info["basename"], $info["extension"], $info["filename"], $filename);
  }
}

