<?php

namespace PHBlazer\Utils;

// NOTE: This only supports linux by now
class Logger {
  public static function error($message, $bold=false) {
    $boldval = $bold === true ? '1' : '0';
    echo "\e[$boldval;31m[+] $message\e[0m" . PHP_EOL;
  }

  public static function success($message, $bold=false) {
    $boldval = $bold === true ? '1' : '0';
    echo "\e[$boldval;32m[+] $message\e[0m" . PHP_EOL;
  }

  public static function warning($message, $bold=false) {
    $boldval = $bold === true ? '1' : '0';
    echo "\e[$boldval;33m[+] $message\e[0m" . PHP_EOL;
  }

  public static function info($message, $bold=false) {
    $boldval = $bold === true ? '1' : '0';
    echo "\e[$boldval;34m[+] $message\e[0m" . PHP_EOL;
  }

  public static function text($message, $bold=false) {
    $boldval = $bold === true ? '1' : '0';
    echo "\e[;".$boldval."1m[+] $message\e[0m" . PHP_EOL;
  }
}
