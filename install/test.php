<?php

          $db_host = 'host_test';
          $db_user = 'user_test';
          $db_pass = 'pass_test';
          $db_name = 'name_test';
          /*Let's import the sql file into the given database*/

$myfile = fopen("../application/config/database.php", "w") or die("Unable to open file!");
$txt = "";
fwrite($myfile, $txt);
$txt = '<?php

defined("BASEPATH") OR exit("No direct script access allowed");

$active_group = "default";
$query_builder = TRUE;

$db["default"] = array(
  "dsn" => "",
  "hostname" => "'.$db_host.'",
  "username" => "'.$db_user.'",
  "password" => "'.$db_pass.'",
  "database" => "'.$db_name.'",
  "dbdriver" => "mysqli",
  "dbprefix" => "",
  "pconnect" => FALSE,
  "db_debug" => (ENVIRONMENT !== "production"),
  "cache_on" => FALSE,
  "cachedir" => "",
  "char_set" => "utf8",
  "dbcollat" => "utf8_general_ci",
  "swap_pre" => "",
  "encrypt" => FALSE,
  "compress" => FALSE,
  "stricton" => FALSE,
  "failover" => array(),
  "save_queries" => TRUE
);

';

fwrite($myfile, $txt);
fclose($myfile);

$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
        $config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
        $config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
        $base = $config['base_url'];
        $base = str_replace("/install/","/",$base);

file_put_contents("../application/config/config.php",'
  
$config["base_url"] = "'.$base.'";', FILE_APPEND | LOCK_EX);


?>