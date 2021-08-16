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
		$tipo = @$_POST['tipo'];
		$peso = @$_POST['peso'];
		$monto = @$_POST['monto'];
		$misc = @$_POST['misc'];
		$con = @$_POST['con'];
		$activo = @$_POST['activo'];
		$orden = @$_POST['orden'];
		$id = @$_POST['id'];
		if ($id == ""){
			$dataServ->saveServiciosCarga($tipo, $peso, $monto, $misc, $con, $orden, $activo);
		}else{
			$dataServ->updateServiciosCarga($tipo, $peso, $monto, $misc, $con, $orden, $activo, $id);	        
		}
		echo json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));		
	}
?>