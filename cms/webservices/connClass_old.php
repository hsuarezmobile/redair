<?php 
class conexion_db{ // --> clase par conexion a la db 
        function conectarse($ip_servidor, $usuario_servidor, $pwd_servidor, $dbname){ 
            // permite conectarse a una db
	    $mysqli = null; $mysqli = new mysqli($ip_servidor, $usuario_servidor,$pwd_servidor, $dbname);
	    $mysqli->set_charset("utf8");
	    return $mysqli;
	}
	function desconectarse($link){ // desconecta de una db return 
		mysqli_close($link);
	}
	function seleccionar_db($database, $link=null){ // selecciona una db 
		$db_sel = mysqli_select_db($database, $link); return $db_sel;
	}
}
class recordset_db{ 
var $query; 
var $mysql_error;
var $dataReturn = null; 
function select($campos, $tabla, $condiciones, $adicional, $mysqli_link){
		if ($condiciones != ""){ $this->query = "SELECT ".$campos." FROM 
			".$tabla." WHERE ".$condiciones." ".$adicional;
		}else{
			$this->query = "SELECT ".$campos." FROM ".$tabla." 
			".$adicional;
		}
		$dataReturn = mysqli_query($mysqli_link, $this->query); 
		$this->mysql_error = mysqli_error(); return $dataReturn;
	}
	function insert($tabla, $campos, $valores, $mysqli_link){ $this->query = 
		"INSERT INTO ".$tabla." (".$campos.") VALUES (".$valores.")"; 
		mysqli_query ($mysqli_link, $this->query); return mysqli_error();
	}
	function borrar($tabla, $condicion, $mysqli_link){ $this->query = "DELETE 
		FROM ".$tabla." where ".$condicion; mysqli_query ($mysqli_link, 
		$this->query); return mysqli_error();
	}
	function update($tabla, $campos_y_valores, $condicion, $mysqli_link){ 
		$this->query = "UPDATE ".$tabla." SET ".$campos_y_valores." WHERE 
		".$condicion; mysqli_query ($mysqli_link, $this->query); return 
		mysqli_error();
	}
	function fetch($recordset){ $this->mysql_error = mysqli_error(); return 
		mysqli_fetch_assoc($recordset);
	}
	function cuantos($recordset){ return mysqli_num_rows($recordset);
	}
	function last_insert_id($conex){ $this->mysql_error = mysqli_error(); 
		return mysqli_insert_id($conex);
	}
}
?>
