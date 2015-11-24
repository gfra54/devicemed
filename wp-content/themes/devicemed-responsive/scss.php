<?php
require_once 'vendors/scssphp/scss.inc.php';
$scss = new scssc();
$scss->setFormatter('scss_formatter');
$scss->setImportPaths('css');
$server = new scss_server('css', null, $scss);
$server->serve();