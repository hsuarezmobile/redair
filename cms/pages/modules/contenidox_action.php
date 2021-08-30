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
		$nombre = @$_POST['nombre'];
		$id = @$_POST['id'];
		$ret = "";
			        
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
				if (file_exists("../../../img/blog-img/".$name_arch)){ // -> si existe el archivo te lo vuelas
					@unlink("../../../img/blog-img/".$name_arch);
				}
				$el_archivo = subir_archivo("archivo", "../../../img/blog-img/", "jpg", $nombre_archivo);
				$ret = $dataServ->updateContenidox($nombre, $id, $el_archivo);
			}
		}else{
		    $ret = $dataServ->updateContenidox($nombre, $id, "");		    
		}				
		echo $ret;		
	}
?>