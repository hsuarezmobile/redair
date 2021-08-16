<?php
	// ****************************************
	// proyect: cms mobile
	// version: 1.0a
	// date: 19-01-2019
	// module: close active user session
	// author: Humberto Suarez
	// ****************************************
	session_start();
	session_unset(); 
	session_destroy();
	header("Location: login.html");
?>