<?php
include("../../webservices/connClass.php");
include ("../../webservices/dataService.php");
$dataServ = null;
$dataServ = new dataService();
if ($_GET){
	$surname = $_GET["surname"];
	$lastname = $_GET["lastname"];
	$username = $_GET["username"];
	$pwd = $_GET["pwd"];
	$perfil = $_GET["perfil"];
	$status = $_GET["status"];
	$id = $_GET["id"];
	$json_data = array();
	echo $dataServ->updateUser($id, $surname, $lastname, $username, $pwd, $perfil, $status);
}
?>	