<?php

namespace PHBlazer\Utils;

use PHBlazer\Interfaces\Converter as InterfacesConverter;

class Converter {
  protected static $converters = [];

  public static function registerConverter($srcExtensions, $dstExtension, InterfacesConverter $converterInstance) {
    foreach($srcExtensions as $srcExtension) {
      if(!array_key_exists($srcExtension, Converter::$converters))
        Converter::$converters[$srcExtension] = array();

      Converter::$converters[$srcExtension][] = array(
        "dstExtension" => $dstExtension,
        "instance" => $converterInstance
      ); 
    }
  }

  public static function convertDocument($extension, $content) {
    if(!array_key_exists($extension, Converter::$converters)) return new ConverterResult($extension, $content);
    $convertedContent = $content;
    foreach(Converter::$converters[$extension] as $converter) {
      $convertedContent = $converter["instance"]->parse($convertedContent);
    }
    return new ConverterResult($converter["dstExtension"], $convertedContent);
  }
}

class ConverterResult {
  public function __construct(private $extension, private $content) {}

  public function getExtension() {
    return $this->extension;
  }

  public function getContent() {
    return $this->content;
  }
}
