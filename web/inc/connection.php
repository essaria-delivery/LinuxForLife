<?php		
  error_reporting(0);
	$hostname_conn = "localhost";	
    $username_conn = "u602795421_ndemo";
    $password_conn = "QLAZ^aQ^*k@8";
    $database_conn = "u602795421_ndemo";
	$conn = mysqli_connect($hostname_conn, $username_conn, $password_conn ,$database_conn) or die ("<p align=center><font color=red>Connection can not established!!!</font></p>" . mysqli_error());
	//$db_selected = mysqli_select_db($database_conn, $conn) or die ("<p align=center><font color=red>Database not found!!</font></p>" . mysqli_error());
	//session_start();
	
	$base_url='https://thecodecafe.in/multi_vender/';
	?>