<?php 
$config['sql_host']       = 'localhost';
$config['sql_username']   = 'root';			// Database Username
$config['sql_password']   = '';			// Database Password
$config['sql_database']   = 'db';				// The database
$config['sql_extenstion'] = (version_compare(phpversion(), '5.5', '<') ? 'MySQL' : 'MySQLi');			// MySQL or MySQLi
$config['secure_url'] = "https://myproject.local/";

?>
