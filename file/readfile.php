<?php
$myfile = fopen("test.txt", "w") or die("Unable to open file!");
$ip_address = $_POST["ip_address"];
$uname = $_POST["uname"];
$password = $_POST["password"];

echo $ip_address;

$txt = $ip_address + "  " + $uname + "  " + $password;
fwrite($myfile, $txt);
fclose($myfile);

$file = fopen("test.txt","r");

while(! feof($file))
  {
  echo fgets($file). "<br />";
  }

fclose($file);
?>