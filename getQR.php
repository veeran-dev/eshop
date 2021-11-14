<?php 
	header("Content-Type: image/png");
    include('classes/phpqrcode/qrlib.php'); 
    $var = isset($_GET['QRcode'])?$_GET['QRcode'] : 123;
    QRcode::png($var);
?>