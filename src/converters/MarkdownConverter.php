<?php

use PHBlazer\Interfaces\Converter as InterfacesConverter;
use PHBlazer\Utils\Converter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter as MdConverter;
use Phiki\CommonMark\PhikiExtension;
use Phiki\Theme\Theme;

class MarkdownConverter implements InterfacesConverter {
  private $markdown;
  function __construct()
  {
    $environment = new Environment();
    $environment->addExtension(new CommonMarkCoreExtension());
    $environment->addExtension(new PhikiExtension(Theme::GithubLight));
    $this->markdown = new MdConverter($environment);
  }

  public function parse($content) {
    return $this->markdown->convert($content);
  }
}

Converter::registerConverter(array("md"), "html", new MarkdownConverter());

?>
