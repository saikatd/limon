<?php
function get_ips()
{
	$file_handler = fopen('test.txt', 'r');
	if ($file_handler)
	{
		while (($line=fgets($file_handler)) !== false)
		{
			$line=trim($line);
			$first_word = substr( $line, 0, strpos( $line, ' ' ) );
			print_r( $first_word . "\n"); // will print Test
		}	
	}
	else
	{
		echo "error in loading the file";
	}
}

get_ips();