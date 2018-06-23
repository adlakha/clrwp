<?php

	$file_url = $_REQUEST['src']; //echo 'url='.$file_url;
    $allowed_file_type = array("mp4","wam","rar","pdf","php","png","jpg","jpeg","txt","zip");

	//************* getting filename
	$reverse_url = strrev($file_url);//echo '<br/>rev url='.$reverse_url;
	//get file extenstion
	
	$extenstion_arr     = explode('.',$reverse_url); //echo '<br/>';print_r($extenstion_arr);
	$extenstion    = strrev($extenstion_arr[0]);
	
	if(in_array($extenstion,$allowed_file_type)){
	 
	$filename    = explode('/',$reverse_url); //print_r($reverse_url);
	$file_name   = strrev($filename[0]);
	 
	//************* getting filenameend	
	
	
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"From Corporatelawreporter.com, Filename : ".$file_name."\""); 
	readfile($file_url);
	exit;
	
		
	}else{
		echo 'Filename extension is not good';
	}
	
?>