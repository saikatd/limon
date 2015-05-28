

<?php
     
	$ip_address = $_POST["content"];

	$text ="\n".$ip_address;

	file_put_contents("backend/ip_list", $text, FILE_APPEND);

	
	
?>


