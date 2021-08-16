<?php
	// ****************************************
	// proyect: cms mobile
	// version: 1.0a
	// date: 19-01-2019
	// module: login validation
	// author: Humberto Suarez
	// ****************************************
	session_start();
	include("../webservices/connClass.php");
	include ("../webservices/dataService.php");
	$dataServ = null;
	$dataServ = new dataService();
	if ($_POST){
		$usuario = "";
		$password = "";
		$json_response = array();		
		$usuario = $_POST["usuario"];
		$password = $_POST["password"];		
		$json_response = json_decode($dataServ->doLogin($usuario, $password));		
		if ($json_response->result){
			$_SESSION["uid"] = $json_response->uid;
			header("Location: main.php");			
		}else{
			header("Location: login.html?error=1");
		}
	}	
?>