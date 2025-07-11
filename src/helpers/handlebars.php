<?php

use PHBlazer\Utils\Generator;

$generator = Generator::getInstance();

$generator->addHelper("startswith", function($content, $match, $options) {
  if(!str_starts_with($content, $match)) return "";
  return $options->fn();
});

$generator->addHelper("readtime", function($content) {
  // Assuming a WPM of 200
  $estimatedWords = count(explode(" ", $content));
  $val = round($estimatedWords / 200 * 2) / 2;
  $suffix = "minutes";
  if($val === 1.0) $suffix = "minute";
  return strval($val) . " " . $suffix;
});

