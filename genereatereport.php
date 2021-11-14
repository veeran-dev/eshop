<?php 
include(dirname(__FILE__).'/config/config.inc.php');
include(dirname(__FILE__).'/init.php');
$cookie = new Cookie('ps');
header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=test.pdf");
        //header("Content-Length: ".filesize($this->file));
		ob_end_clean();