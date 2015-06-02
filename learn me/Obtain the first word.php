<?php
function get_ips()
{
	$file_handler = fopen('test.txt', 'r');
	$array_ips=array();
	if ($file_handler)
	{
		while (($line=fgets($file_handler)) !== false)
		{
			$line=trim($line);
			$first_word = substr( $line, 0, strpos( $line, ' ' ) );
			
			array_push($array_ips,$first_word);
		}
		echo json_encode($array_ips);	
	}
	else
	{
		echo "error in loading the file";
	}
}

get_ips();