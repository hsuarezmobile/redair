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
		$nombre = @$_POST['surname'];
		$fecha = @$_POST['fecha'];
		$titulo = @$_POST['titulo'];
		$description = @$_POST['description'];
		$activo = @$_POST['activo'];
		$orden = @$_POST['orden'];
		$id = @$_POST['id'];
		function subir_archivo($campo_archivo, $ruta_archivo, $extension, $cod){ 
			$nombre_archivo_temp=$cod.".".$extension;   
			if(is_uploaded_file($_FILES[$campo_archivo]['tmp_name'])){
					copy($_FILES[$campo_archivo]['tmp_name'], $ruta_archivo.$nombre_archivo_temp);
			}
			return $nombre_archivo_temp;			
		} 
		$archivo = "";
		if (isset($_FILES['archivo']['name'])){
			$archivo = @$_FILES['archivo']['name'];
			$tamano = @$_FILES['archivo']['size'];
			$ext = strtolower(substr($archivo, strlen($archivo)-3, 3));
			$name = substr($archivo,0, strlen($archivo)-4);
			$nombre_archivo = md5($archivo);
			$name_arch = $nombre_archivo.".jpg";							
		}		
		if ($archivo != ""){
			if($tamano < 5024000){		
				if (file_exists("../../../assets/img/slides/".$name_arch)){ // -> si existe el archivo te lo vuelas
					@unlink("../../../assets/img/slides/".$name_arch);
				}
				$el_archivo = subir_archivo("archivo", "../../../assets/img/slides/", "jpg", $nombre_archivo);
				if ($id == ""){
					$dataServ->saveVitrina($nombre, $orden, $el_archivo, $activo);
				}else{
					$dataServ->updateVitrina($nombre, $orden, $el_archivo, $activo, $id);	        
				}
			}
		}else{
			if ($id == ""){
				$dataServ->saveVitrina($nombre, $orden, "", $activo);
			}else{
				$dataServ->updateVitrina($nombre, $orden, "", $activo, $id);
			}
		}		
		echo json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));		
	}
?>