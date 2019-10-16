<?php
session_start();
// session_unset(login);
unset ($_SESSION["login"]);
header("refresh:0;url=".$_SERVER['HTTP_REFERER']);
?>