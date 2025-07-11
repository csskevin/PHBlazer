<?php

namespace PHBlazer\Utils;
use PHBlazer\Utils\Logger;

class Security {
  public static function checkPathTraversal($root, $path) {
    $target_path = $path;
    if(is_file($path) || is_dir($path)) $target_path = realpath($target_path);
    if(str_starts_with($target_path, realpath($root))) return;
    if($target_path === $path)
      Security::fail("Path traversal detected! $path not in $root");
    else
      Security::fail("Path traversal detected! ".$path." -> ".$target_path." not in $root");
  }

  protected static function fail($message) {
    Logger::error($message);
    die();
  }
}
