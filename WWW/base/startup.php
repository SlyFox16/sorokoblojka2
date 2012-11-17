<?php
	require_once ("config.php");
	
	function startup() {	
		$connection = mysql_connect(DB_HOST, DB_USER, DB_PASS);
				
		if (!$connection)
		{
			die("Database connection failed ".mysql_error());
		}
		else
		{
			$db_select = mysql_select_db (DB_NAME, $connection);
			if (!$db_select)
			{
				die("Database selection failed ".mysql_error());
			}
		}
		mysql_query("set names utf8") or die("set names utf8 failed");	
		session_start();
	}
startup();