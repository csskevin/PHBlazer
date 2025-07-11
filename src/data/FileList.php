<?php

namespace PHBlazer\Data;

class FileList {
  /** @var SiteFile[] **/
  private $filelist;

  public function __construct($filelist) {
   $this->filelist = $filelist;
  }

  public function filterExtension($extensions = array()) {
    $this->filelist = array_filter($this->filelist, function($entry) use($extensions) {
      return in_array($entry->getSource()->getExtension(), $extensions);
    });
  }

  public function getList($clone = false) {
    if($clone) return $this->filelist;
    return $this->filelist;
  }

  public function getArrayList($clone = false, $contentOnly = false) {
    $list = $this->getList($clone);    
    $kvPair = array();
    foreach($list as $item) {
      $kvPair[$item->getSource()->getKey()] = $contentOnly ? $item->getContent() : $item->getArray();
    }
    return $kvPair;
  }

  public static function fromList($list) {
    return new FileList($list);
  }
}


