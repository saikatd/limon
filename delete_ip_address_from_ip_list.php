<?php

$filename="backend/ip_list";
$ip_address=$_POST["content"];
$line_num=find_line_to_deleted($filename,$ip_address);
del_line_from_file($filename,$line_num);

function find_line_to_deleted($filename,$ip_address)
{
	$file_handler = fopen($filename, 'r');
	if ($file_handler)
	{
		$counter=0;
		while (($line=fgets($file_handler)) !== false)
		{
			$line=trim($line);
			$first_word = substr( $line, 0, strpos( $line, ' ' ) );
			if (strcmp($first_word,$ip_address) == 0)
			{
				return $counter;
			}
			$counter+=1;
		}	
	}
	else
	{
		echo "error in loading the file";
	}
}

function del_line_from_file($filename,$line_num)
{
	$arr=file($filename);

	//removing the line
	unset($arr[$line_num]);

	$fp = fopen($filename, 'w+');
	foreach($arr as $line) 
	{ 
		fwrite($fp,$line);
	}
	fclose($fp);
	
}

?>