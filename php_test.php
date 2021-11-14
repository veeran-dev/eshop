<!DOCTYPE html>
<html>
<body>

<?php
$string = "<tr style='background-color:7'><td style='text-align:center;'>1</td><td> #IN005499<br/><span style='color:#777;'>billed on</span>13-12-2017</td><td style='text-align:center;'>Unpaid</td><td style='text-align:center;'>12-20-2017</td><td style='text-align:right;'>537.6</td></tr><tr style='background-color:2'><td style='text-align:center;'>2</td><td> #IN005498<br/><span style='color:#777;'>billed on</span>13-12-2017</td><td style='text-align:center;'>Unpaid</td><td style='text-align:center;'>12-15-2017</td><td style='text-align:right;'>537.6</td></tr><tr style='background-color:0'><td style='text-align:center;'>3</td><td> #IN005497<br/><span style='color:#777;'>billed on</span>13-12-2017</td><td style='text-align:center;'>Unpaid</td><td style='text-align:center;'>12-13-2017</td><td style='text-align:right;'>537.6</td></tr><tr style='background-color:-9'><td style='text-align:center;'>4</td><td> #IN005501<br/><span style='color:#777;'>billed on</span>15-11-2017</td><td style='text-align:center;'>Unpaid</td><td style='text-align:center;'>12-04-2017</td><td style='text-align:right;'>537.6</td></tr><tr style='background-color:0'><td style='text-align:center;'>5</td><td> #IN005500<br/><span style='color:#777;'>billed on</span>18-11-2017</td><td style='text-align:center;'>Unpaid</td><td style='text-align:center;'>12-13-2017</td><td style='text-align:right;'>537.6</td></tr><tr style='background-color:0'><td style='text-align:center;'>6</td><td> #IN005493<br/><span style='color:#777;'>billed on</span>18-11-2017</td><td style='text-align:center;'>Unpaid</td><td style='text-align:center;'>12-13-2017</td><td style='text-align:right;'>537.6</td></tr>";

$thoondil = "background-color:7";
$change = "background-color:red;color:white;";
echo str_replace("world","Peter","Hello world! Hello world! Hello world! Hello world! Hello world! ");
$new = str_replace($thoondil, $change, $string);
var_dump($new);
?>

<p>In this example, we search for the string "Hello World!", find the value "world" and then replace the value with "Peter".</p>

</body>
</html>