<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_best = "localhost";
$database_best = "bestnid";
$username_best = "root";
$password_best = "";
$best = mysql_pconnect($hostname_best, $username_best, $password_best) or trigger_error(mysql_error(),E_USER_ERROR); 
?>