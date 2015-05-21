<?php
$myfile = fopen("test.txt", "w") or die("Unable to open file!");
$txt = "172.21.207.134";
fwrite($myfile, $txt);
$txt = "  root   ubuntu\n";
fwrite($myfile, $txt);
fclose($myfile);
?>