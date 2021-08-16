<?php
	session_start();
	// security check, not annonymous allowed in here.
	if (!isset($_SESSION["uid"])){
		header("Location: login.html?error=2");
	}
	include("../../webservices/connClass.php");
	include ("../../webservices/dataService.php");
	
	if ($_POST){
		$dataServ = null;
		$dataServ = new dataService();
		$vuelo = @$_POST['vuelo'];
		$salida = @$_POST['salida'];		
		$destino = @$_POST['destino'];
		$llegada = @$_POST['llegada'];
		$frecuencia = @$_POST['frecuencia'];		
		$tipo = @$_POST['tipo'];		
		$orden = @$_POST['orden'];
		$activo = @$_POST['activo'];
		$id = @$_POST['id'];
		if ($id == ""){
			$dataServ->savevuelos($vuelo, $salida, $destino, $llegada, $frecuencia, $tipo, $orden, $activo);
		}else{
			$dataServ->updatevuelos($vuelo, $salida, $destino, $llegada, $frecuencia, $tipo, $orden, $activo, $id);	        
		}
		echo json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));		
	}
?>