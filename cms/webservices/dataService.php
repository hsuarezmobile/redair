<?php
header('Content-Type: text/html; charset=UTF-8');
// ****************************************
// proyect: cms mobile
// version: 1.0a
// date: 19-01-2019
// module: data handle class
// author: Humberto Suarez
// ****************************************
class dataService{
	var $rs_db_1 = null;
	var $row_db_1 = null;
	var $link = null;
	var $dbconn;
	var $rs;
	private function doConnect(){
	    $this->dbconn = new conexion_db();
	    $this->rs = new recordset_db();	   
	    $this->link = $this->dbconn->conectarse("localhost", "laserdev", "*Jmr-ze=Jx*z4yk", "redairweb");
	    $this->dbconn->seleccionar_db("redairweb", $this->link);
 	//	$this->link = $this->dbconn->conectarse("localhost", "root", "");
 	//	$this->dbconn->seleccionar_db("laser");
	}
	private function doDisconnect(){
		$this->dbconn->desconectarse($this->link);
		unset($this->rs);
		unset($this->dbconn);		
	}
	// login 
	public function doLogin($username, $password){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$loginSuccess = false;		
		//--> ciframos el password
		$cifrado=strtolower(substr(base64_encode($password), 0, 3)."*".substr(md5($password), 0, 3));		
		$this->rs_db_1 = $this->rs->select("usuario_id", "cms_usuarios", "usuario_username = '".$username."' and usuario_pwd = '".$cifrado."' and usuario_activo = 'S'", "", $this->link);
		if ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$uid = $this->row_db_1["usuario_id"];
			$loginSuccess = true;
		}		
		$this->doDisconnect();
		if ($loginSuccess){
		    return json_encode(array("result"=>true, "response"=>"OK", "uid"=>$uid, "message"=>"Inicio de sesion exitoso", "query"=>$query));			
		}else{
		    return json_encode(array("result"=>false, "response"=>"ERROR", "uid"=>$uid, "message"=>"Nombre de usuario o contraseña incorrecta", "query"=>$query));
		}
	}
	// resumen del website.
	public function getWebsiteStats(){
		$usuarios_cms = 0;
		$perfiles_cms = 0;
		$news_count = 0;
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_result = array();
		$this->doConnect();		
		$this->rs_db_1 = $this->rs->select("COUNT(usuario_id) as usuariosnum", "cms_usuarios", "1", "", $this->link);
		if ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$usuarios_cms = $this->row_db_1["usuariosnum"];
		}		
		$this->rs_db_1 = $this->rs->select("COUNT(perfil_id) as perfilnum", "cms_perfiles", "1", "", $this->link);
		if ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$perfiles_cms = $this->row_db_1["perfilnum"];
		}
		$this->rs_db_1 = $this->rs->select("COUNT(entry_id) as entrynum", "blog", "1", "", $this->link);
		if ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$news_count = $this->row_db_1["entrynum"];
		}
		$this->doDisconnect();
		$array_result = array("usuarioscms"=>$usuarios_cms, "perfilescms"=>$perfiles_cms, "cantidadnoticias"=>$news_count);
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos resumen cms Obtenidos", "data"=>$array_result));
	}
	
	// usuarios
	public function getUserList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_users = array();
		$x = 0;
		$status = "";	
		$this->doConnect();		
		$this->rs_db_1 = $this->rs->select("CONCAT(u.usuario_nombres, ' ', u.usuario_apellidos) AS nombres, p.perfil_nombre, u.usuario_activo, u.usuario_id as uid", "cms_usuarios u, cms_perfiles p", "u.perfil_id = p.perfil_id", "ORDER BY nombres ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["usuario_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_users[] = array("id"=>$this->row_db_1["uid"], "nombres"=>$this->row_db_1["nombres"], "perfil"=>$this->row_db_1["perfil_nombre"], "activo"=>$status);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de usuarios Obtenidos", "userlist"=>$array_users, "cantidad"=>$x));
	}
	// usuarios
	public function getUserById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
	    $array_users = array();
	    $x = 0;
	    $status = "";
	    $this->doConnect();
	    $this->rs_db_1 = $this->rs->select("u.usuario_nombres, u.usuario_apellidos, p.perfil_nombre, u.usuario_activo, u.usuario_id as uid, u.usuario_username", "cms_usuarios u, cms_perfiles p", "u.perfil_id = p.perfil_id and u.usuario_id = ".$id, "", $this->link);
	    if ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        if ($this->row_db_1["usuario_activo"] == "S"){
	            $status = "Activo";
	        }else{
	            $status = "Inactivo";
	        }
	        $array_users[] = array("id"=>$this->row_db_1["uid"], "nombres"=>$this->row_db_1["usuario_nombres"], "apellidos"=>$this->row_db_1["usuario_apellidos"], "perfil"=>$this->row_db_1["perfil_nombre"], "username"=>$this->row_db_1["usuario_username"], "activo"=>$status);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de usuarios Obtenidos", "userdata"=>$array_users, "cantidad"=>$x));
	}
	// pefil
	public function getProfileById($id){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_users = array();
	    $x = 0;
	    $status = "";
	    $this->doConnect();
	    $this->rs_db_1 = $this->rs->select("perfil_nombre, perfil_permisos, perfil_activo", "cms_perfiles", "perfil_id = ".$id, "", $this->link);
	    if ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        if ($this->row_db_1["perfil_activo"] == "S"){
	            $status = "Activo";
	        }else{
	            $status = "Inactivo";
	        }
	        $array_users[] = array("id"=>$this->row_db_1["uid"], "nombre"=>$this->row_db_1["perfil_nombre"], "permisos"=>$this->row_db_1["perfil_permisos"], "activo"=>$this->row_db_1["perfil_activo"], "perfil_id = {$id}");
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de usuarios Obtenidos", "userdata"=>$array_users, "cantidad"=>$x));
	}	
	public function getEntryById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_entries = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("entry_id, entry_user, entry_date, entry_title, entry_desc, entry_img, entry_imgdetail, entry_activo", "blog", "entry_id = {$id}", "", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["entry_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_entries[] = array("id"=>$this->row_db_1["entry_id"], "user"=>$this->row_db_1["entry_user"], "fecha"=>$this->row_db_1["entry_date"], "titulo"=>$this->row_db_1["entry_title"], "descripcion"=>$this->row_db_1["entry_desc"], "imagen"=>$this->row_db_1["entry_img"], "entry_imgdetail"=>$this->row_db_1["entry_imgdetail"], "entry_activo"=>$this->row_db_1["entry_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de entradas del blog obtenidas", "entriesList"=>$array_entries, "count"=>$x));
	}
	// perfiles
	public function getProfileList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$query = "";
		$this->rs_db_1 = $this->rs->select("perfil_id, perfil_nombre, perfil_permisos, perfil_activo", "cms_perfiles", "1", "ORDER BY perfil_nombre ASC", $this->link);
		$query = $this->rs->query;
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["perfil_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}			
			$array_profile[] = array("id"=>$this->row_db_1["perfil_id"], "nombre"=>$this->row_db_1["perfil_nombre"], "permisos"=>$this->row_db_1["perfil_permisos"], "activo"=>$status);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de perfiles Obtenidos", "profilelist"=>$array_profile, "cantidad"=>$x));
	}		
	// guardar usuario
	public function saveUser($surname, $lastname, $username, $pwd, $perfil, $status){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$cifrado = "";
		$cifrado=strtolower(substr(base64_encode($pwd), 0, 3)."*".substr(md5($pwd), 0, 3));
		$this->rs->insert("cms_usuarios", "perfil_id, usuario_nombres, usuario_apellidos, usuario_username, usuario_pwd, usuario_activo", $perfil.",'".$surname."','".$lastname."','".$username."','".$cifrado."','".$status."'");
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));
	}
	// guardar perfil
	public function saveProfile($nombre, $permisos, $activo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->insert("cms_perfiles", "perfil_nombre, perfil_permisos, perfil_activo", "'{$nombre}', '{$permisos}', '{$activo}'", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));
	}	
	public function updateUser($id, $surname, $lastname, $username, $pwd, $perfil, $status){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		if ($pwd != ""){
			$cifrado = "";
			$cifrado=strtolower(substr(base64_encode($pwd), 0, 3)."*".substr(md5($pwd), 0, 3));
			$this->rs->update("cms_usuarios", "perfil_id = '{$perfil}', usuario_nombres = '{$surname}', usuario_apellidos = '{$lastname}', usuario_username = '{$username}', usuario_pwd = '{$cifrado}'", "usuario_id = {$id}", $this->link);
		}else{
		    $this->rs->update("cms_usuarios", "perfil_id = '{$perfil}', usuario_nombres = '{$surname}', usuario_apellidos = '{$lastname}', usuario_username = '{$username}'", "usuario_id = {$id}", $this->link);
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados"));		
	}	
	public function updateProfile($id, $nombre, $permisos, $activo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->update("cms_perfiles", "perfil_nombre = '{$nombre}', perfil_permisos = '{$permisos}', perfil_activo = '{$activo}'", "perfil_id = {$id}", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados"));		
	}
	// borra contenido viajar
	public function deleteViajar($id){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_profile = array();
	    $this->doConnect();
	    $this->rs->borrar("contenidos", "contenido_id = ".$id, $this->link);
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"contenido borrado"));
	}
	// borra contenido
	public function deleteContenido($id){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_profile = array();
	    $this->doConnect();
	    $this->rs->borrar("contenidos", "contenido_id = ".$id, $this->link);
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"contenido borrado"));
	}
	// borra usuario
	public function deleteUser($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->borrar("cms_usuarios", "usuario_id = ".$id, $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"usuario borrado"));
	}	
	// borra perfil
	public function deleteProfile($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->borrar("cms_perfiles", "perfil_id = ".$id, $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"perfil borrado"));
	}	
	// borra entrada del blog
	public function deleteEntry($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->borrar("blog", "entry_id = ".$id, $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"entrada del blog borrada"));
	}
	// guardar entrada
	public function saveEntry($autor, $fecha, $titulo, $descripcion, $imagen, $activo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->insert("blog", "entry_user, entry_date, entry_title, entry_desc, entry_img, entry_imgdetail, entry_activo", "'{$autor}', '{$fecha}', '{$titulo}', '{$descripcion}', '{$imagen}', '{$imagen}', '{$activo}'", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));
	}
	public function updateEntry($autor, $fecha, $titulo, $descripcion, $imagen, $activo, $id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		if ($imagen != ""){
		    $this->rs->update("blog", "entry_user = '{$autor}', entry_date = '{$fecha}', entry_title = '{$titulo}', entry_desc = '{$descripcion}', entry_img = '{$imagen}', entry_imgdetail = '{$imagen}', entry_activo = '{$activo}'", "entry_id = {$id}", $this->link);
		}else{
		    $this->rs->update("blog", "entry_user = '{$autor}', entry_date = '{$fecha}', entry_title = '{$titulo}', entry_desc = '{$descripcion}', entry_activo = '{$activo}'", "entry_id = {$id}", $this->link);
		}		
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados"));
	}
	// permisos del perfil
	public function getPermisos($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs_db_1 = $this->rs->select("perfil_permisos", "cms_perfiles d, cms_usuarios u", "d.perfil_id = u.perfil_id and u.usuario_id = {$id}", "", $this->link);
		if ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$permisos = $this->row_db_1["perfil_permisos"];
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "permisos"=>$permisos));
	}	
	// verifica permisos sobre un modulo
	public function checkpermiso($modulo){
		$check = false;
		$json_permisos = array();
		$json_permisos = json_decode($this->getPermisos($_SESSION["uid"]));
		$los_permisos = array();
		$los_permisos = explode(",", $json_permisos->permisos);
		for ($x = 0; $x < sizeof($los_permisos); $x++){
			if (trim(strtolower($los_permisos[$x])) == trim(strtolower($modulo))){
				$check = true;
				break;
			}
		}
		return $check;
	}
	// devuelve el listado de entradas del blog
	public function getBlogList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_entries = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("entry_id, entry_user, entry_date, entry_title, entry_desc, entry_img, entry_imgdetail, entry_activo", "blog", "1", "ORDER BY entry_id DESC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["entry_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_entries[] = array("id"=>$this->row_db_1["entry_id"], "user"=>$this->row_db_1["entry_user"], "fecha"=>$this->row_db_1["entry_date"], "titulo"=>$this->row_db_1["entry_title"], "descripcion"=>$this->row_db_1["entry_desc"], "imagen"=>$this->row_db_1["entry_img"], "entry_imgdetail"=>$this->row_db_1["entry_imgdetail"], "entry_activo"=>$this->row_db_1["entry_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de entradas del blog obtenidas", "entriesList"=>$array_entries, "count"=>$x));		
	}
	public function getVitrinaList(){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $arrayVitrinas = array();
	    $this->doConnect();
	    $x = 0;
	    $this->rs_db_1 = $this->rs->select("vitrina_id, vitrina_nombre, vitrina_img, vitrina_activo, vitrina_orden", "vitrinas", "vitrina_id > 0", "ORDER BY vitrina_orden ASC", $this->link);
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $arrayVitrinas[] = array("id"=>$this->row_db_1["vitrina_id"], "nombre"=>$this->row_db_1["vitrina_nombre"], "img"=>$this->row_db_1["vitrina_img"], "activo"=>$this->row_db_1["vitrina_activo"], "orden"=>$this->row_db_1["vitrina_orden"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"vitrinas obtenidas", "virinasList"=>$arrayVitrinas, "count"=>$x));
	}
	// borra vitrina
	public function deleteVitrina($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->borrar("vitrinas", "vitrina_id = ".$id, $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"vitrina borrada"));
	}
	// guardar vitrina
	public function saveVitrina($nombre, $orden, $imagen, $activo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->insert("vitrinas", "vitrina_nombre, vitrina_img, vitrina_orden, vitrina_activo", "'{$nombre}', '{$imagen}', '{$orden}', '{$activo}'", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));
	}
	// actualizar vitrina
	public function updateVitrina($nombre, $orden, $imagen, $activo, $id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		if ($imagen != ""){
		    $this->rs->update("vitrinas", "vitrina_nombre = '{$nombre}', vitrina_orden = '{$orden}', vitrina_img = '{$imagen}', vitrina_activo = '{$activo}'", "vitrina_id = {$id}", $this->link);
		}else{
		    $this->rs->update("vitrinas", "vitrina_nombre = '{$nombre}', vitrina_orden = '{$orden}', vitrina_activo = '{$activo}'", "vitrina_id = {$id}", $this->link);
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados"));
	}
	// obtener dados de una vitrina por id
	public function getVitrinaById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_vitrina = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("vitrina_id, vitrina_nombre, vitrina_img, vitrina_activo, vitrina_orden", "vitrinas", "vitrina_id = {$id}", "", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["vitrina_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_vitrina[] = array("id"=>$this->row_db_1["vitrina_id"], "nombre"=>$this->row_db_1["vitrina_nombre"], "imagen"=>$this->row_db_1["vitrina_img"], "activo"=>$this->row_db_1["vitrina_activo"], "orden"=>$this->row_db_1["vitrina_orden"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de la vitrina obtenidos", "vitrinaList"=>$array_vitrina, "count"=>$x));
	}
	// borra tarifa
	public function deleteTarifa($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->borrar("tarifas", "tarifa_id = ".$id, $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"tarifa borrada"));
	}
	// guardar tarifa
	public function saveTarifa($nombre, $destino, $monto, $imagen, $orden, $activo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->insert("tarifas", "tarifa_nombre, tarifa_destino, tarifa_monto, tarifa_img, tarifa_orden, tarifa_activo", "'{$nombre}', '{$destino}', '{$monto}', '{$imagen}', '{$orden}', '{$activo}'", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));
	}
	// actualizar tarifa
	public function updateTarifa($nombre, $destino, $monto, $imagen, $orden, $activo, $id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$query = "";
		$this->doConnect();
		if ($imagen != ""){
		    $this->rs->update("tarifas", "tarifa_nombre = '{$nombre}', tarifa_destino = '{$destino}', tarifa_monto = '{$monto}', tarifa_img = '{$imagen}', tarifa_orden = '{$orden}', tarifa_activo = '{$activo}'", "tarifa_id = {$id}", $this->link);
		}else{
		    $this->rs->update("tarifas", "tarifa_nombre = '{$nombre}', tarifa_destino = '{$destino}', tarifa_monto = '{$monto}', tarifa_orden = '{$orden}', tarifa_activo = '{$activo}'", "tarifa_id = {$id}", $this->link);
		}
		$query = $this->rs->query;
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados", "query"=>$query));
	}
	// obtener datos de una tarifa por id
	public function getTarifaById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_tarifa = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("tarifa_id, tarifa_nombre, tarifa_destino, tarifa_monto, tarifa_img, tarifa_orden, tarifa_activo", "tarifas", "tarifa_id = {$id}", "", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["tarifa_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_tarifa[] = array("id"=>$this->row_db_1["tarifa_id"], "nombre"=>$this->row_db_1["tarifa_nombre"], "destino"=>$this->row_db_1["tarifa_destino"], "monto"=>$this->row_db_1["tarifa_monto"], "imagen"=>$this->row_db_1["tarifa_img"], "orden"=>$this->row_db_1["tarifa_orden"], "activo"=>$this->row_db_1["tarifa_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de la tarifa obtenidos", "tarifasList"=>$array_tarifa, "count"=>$x));
	}
	// obtener datos de tarifas
	public function getTarifaList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_tarifa = array();
		$this->doConnect();
		$x = 0;
		$this->rs_db_1 = $this->rs->select("tarifa_id, tarifa_nombre, tarifa_destino, tarifa_monto, tarifa_img, tarifa_orden, tarifa_activo", "tarifas", "tarifa_id >0", "", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_tarifa[] = array("id"=>$this->row_db_1["tarifa_id"], "nombre"=>$this->row_db_1["tarifa_nombre"], "monto"=>$this->row_db_1["tarifa_monto"], "imagen"=>$this->row_db_1["tarifa_img"], "orden"=>$this->row_db_1["tarifa_orden"], "activo"=>$this->row_db_1["tarifa_activo"]);
			$x++;
		}	
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"tarifas obtenidas", "tarifasList"=>$array_tarifa, "count"=>$x));
	}
	// obtener datos de noticias
	public function getNewsList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_noticia = array();
		$this->doConnect();
		$x = 0;
		$this->rs_db_1 = $this->rs->select("noticia_id, noticia_titulo, noticia_contenido, noticia_img, noticia_fecha, noticia_activo", "noticias", "noticia_id > 0", "ORDER BY noticia_fecha DESC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_noticia[] = array("id"=>$this->row_db_1["noticia_id"], "titulo"=>$this->row_db_1["noticia_titulo"], "contenido"=>$this->row_db_1["noticia_contenido"], "img"=>$this->row_db_1["noticia_img"], "fecha"=>$this->row_db_1["noticia_fecha"], "activo"=>$this->row_db_1["noticia_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"noticias obtenidas", "data"=>$array_noticia, "count"=>$x));
	}
	// borra noticia
	public function deleteNoticia($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->borrar("noticias", "noticia_id = ".$id);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"noticia borrada"));
	}
	// guardar noticia
	public function saveNew($titulo, $contenido, $imagen, $imagen2, $fecha, $activo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		$this->rs->insert("noticias", "noticia_titulo, noticia_contenido, noticia_img, noticia_img2, noticia_fecha, noticia_activo", "'{$titulo}', '{$contenido}', '{$imagen}', '{$imagen2}', '{$fecha}', '{$activo}'", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));
	}
	// actualizar noticia
	public function updateNew($titulo, $contenido, $imagen, $imagen2, $fecha, $activo, $id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_profile = array();
		$this->doConnect();
		if ($imagen != "" && $imagen2 != ""){
		    $this->rs->update("noticias", "noticia_titulo = '{$titulo}', noticia_contenido = '{$contenido}', noticia_img = '{$imagen}', noticia_img2 = '{$imagen2}', noticia_fecha = '{$fecha}', noticia_activo = '{$activo}' ", " noticia_id = {$id}", $this->link);
		}else if ($imagen == "" && $imagen2 != ""){
		    $this->rs->update("noticias", "noticia_titulo = '{$titulo}', noticia_contenido = '{$contenido}', noticia_img2 = '{$imagen2}', noticia_fecha = '{$fecha}', noticia_activo = '{$activo}' ", " noticia_id = {$id}", $this->link);			
		}else if ($imagen != "" && $imagen2 == ""){
		    $this->rs->update("noticias", "noticia_titulo = '{$titulo}', noticia_contenido = '{$contenido}', noticia_img = '{$imagen}', noticia_fecha = '{$fecha}', noticia_activo = '{$activo}' ", " noticia_id = {$id}", $this->link);			
		}else{
		    $this->rs->update("noticias", "noticia_titulo = '{$titulo}', noticia_contenido = '{$contenido}', noticia_fecha = '{$fecha}', noticia_activo = '{$activo}' ", " noticia_id = {$id}", $this->link);
		}
		$query = $this->rs->query;
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados", "query"=>$query));
	}
	// obtener datos de una tarifa por id
	public function getNoticiaById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_noticia = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("noticia_id, noticia_titulo, noticia_contenido, noticia_img, noticia_img2, noticia_fecha, noticia_activo", "noticias", "noticia_id = {$id}", "", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["noticia_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_noticia[] = array("id"=>$this->row_db_1["noticia_id"], "titulo"=>$this->row_db_1["noticia_titulo"], "contenido"=>$this->row_db_1["noticia_contenido"], "img"=>$this->row_db_1["noticia_img"], "img2"=>$this->row_db_1["noticia_img2"], "fecha"=>$this->row_db_1["noticia_fecha"], "activo"=>$this->row_db_1["noticia_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de la noticia obtenidos", "noticiaList"=>$array_noticia, "count"=>$x));
	}
	// obtener datos de tarifa de equipaje
	public function getTarifaEquipajeList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_tarifasdesc = array();
		$this->doConnect();
		$x = 0;
		$this->rs_db_1 = $this->rs->select("equipajetar_id, equipajetar_desc, equipajetar_mia, equipajetar_sdq, equipajetar_pty, equipajetar_cur, equipajetar_aua, equipajetar_gye, equipajetar_orden, equipajetar_activo", "equipaje_tarifa", "equipajetar_id > 0", "ORDER BY equipajetar_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_tarifasdesc[] = array("id"=>$this->row_db_1["equipajetar_id"], "desc"=>$this->row_db_1["equipajetar_desc"], "mia"=>$this->row_db_1["equipajetar_mia"], "sdq"=>$this->row_db_1["equipajetar_sdq"], "pty"=>$this->row_db_1["equipajetar_pty"], "cur"=>$this->row_db_1["equipajetar_cur"], "aua"=>$this->row_db_1["equipajetar_aua"], "gye"=>$this->row_db_1["equipajetar_gye"], "orden"=>$this->row_db_1["equipajetar_orden"], "activo"=>$this->row_db_1["equipajetar_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"descripcion de tarifas de equipaje obtenidas", "data"=>$array_tarifasdesc, "count"=>$x));
	}
	// borra tarifa de equipaje
	public function deleteTarifaEquipaje($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->borrar("equipaje_tarifa", "equipajetar_id = ".$id, $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"tarifa de equipaje borrada"));
	}
	// guardar tarifa de equipaje
	public function saveTarifaEquipaje($desc, $mia, $sdq, $pty, $cur, $aua, $gye, $orden, $activo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->insert("equipaje_tarifa", "equipajetar_desc, equipajetar_mia, equipajetar_sdq, equipajetar_pty, equipajetar_cur, equipajetar_aua, equipajetar_gye, equipajetar_orden, equipajetar_activo", "'{$desc}', '{$mia}', '{$sdq}', '{$pty}', '{$cur}', '{$aua}', '{$gye}', '{$orden}', '{$activo}'", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));
	}
	// actualizar tarifa de equipaje
	public function updateTarifaEquipaje($desc, $mia, $sdq, $pty, $cur, $aua, $gye, $orden, $activo, $id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->update("equipaje_tarifa", "equipajetar_desc = '{$desc}', equipajetar_mia = '{$mia}', equipajetar_sdq = '{$sdq}', equipajetar_pty = '{$pty}', equipajetar_cur = '{$cur}', equipajetar_aua = '{$aua}', equipajetar_gye = '{$gye}', equipajetar_orden = '{$orden}', equipajetar_activo = '{$activo}'", "equipajetar_id = {$id}", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados"));
	}
	// obtener datos de una tarifa de equipaje por id
	public function getTarifaEquipajeById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_tarifasdesc = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("equipajetar_id, equipajetar_desc, equipajetar_mia, equipajetar_sdq, equipajetar_pty, equipajetar_cur, equipajetar_aua, equipajetar_gye, equipajetar_orden, equipajetar_activo", "equipaje_tarifa", "equipajetar_id = {$id}", "", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["equipajetar_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_tarifasdesc[] = array("id"=>$this->row_db_1["equipajetar_id"], "desc"=>$this->row_db_1["equipajetar_desc"], "mia"=>$this->row_db_1["equipajetar_mia"], "sdq"=>$this->row_db_1["equipajetar_sdq"], "pty"=>$this->row_db_1["equipajetar_pty"], "cur"=>$this->row_db_1["equipajetar_cur"], "aua"=>$this->row_db_1["equipajetar_aua"], "gye"=>$this->row_db_1["equipajetar_gye"], "orden"=>$this->row_db_1["equipajetar_orden"], "activo"=>$this->row_db_1["equipajetar_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de la noticia obtenidos", "tarifaEquipajeList"=>$array_tarifasdesc, "count"=>$x));
	}
	
	// obtener ArticuloNoIndemnizable
	public function getArticuloNoIndemnizableList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_tarifasdesc = array();
		$this->doConnect();
		$x = 0;
		$this->rs_db_1 = $this->rs->select("equipajedes_id, equipajedes_desc1, equipajedes_desc2, equipajedes_activo, equipajedes_orden", "equipaje_descripcion", "equipajedes_id > 0", "ORDER BY equipajedes_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_tarifasdesc[] = array("id"=>$this->row_db_1["equipajedes_id"], "desc1"=>$this->row_db_1["equipajedes_desc1"], "desc2"=>$this->row_db_1["equipajedes_desc2"], "orden"=>$this->row_db_1["equipajedes_orden"], "activo"=>$this->row_db_1["equipajedes_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"descripcion de articulo no indemnizable obtenidas", "data"=>$array_tarifasdesc, "count"=>$x));
	}
	// borra ArticuloNoIndemnizable
	public function deleteArticuloNoIndemnizable($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->borrar("equipaje_descripcion", "equipajedes_id = ".$id, $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"articulo no indemnizable borrada"));
	}
	// guardar ArticuloNoIndemnizable
	public function saveArticuloNoIndemnizable($desc1, $desc2, $orden, $activo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->insert("equipaje_descripcion", "equipajedes_desc1, equipajedes_desc2, equipajedes_activo, equipajedes_orden", "'{$desc1}', '{$desc2}', '{$activo}', '{$orden}'", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));
	}
	// actualizar ArticuloNoIndemnizable
	public function updateArticuloNoIndemnizable($desc1, $desc2, $orden, $activo, $id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->update("equipaje_descripcion", "equipajedes_desc1 = '{$desc1}', equipajedes_desc2 = '{$desc2}', equipajedes_orden = '{$orden}', equipajedes_activo = '{$activo}'", "equipajedes_id = {$id}", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados"));
	}
	// obtener datos de ArticuloNoIndemnizable por id
	public function getArticuloNoIndemnizableById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_tarifasdesc = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("equipajedes_id, equipajedes_desc1, equipajedes_desc2, equipajedes_activo, equipajedes_orden", "equipaje_descripcion", "equipajedes_id = '{$id}'", "ORDER BY equipajedes_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["equipajedes_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_tarifasdesc[] = array("id"=>$this->row_db_1["equipajedes_id"], "desc1"=>$this->row_db_1["equipajedes_desc1"], "desc2"=>$this->row_db_1["equipajedes_desc2"], "orden"=>$this->row_db_1["equipajedes_orden"], "activo"=>$this->row_db_1["equipajedes_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de articulo no indemnizable obtenidos", "articuloList"=>$array_tarifasdesc, "count"=>$x));
	}
	
	// obtener servicios de carga
	public function getServiciosCargaList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_tarcarga = array();
		$this->doConnect();
		$x = 0;
		$this->rs_db_1 = $this->rs->select("tarifacar_id, tarifacar_tipomercancia, tarifacar_peso, tarifacar_montoves, tarifacar_miscelaneo, tarifacar_conexion, tarifacar_orden, tarifacar_activo", "tarifa_carga", "tarifacar_activo = 'S'", "ORDER BY tarifacar_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_tarcarga[] = array("id"=>$this->row_db_1["tarifacar_id"], "tipo"=>$this->row_db_1["tarifacar_tipomercancia"], "peso"=>$this->row_db_1["tarifacar_peso"], "montoves"=>$this->row_db_1["tarifacar_montoves"], "miscelaneo"=>$this->row_db_1["tarifacar_miscelaneo"], "conexion"=>$this->row_db_1["tarifacar_conexion"], "orden"=>$this->row_db_1["tarifacar_orden"], "activo"=>$this->row_db_1["tarifacar_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"servicios de carga obtenidas", "data"=>$array_tarcarga, "count"=>$x));
	}
	// borra servicios de carga
	public function deleteServiciosCarga($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->borrar("tarifa_carga", "tarifacar_id = ".$id, $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"servicios de carga borrada"));
	}
	// guardar servicios de carga
	public function saveServiciosCarga($tipo, $peso, $montoves, $miscelaneo, $conexion, $orden, $activo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->insert("tarifa_carga", "tarifacar_tipomercancia tarifacar_peso, tarifacar_montoves, tarifacar_miscelaneo, tarifacar_conexion, tarifacar_activo, tarifacar_orden", "'{$tipo}', '{$peso}', '{$montoves}', '{$miscelaneo}', '{$conexion}', '{$activo}', '{$orden}'", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));
	}
	// actualizar servicios de carga
	public function updateServiciosCarga($tipo, $peso, $montoves, $miscelaneo, $conexion, $orden, $activo, $id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->update("tarifa_carga", "tarifacar_tipomercancia = '{$tipo}', tarifacar_peso = '{$peso}', tarifacar_montoves = '{$montoves}', tarifacar_miscelaneo = '{$miscelaneo}', tarifacar_conexion = '{$conexion}', tarifacar_activo = '{$activo}', tarifacar_orden = '{$orden}'", "tarifacar_id = {$id}", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados"));
	}
	// obtener datos de servicios de carga por id
	public function getServiciosCargaById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_tarifasdesc = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("tarifacar_id, tarifacar_tipomercancia, tarifacar_peso, tarifacar_montoves, tarifacar_miscelaneo, tarifacar_conexion, tarifacar_orden, tarifacar_activo", "tarifa_carga", "tarifacar_id = '{$id}'", "ORDER BY tarifacar_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["tarifacar_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_tarcarga[] = array("id"=>$this->row_db_1["tarifacar_id"], "tipo"=>$this->row_db_1["tarifacar_tipomercancia"], "peso"=>$this->row_db_1["tarifacar_peso"], "montoves"=>$this->row_db_1["tarifacar_montoves"], "miscelaneo"=>$this->row_db_1["tarifacar_miscelaneo"], "conexion"=>$this->row_db_1["tarifacar_conexion"], "orden"=>$this->row_db_1["tarifacar_orden"], "activo"=>$this->row_db_1["tarifacar_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de servicios de carga obtenidos", "articuloList"=>$array_tarcarga, "count"=>$x));
	}	
	
	// obtener fundalaser
	public function getfundalaserList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_fundalaser = array();
		$this->doConnect();
		$x = 0;
		$this->rs_db_1 = $this->rs->select("fundalaser_id, fundalaser_nombre, fundalaser_img, fundalaser_orden, fundalaser_activo", "fundalaser_logos", "fundalaser_id > 0", "ORDER BY fundalaser_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_fundalaser[] = array("id"=>$this->row_db_1["fundalaser_id"], "nombre"=>$this->row_db_1["fundalaser_nombre"], "img"=>$this->row_db_1["fundalaser_img"], "orden"=>$this->row_db_1["fundalaser_orden"], "activo"=>$this->row_db_1["fundalaser_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"item de fundalaser obtenidos", "data"=>$array_fundalaser, "count"=>$x));
	}
	// borra fundalaser
	public function deletefundalaser($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->borrar("fundalaser_logos", "fundalaser_id = ".$id, $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"item de fundalaser borrado"));
	}
	// guardar fundalaser
	public function savefundalaser($nombre, $img, $orden, $activo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->insert("fundalaser_logos", "fundalaser_nombre, fundalaser_img, fundalaser_orden, fundalaser_activo", "'{$nombre}', '{$img}', '{$orden}', '{$activo}'", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));
	}
	// actualizar fundalaser
	public function updatefundalaser($nombre, $img, $orden, $activo, $id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();		
		if ($img != ""){
		    $this->rs->update("fundalaser_logos", "fundalaser_nombre = '{$nombre}', fundalaser_img = '{$img}', fundalaser_activo = '{$activo}', fundalaser_orden = '{$orden}'", "fundalaser_id = {$id}", $this->link);			
		}else{
		    $this->rs->update("fundalaser_logos", "fundalaser_nombre = '{$nombre}', fundalaser_activo = '{$activo}', fundalaser_orden = '{$orden}'", "fundalaser_id = {$id}", $this->link);
		}		
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados"));
	}
	// obtener datos de fundalaser por id
	public function getfundalaserById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_tarcarga = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("fundalaser_id, fundalaser_nombre, fundalaser_img, fundalaser_orden, fundalaser_activo", "fundalaser_logos", "fundalaser_id = '{$id}'", "ORDER BY fundalaser_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["fundalaser_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_tarcarga[] = array("id"=>$this->row_db_1["fundalaser_id"], "nombre"=>$this->row_db_1["fundalaser_nombre"], "img"=>$this->row_db_1["fundalaser_img"], "orden"=>$this->row_db_1["fundalaser_orden"], "activo"=>$this->row_db_1["fundalaser_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de item de fundalaser obtenidos", "articuloList"=>$array_tarcarga, "count"=>$x));
	}	
	
	// obtener vuelos
	public function getvuelosList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_vuelos = array();
		$this->doConnect();
		$x = 0;
		$this->rs_db_1 = $this->rs->select("itinerario_id, itinerario_vuelo, itinerario_salida, itinerario_destino, itinerario_llegada, itinerario_frecuencia, itinerario_tipo, itinerario_orden, itinerario_activo", "itinerarios", "itinerario_id > 0", "ORDER BY itinerario_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_vuelos[] = array("id"=>$this->row_db_1["itinerario_id"], "vuelo"=>$this->row_db_1["itinerario_vuelo"], "salida"=>$this->row_db_1["itinerario_salida"], "destino"=>$this->row_db_1["itinerario_destino"], "llegada"=>$this->row_db_1["itinerario_llegada"], "frecuencia"=>$this->row_db_1["itinerario_frecuencia"], "tipo"=>$this->row_db_1["itinerario_tipo"], "orden"=>$this->row_db_1["itinerario_orden"], "activo"=>$this->row_db_1["itinerario_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"item de fundalaser obtenidos", "data"=>$array_vuelos, "count"=>$x));
	}
	// borra vuelos
	public function deletevuelos($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->borrar("itinerarios", "itinerario_id = ".$id, $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"item de itinerario borrado"));
	}
	// guardar vuelos
	public function savevuelos($vuelo, $salida, $destino, $llegada, $frecuencia, $tipo, $orden, $activo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();
		$this->rs->insert("itinerarios", "itinerario_vuelo, itinerario_salida, itinerario_destino, itinerario_llegada, itinerario_frecuencia, itinerario_tipo, itinerario_orden, itinerario_activo", "'{$vuelo}', '{$salida}', '{$destino}', '{$llegada}', '{$frecuencia}', '{$tipo}', '{$orden}', '{$activo}'", $this->link);
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados"));
	}
	// actualizar vuelos
	public function updatevuelos($vuelo, $salida, $destino, $llegada, $frecuencia, $tipo, $orden, $activo, $id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();		
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados"));
	}
	// obtener datos de vuelos por id
	public function getvuelosById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_vuelos = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("itinerario_id, itinerario_vuelo, itinerario_salida, itinerario_destino, itinerario_llegada, itinerario_frecuencia, itinerario_tipo, itinerario_orden, itinerario_activo", "itinerarios", "itinerario_id = ".$id, "ORDER BY itinerario_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["itinerario_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_vuelos[] = array("id"=>$this->row_db_1["itinerario_id"], "vuelo"=>$this->row_db_1["itinerario_vuelo"], "salida"=>$this->row_db_1["itinerario_salida"], "destino"=>$this->row_db_1["itinerario_destino"], "llegada"=>$this->row_db_1["itinerario_llegada"], "frecuencia"=>$this->row_db_1["itinerario_frecuencia"], "tipo"=>$this->row_db_1["itinerario_tipo"], "orden"=>$this->row_db_1["itinerario_orden"], "activo"=>$status);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de item de itinerario obtenidos", "articuloList"=>$array_vuelos, "count"=>$x));
	}	
	// obtener viajar
	public function getViajarList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_vuelos = array();
		$this->doConnect();
		$x = 0;
		$this->rs_db_1 = $this->rs->select("contenido_id, contenido_nombre, contenido_contenido, contenido_orden", "contenidos", "contenido_id > 0 and contenido_skip = 0", "ORDER BY contenido_ORDEN ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
		    $array_vuelos[] = array("id"=>$this->row_db_1["contenido_id"], "nombre"=>$this->row_db_1["contenido_nombre"], "contenido"=>$this->row_db_1["contenido_contenido"], "orden"=>$this->row_db_1["contenido_orden"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"item de antes de viajar obtenidos", "data"=>$array_vuelos, "count"=>$x));
	}	
	// obtener secciones antes de viajar por id
	public function getViajarById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_vuelos = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("contenido_id, contenido_nombre, contenido_contenido, contenido_orden", "contenidos", "contenido_id = ".$id, "", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
		    $array_vuelos[] = array("id"=>$this->row_db_1["contenido_id"], "nombre"=>$this->row_db_1["contenido_nombre"], "contenido"=>$this->row_db_1["contenido_contenido"], "orden"=>$this->row_db_1["contenido_orden"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"datos de item de antes de viajar obtenidos", "articuloList"=>$array_vuelos, "count"=>$x));
	}	
	// actualizar item antes de viajar
	public function updateViajar($nombre, $contenido, $orden, $id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$this->doConnect();		
		$this->rs->update("contenidos", "contenido_contenido = '{$contenido}', contenido_nombre = '{$nombre}', contenido_orden = '{$orden}' ", "  contenido_id = '{$id}'", $this->link);
		$query = "";
		$query = $this->rs->query;
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados", "query"=>$query));
	}	
	public function addViajar($nombre, $contenido, $orden){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $this->doConnect();
	    $this->rs->insert("contenidos", "contenido_contenido, contenido_nombre, contenido_orden, contenido_url, contenido_skip", "'{$contenido}','{$nombre}', '{$orden}', 'generic.php', '0'", $this->link);
	    $query = "";
	    $query = $this->rs->query;
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados", "query"=>$query));
	}
	// obtener dados de una declaracion (loop final) por id
	public function getDeclaracionLoopDataById($id){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_vitrina = array();
	    $this->doConnect();
	    $x = 0;
	    $status = "";
	    $this->rs_db_1 = $this->rs->select("idpasajero, telefono_movil, telefono_fijo, telefono_pais, telefono_ciudad, telefono_direccion", "info_direccion_emergencia", "idpasajero = {$id}", "", $this->link);
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_vitrina[] = array(
	            "idpasajero"=>$this->row_db_1["idpasajero"],
	            "telefono_movil"=>$this->row_db_1["telefono_movil"],
	            "telefono_fijo"=>$this->row_db_1["telefono_fijo"],
	            "telefono_pais"=>$this->row_db_1["telefono_pais"],
	            "telefono_ciudad"=>$this->row_db_1["telefono_ciudad"],
	            "telefono_direccion"=>$this->row_db_1["telefono_direccion"],
	        );
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de la declaracion loop obtenidos", "vitrinaList"=>$array_vitrina, "count"=>$x));
	}
	// obtener nombre de pais por su id
	public function getCountryNameById($id){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_paises = array();
	    $this->doConnect();
	    $x = 0;
	    $this->rs_db_1 = $this->rs->select("id, pais", "Paises", "id = {$id}", "", $this->link);
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_paises[] = array("id"=>$this->row_db_1["id"], "pais"=>$this->row_db_1["pais"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"pais obtenido", "data"=>$array_paises));
	}
	// obtener lista de contenidos
	public function getTiposContenidos(){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_contenido = array();
	    $this->doConnect();
	    $x = 0;
	    $query = "";
	    $this->rs_db_1 = $this->rs->select("contenido_id, contenido_nombre, contenido_orden", "contenidos", "contenido_skip = '1'", "", $this->link);
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_contenido[] = array("id"=>$this->row_db_1["contenido_id"], "nombre"=>$this->row_db_1["contenido_nombre"], "orden"=>$this->row_db_1["contenido_orden"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"item de contenido obtenidos", "data"=>$array_contenido, "count"=>$x));
	}
	// obtener lista de contenidos
	public function getContenidosDinamicos($id){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_contenido = array();
	    $this->doConnect();
	    $x = 0;
	    $query = "";
	    if ($id != ""){
	       $this->rs_db_1 = $this->rs->select("contenido_id, contenido_nombre, contenido_orden, contenido_contenido", "contenidos", "contenido_skip = '2' and contenido_id = ".$id, "", $this->link);
	    }else{
	       $this->rs_db_1 = $this->rs->select("contenido_id, contenido_nombre, contenido_orden, contenido_contenido", "contenidos", "contenido_skip = '2'", "", $this->link);
	    }
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_contenido[] = array("id"=>$this->row_db_1["contenido_id"], "nombre"=>$this->row_db_1["contenido_nombre"], "orden"=>$this->row_db_1["contenido_orden"], "contenido"=>$this->row_db_1["contenido_contenido"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"item de contenido obtenidos", "data"=>$array_contenido, "count"=>$x));
	}
	public function getContenidosById($id){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_contenido = array();
	    $this->doConnect();
	    $x = 0;
	    $query = "";
	    $this->rs_db_1 = $this->rs->select("contenido_id, contenido_nombre, contenido_contenido", "contenidos", "contenido_skip = '1' and contenido_id = ".$id, "", $this->link);
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_contenido[] = array("id"=>$this->row_db_1["contenido_id"], "nombre"=>$this->row_db_1["contenido_nombre"], "contenido"=>$this->row_db_1["contenido_contenido"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"item de contenido obtenidos", "data"=>$array_contenido, "count"=>$x));
	}
	public function updateContenidos($contenido, $nombre, $id){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $this->doConnect();
	    $this->rs->update("contenidos", "contenido_contenido = '{$contenido}', contenido_nombre = '{$nombre}'", " contenido_id = '{$id}'", $this->link);
	    $query = "";
	    $query = $this->rs->query;
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados", "query"=>$query));
	}	
	public function addContenidos($contenido, $nombre){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $this->doConnect();
	    $this->rs->insert("contenidos", "contenido_contenido, contenido_nombre, contenido_skip, contenido_url", "'{$contenido}','{$nombre}','1', 'generic.php'", $this->link);
	    $query = "";
	    $query = $this->rs->query;
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos actualizados", "query"=>$query));
	}
	public function getDeclaracionList(){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $arrayVitrinas = array();
	    $this->doConnect();
	    $x = 0;
	    $this->rs_db_1 = $this->rs->select("id, nombrepila, apellido, numeropasaporte", "dec_salud", "id > 0", "ORDER BY id DESC", $this->link);
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $arrayVitrinas[] = array("id"=>$this->row_db_1["id"], "nombres"=>$this->row_db_1["nombrepila"]." ".$this->row_db_1["apellido"], "pasaporte"=>$this->row_db_1["numeropasaporte"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"declaraciones obtenidas", "virinasList"=>$arrayVitrinas, "count"=>$x));
	}
	// obtener dados de una declaracion por id
	public function getDeclaracionById($id){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_vitrina = array();
	    $this->doConnect();
	    $x = 0;
	    $status = "";
	    $this->rs_db_1 = $this->rs->select("id, nombrepila, apellido, gender, fechanacimiento, nacionalidad, numeropasaporte, pais, callenro, ciudad, telefonocontacto, medio, lineaaerea, fechavuelo, numvuelo, nombrelugar, fechallegadapais, fechasalidapais, companiatransporte, primerpaisembarque, paistransitoantes, paisesvisitados30, fiebre, respiratoria, tos, cabeza, garganta, fatiga, secrecionnasal, escalofrios, dolormuscular, ninguno, otrossintomas, fechainiciosintomas, direccionestadia, firmauser", "dec_salud", "id = '".$id."'", "", $this->link);
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_vitrina[] = array(
	            "id"=>$this->row_db_1["id"],
	            "nombrepila"=>$this->row_db_1["nombrepila"],
	            "apellido"=>$this->row_db_1["apellido"],
	            "gender"=>$this->row_db_1["gender"],
	            "fechanacimiento"=>$this->row_db_1["fechanacimiento"],
	            "nacionalidad"=>$this->row_db_1["nacionalidad"],
	            "numeropasaporte"=>$this->row_db_1["numeropasaporte"],
	            "pais"=>$this->row_db_1["pais"],
	            "callenro"=>$this->row_db_1["callenro"],
	            "ciudad"=>$this->row_db_1["ciudad"],
	            "telefonocontacto"=>$this->row_db_1["telefonocontacto"],
	            "lineaaerea"=>$this->row_db_1["lineaaerea"],
	            "medio"=>$this->row_db_1["medio"],
	            "fechavuelo"=>$this->row_db_1["fechavuelo"],
	            "numvuelo"=>$this->row_db_1["numvuelo"],
	            "nombrelugar"=>$this->row_db_1["nombrelugar"],
	            "fechallegadapais"=>$this->row_db_1["fechallegadapais"],
	            "fechasalidapais"=>$this->row_db_1["fechasalidapais"],
	            "companiatransporte"=>$this->row_db_1["companiatransporte"],
	            "primerpaisembarque"=>$this->row_db_1["primerpaisembarque"],
	            "paistransitoantes"=>$this->row_db_1["paistransitoantes"],
	            "paisesvisitados30"=>$this->row_db_1["paisesvisitados30"],
	            "fiebre"=>$this->row_db_1["fiebre"],
	            "respiratoria"=>$this->row_db_1["respiratoria"],
	            "tos"=>$this->row_db_1["tos"],
	            "cabeza"=>$this->row_db_1["cabeza"],
	            "garganta"=>$this->row_db_1["garganta"],
	            "fatiga"=>$this->row_db_1["fatiga"],
	            "secrecionnasal"=>$this->row_db_1["secrecionnasal"],
	            "escalofrios"=>$this->row_db_1["escalofrios"],
	            "dolormuscular"=>$this->row_db_1["dolormuscular"],
	            "ninguno"=>$this->row_db_1["ninguno"],
	            "otrossintomas"=>$this->row_db_1["otrossintomas"],
	            "fechainiciosintomas"=>$this->row_db_1["fechainiciosintomas"],
	            "direccionestadia"=>$this->row_db_1["direccionestadia"],
	            "firmauser"=>$this->row_db_1["firmauser"]
	        );
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de la declaracion obtenidos", "vitrinaList"=>$array_vitrina, "count"=>$x));
	}
	
}
?>
