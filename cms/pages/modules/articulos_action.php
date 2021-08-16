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
		$desc1 = @$_POST['desc1'];
		$desc2 = @$_POST['desc2'];		
		$activo = @$_POST['activo'];
		$orden = @$_POST['orden'];
		$id = @$_POST['id'];
		if ($id == ""){
			$dataServ->saveArticuloNoIndemnizable($desc1, $desc2, $orden, $activo);
		}else{
			$dataServ->updateArticuloNoIndemnizable($desc1, $desc2, $orden, $activo, $id);	        
		}
		echo json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));		
	}
?>