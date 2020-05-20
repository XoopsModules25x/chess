<?php

error_reporting(E_ALL);

#define('FILENAME', 'http://home.earthlink.net/~dave_lerner/tmp/me_small.jpg');
define('FILENAME', 'test.gif');

$get_imagesize_result = getimagesize(FILENAME);
var_dump('get_imagesize_result', $get_imagesize_result);

?>

