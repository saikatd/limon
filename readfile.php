<?php

$ip_address = $_POST["ip_address"];
$uname = $_POST["uname"];
$password = $_POST["password"];

$text=$ip_address ." " .$uname ." " .$password;
echo $text;

//$myfile = fopen("test.txt", "w") or die("Unable to open file!");
//fwrite($myfile, $ip_address);
file_put_contents("test.txt", $text . PHP_EOL, FILE_APPEND);
//fclose($myfile);
?>