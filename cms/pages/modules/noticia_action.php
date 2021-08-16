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
		$titulo = @$_POST['titulo'];
		$fecha = @$_POST['fecha'];
		$description = str_replace("'", "", strip_tags($_POST['description'], "<b>&nbsp;<p><strong><font><img>"));
		$activo = @$_POST['activo'];
		$id = @$_POST['id'];
		function subir_archivo($campo_archivo, $ruta_archivo, $extension, $cod){ 
			$nombre_archivo_temp=$cod.".".$extension;   
			if(is_uploaded_file($_FILES[$campo_archivo]['tmp_name'])){
					copy($_FILES[$campo_archivo]['tmp_name'], $ruta_archivo.$nombre_archivo_temp);
			}
			return $nombre_archivo_temp;			
		} 
		$archivo = "";
		$archivo2 = "";
		if (isset($_FILES['archivo']['name'])){
			$archivo = @$_FILES['archivo']['name'];
			$tamano = @$_FILES['archivo']['size'];
			$ext = strtolower(substr($archivo, strlen($archivo)-3, 3));
			$name = substr($archivo,0, strlen($archivo)-4);
			$nombre_archivo = md5($archivo);
			$name_arch = $nombre_archivo.".jpg";							
		}
		if (isset($_FILES['archivo2']['name'])){
		    $archivo2 = @$_FILES['archivo2']['name'];
		    $tamano2 = @$_FILES['archivo2']['size'];
		    $ext2 = strtolower(substr($archivo2, strlen($archivo2)-3, 3));
		    $name2 = substr($archivo2,0, strlen($archivo2)-4);
		    $nombre_archivo2 = md5($archivo2);
		    $name_arch2 = $nombre_archivo2.".jpg";
		}		
		if ($archivo != ""){
			if($tamano < 5024000){		
				if (file_exists("../../../assets/img/noticias/".$name_arch)){ // -> si existe el archivo te lo vuelas
					@unlink("../../../assets/img/noticias/".$name_arch);
				}
				$el_archivo = subir_archivo("archivo", "../../../assets/img/noticias/", "jpg", $nombre_archivo);
			}
		}
		if ($archivo2 != ""){
		    if($tamano2 < 5024000){
		        if (file_exists("../../../assets/img/noticias/".$name_arch2)){ // -> si existe el archivo te lo vuelas
		            @unlink("../../../assets/img/noticias/".$name_arch2);
		        }
		        $el_archivo2 = subir_archivo("archivo2", "../../../assets/img/noticias/", "jpg", $nombre_archivo2);
		    }
		}	
		$response = array();
		if ($el_archivo != "" && $el_archivo2 != ""){
		    if ($id == ""){
		        $response = $dataServ->saveNew($titulo, $description, $el_archivo, $el_archivo2, $fecha, $activo);
		    }else{
	  	        $response = $dataServ->updateNew($titulo, $description, $el_archivo, $el_archivo2, $fecha, $activo, $id);
		    }		    
		}else if ($el_archivo != "" && $el_archivo2 == ""){
		    if ($id == ""){
		        $response = $dataServ->saveNew($titulo, $description, $el_archivo, "", $fecha, $activo);
		    }else{
		        $response = $dataServ->updateNew($titulo, $description, $el_archivo, "", $fecha, $activo, $id);
		    }		    
		}else if ($el_archivo == "" && $el_archivo2 != ""){
		    if ($id == ""){
		        $response = $dataServ->saveNew($titulo, $description, "", $el_archivo2, $fecha, $activo);
		    }else{
		       $response =  $dataServ->updateNew($titulo, $description, "", $el_archivo2, $fecha, $activo, $id);
		    }
		}else{
			if ($id == ""){
				$response = $dataServ->saveNew($titulo, $description, "", "", $fecha, $activo);
			}else{
				$response = $dataServ->updateNew($titulo, $description, "", "", $fecha, $activo, $id);	  
			}
		}		
		$response = json_decode($response);
		echo json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados", "query"=>$response->query));		
	}
?>
