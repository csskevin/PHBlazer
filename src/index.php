<?php

use PHBlazer\Utils\Security;

$start = microtime(true);

define("APPPATH", realpath(__DIR__ . "/.."));
define("DIR_CONTENT", APPPATH . "/content");
define("DIR_TEMPLATE", APPPATH . "/template");
define("DIR_DIST", APPPATH . "/dist");
define("DIR_PUBLIC", APPPATH . "/public");

include __DIR__ . "/autoload.php";

Security::checkPathTraversal(APPPATH, DIR_CONTENT);
Security::checkPathTraversal(APPPATH, DIR_TEMPLATE);
Security::checkPathTraversal(APPPATH, DIR_DIST);
Security::checkPathTraversal(APPPATH, DIR_PUBLIC);

use PHBlazer\Utils\Generator;
use PHBlazer\Utils\Logger;

$generator = Generator::getInstance();
$parsedFiles = $generator->parseContentFiles();
@mkdir(DIR_DIST);
$generator->clearDistFolder();
$generator->prepareDistFolder();
$generator->writeParsedFiles($parsedFiles);

$end = microtime(true);
$runtime = round($end - $start, 5);

Logger::success("Generated content in $runtime second(s)", true);

?>
