<?php
require_once dirname(__FILE__) . '/../../../config/config.inc.php';
require_once dirname(__FILE__) . '/../../../init.php';

$blockcarousel_imagetype = Configuration::get('BLOCKCAROUSEL_IMAGETYPE');
$blockcarousel_visibleitems = Configuration::get('BLOCKCAROUSEL_ITEMSVIS');
$blockcarousel_movement = Configuration::get('BLOCKCAROUSEL_MOVEMENT');

header('Content-type: text/css; charset=utf-8;');

if ($blockcarousel_imagetype == 'medium') {
	echo '.blockcarousel { height: ' . ($blockcarousel_movement == 'vertical' ? ($blockcarousel_visibleitems * 99) : 99) . 'px }' . "\n";
}
elseif ($blockcarousel_imagetype == 'home') {
	echo '.blockcarousel { height: ' . ($blockcarousel_movement == 'vertical' ? ($blockcarousel_visibleitems * 169) : 169) . 'px }' . "\n";
}