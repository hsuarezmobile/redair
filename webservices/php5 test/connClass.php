<?php
class conexion_db{ // --> clase par conexion a la db

	function conectarse($ip_servidor, $usuario_servidor, $pwd_servidor){ // permite conectarse a una db
		return @mysql_connect($ip_servidor,$usuario_servidor,$pwd_servidor);
	}
	function desconectarse($link){ // desconecta de una db
		return mysql_close($link);
	}
	function seleccionar_db($database, $link=null){ // selecciona una db
		$db_sel = mysql_select_db($database, $link);
		return $db_sel;
	}
}
class recordset_db{
	var $query;
	var $mysql_error;
	function select($campos, $tabla, $condiciones, $adicional){
		if ($condiciones != ""){
			$this->query = "SELECT ".$campos." FROM ".$tabla." WHERE ".$condiciones." ".$adicional;
			return mysql_query("SELECT ".$campos." FROM ".$tabla." WHERE ".$condiciones." ".$adicional);
		}else{
			$this->query = "SELECT ".$campos." FROM ".$tabla." ".$adicional;
			return mysql_query("SELECT ".$campos." FROM ".$tabla." ".$adicional);
		}
		$this->mysql_error = mysql_error();
	}
	function insert($tabla, $campos, $valores){
		$this->query = "INSERT INTO ".$tabla." (".$campos.") VALUES (".$valores.")";
		mysql_query ("INSERT INTO ".$tabla." (".$campos.") VALUES (".$valores.")");
		$this->mysql_error = mysql_error();
	}
	function borrar($tabla, $condicion){
		$this->query = "DELETE FROM ".$tabla." where ".$condicion;
		mysql_query ("DELETE FROM ".$tabla." where ".$condicion);
		$this->mysql_error = mysql_error();
	}
	function update($tabla, $campos_y_valores, $condicion){
		$this->query = "UPDATE ".$tabla." SET ".$campos_y_valores." WHERE ".$condicion;
		mysql_query ("UPDATE ".$tabla." SET ".$campos_y_valores." WHERE ".$condicion);
		$this->mysql_error = mysql_error();
	}
	function fetch($recordset){
		$this->mysql_error = mysql_error();
		return mysql_fetch_assoc($recordset);
	}
	function cuantos($recordset){
		return mysql_num_rows($recordset);
	}
	function last_insert_id($conex){
		$this->mysql_error = mysql_error();
		return mysql_insert_id($conex);
	}
}
?>