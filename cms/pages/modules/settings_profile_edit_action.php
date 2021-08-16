<?php
include("../../webservices/connClass.php");
include ("../../webservices/dataService.php");
$dataServ = null;
$dataServ = new dataService();
if ($_GET){
	$nombre = $_GET["nombre"];
	$permisos = $_GET["permisos"];
	$activo = $_GET["activo"];
	$id = $_GET["id"];
	$json_data = array();
	echo $dataServ->updateProfile($id, $nombre, $permisos, $activo);
}
?>	