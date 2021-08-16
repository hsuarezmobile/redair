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
		$desc = @$_POST['desc'];
		$mia = @$_POST['mia'];
		$sdq = @$_POST['sdo'];
		$pty = @$_POST['pty'];
		$cur = @$_POST['cur'];
		$aua = @$_POST['aua'];
		$gye = @$_POST['gye'];
		$activo = @$_POST['activo'];
		$orden = @$_POST['orden'];
		$id = @$_POST['id'];
		if ($id == ""){
			$dataServ->saveTarifaEquipaje($desc, $mia, $sdq, $pty, $cur, $aua, $gye, $orden, $activo);
		}else{
			$dataServ->updateTarifaEquipaje($desc, $mia, $sdq, $pty, $cur, $aua, $gye, $orden, $activo, $id);	        
		}
		echo json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));		
	}
?>