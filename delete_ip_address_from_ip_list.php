<?php

$filename="backend/ip_list";
$line_num=2;
del_line_from_file($filename,$line_num);

function del_line_from_file($filename,$line_num)
{
	$arr=file($filename);
	print_r($arr);
}

?>