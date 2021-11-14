<?php
require_once dirname(__FILE__) . '/../../../config/config.inc.php';
require_once dirname(__FILE__) . '/../../../init.php';

$blockmanufacturer_visibleitems = Configuration::get('MANUFACTURER_ITEMSVIS');
$blockmanufacturer_movement = Configuration::get('MANUFACTURER_MOVEMENT');

header('Content-type: text/css; charset=utf-8;');

echo '.manufacturerslide { height: ' . ($blockmanufacturer_movement == 'vertical' ? ($blockmanufacturer_visibleitems * 99) : 99) . 'px }' . "\n";