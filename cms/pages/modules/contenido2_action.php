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
		$nombre = @$_POST['nombre'];
		$id = @$_POST['id'];
		$return = "";
		if ($id != ""){
    	   $return = $dataServ->updateContenidos($desc1, $nombre, $id);
		}else{
		   $return = $dataServ->addContenidos($desc1, $nombre);
		}
    	echo json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados", "return"=>$return));		
	}
?>