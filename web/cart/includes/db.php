<?php
	@mysql_connect("localhost","neeraywf_shoppin","shoppin") or die("Demo is not available, please try again later");
	@mysql_select_db("neeraywf_shopping") or die("Demo is not available, please try again later");
	session_start();
?>