<?php
//header('Content-Type: text/html; charset=UTF-8');
// ****************************************
// proyect: laser website
// version: 1.0a
// date: 26-06-2019
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
 		//$this->link = $this->dbconn->conectarse("localhost", "root", "");
 		//$this->dbconn->seleccionar_db("laser", $this->link);		
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
		$uid = "";
		$nombres = "";
		$apellidos = "";
		//--> ciframos el password
		$cifrado=strtolower(substr(base64_encode($password), 0, 3)."*".substr(md5($password), 0, 3));		
		$this->rs_db_1 = $this->rs->select("usuario_id, usuario_nombres, usuario_apellidos", "usuarios", "usuario_email = '".$username."' and usuario_pwd = '".$cifrado."' and usuario_activo = 'S'", "", $this->link);
		if ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$uid = $this->row_db_1["usuario_id"];
			$nombres = ucfirst(strtolower($this->row_db_1["usuario_nombres"]));
			$apellidos = ucfirst(strtolower($this->row_db_1["usuario_apellidos"]));
			$loginSuccess = true;
		}		
		$this->doDisconnect();
		if ($loginSuccess){
			return json_encode(array("result"=>true, "response"=>"OK", "uid"=>$uid, "nombres"=>$nombres, "apellidos"=>$apellidos, "message"=>"Inicio de sesion exitoso"));			
		}else{
			return json_encode(array("result"=>false, "response"=>"ERROR", "uid"=>$uid, "message"=>"Nombre de usuario o contraseña incorrecta"));
		}
	}	
	public function getActiveVitrinas(){
	    $arrayVitrinas = array();
	    $this->doConnect();
	    $this->rs_db_1 = $this->rs->select("vitrina_id, vitrina_nombre, vitrina_img", "vitrinas", "vitrina_activo = 'S'", "ORDER BY vitrina_orden ASC", $this->link);
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $arrayVitrinas[] = array("id"=>$this->row_db_1["vitrina_id"], "nombre"=>$this->row_db_1["vitrina_nombre"], "img"=>$this->row_db_1["vitrina_img"]);
	    }	    
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "data"=>$arrayVitrinas));
	}
	// obtener datos de tarifas
	public function getTarifaList(){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_tarifa = array();
	    $this->doConnect();
	    $x = 0;
	    $this->rs_db_1 = $this->rs->select("tarifa_id, tarifa_nombre, tarifa_destino, tarifa_monto, tarifa_img, tarifa_orden, tarifa_activo", "tarifas", "tarifa_id > 0", "ORDER BY tarifa_orden ASC", $this->link);
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_tarifa[] = array("id"=>$this->row_db_1["tarifa_id"], "nombre"=>$this->row_db_1["tarifa_nombre"], "destino"=>$this->row_db_1["tarifa_destino"], "monto"=>$this->row_db_1["tarifa_monto"], "img"=>$this->row_db_1["tarifa_img"], "orden"=>$this->row_db_1["tarifa_orden"], "activo"=>$this->row_db_1["tarifa_activo"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"tarifas obtenidas", "data"=>$array_tarifa, "count"=>$x));
	}
	// obtener datos de noticias
	public function getNewsList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_noticia = array();
		$this->doConnect();
		$x = 0;
		$this->rs_db_1 = $this->rs->select("noticia_id, noticia_titulo, noticia_contenido, noticia_img, noticia_img2, noticia_fecha, noticia_activo", "noticias", "noticia_id > 0", "ORDER BY noticia_fecha DESC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
		    $array_noticia[] = array("id"=>$this->row_db_1["noticia_id"], "titulo"=>$this->row_db_1["noticia_titulo"], "contenido"=>$this->row_db_1["noticia_contenido"], "img"=>$this->row_db_1["noticia_img"], "img2"=>$this->row_db_1["noticia_img2"], "fecha"=>$this->row_db_1["noticia_fecha"], "activo"=>$this->row_db_1["noticia_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"noticias obtenidas", "data"=>$array_noticia, "count"=>$x));
	}
	
	// obtener tarifas de equipaje
	public function getTarifasEquipajeList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_tarequip = array();
		$this->doConnect();
		$x = 0;
		$this->rs_db_1 = $this->rs->select("equipajetar_id, equipajetar_desc, equipajetar_mia, equipajetar_sdq, equipajetar_pty, equipajetar_cur, equipajetar_aua, equipajetar_gye, equipajetar_orden, equipajetar_activo", "equipaje_tarifa", "equipajetar_activo = 'S'", "ORDER BY equipajetar_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_tarequip[] = array("id"=>$this->row_db_1["equipajetar_id"], "desc"=>$this->row_db_1["equipajetar_desc"], "mia"=>$this->row_db_1["equipajetar_mia"], "sdq"=>$this->row_db_1["equipajetar_sdq"], "pty"=>$this->row_db_1["equipajetar_pty"], "cur"=>$this->row_db_1["equipajetar_cur"], "aua"=>$this->row_db_1["equipajetar_aua"], "gye"=>$this->row_db_1["equipajetar_gye"], "orden"=>$this->row_db_1["equipajetar_orden"], "activo"=>$this->row_db_1["equipajetar_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"tarifas de equipaje obtenidas", "data"=>$array_tarequip, "count"=>$x));
	}
	// obtener descripcion de equipaje
	public function getTarifasDescList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_tarequipdesc = array();
		$this->doConnect();
		$x = 0;
		$this->rs_db_1 = $this->rs->select("equipajedes_id, equipajedes_desc1, equipajedes_desc2, equipajedes_activo, equipajedes_orden", "equipaje_descripcion", "equipajedes_activo = 'S'", "ORDER BY equipajedes_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_tarequipdesc[] = array("id"=>$this->row_db_1["equipajedes_id"], "desc1"=>$this->row_db_1["equipajedes_desc1"], "desc2"=>$this->row_db_1["equipajedes_desc2"], "activo"=>$this->row_db_1["equipajedes_activo"], "orden"=>$this->row_db_1["equipajedes_orden"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"descripcion de tarifas de equipaje obtenidas", "data"=>$array_tarequipdesc, "count"=>$x));
	}
	// obtener tarifas de carga
	public function getTarifasCargaList(){
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
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"descripcion de tarifas de carga obtenidas", "data"=>$array_tarcarga, "count"=>$x));
	}	
	// obtener fundalaser
	public function getFundaLaserList(){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_fundalaser = array();
		$this->doConnect();
		$x = 0;
	    $this->rs_db_1 = $this->rs->select("fundalaser_id, fundalaser_nombre, fundalaser_img, fundalaser_orden, fundalaser_activo", "fundalaser_logos", "fundalaser_activo = 'S'", "ORDER BY fundalaser_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_fundalaser[] = array("id"=>$this->row_db_1["fundalaser_id"], "nombre"=>$this->row_db_1["fundalaser_nombre"], "img"=>$this->row_db_1["fundalaser_img"], "orden"=>$this->row_db_1["fundalaser_orden"], "activo"=>$this->row_db_1["fundalaser_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"items de fundalaser obtenidos", "data"=>$array_fundalaser, "count"=>$x));
	}	
	// obtener vuelos
	public function getVuelosList($tipo){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_vuelos = array();
		$this->doConnect();
		$x = 0;
	    $this->rs_db_1 = $this->rs->select("itinerario_id, itinerario_vuelo, itinerario_salida, itinerario_destino, itinerario_llegada, itinerario_frecuencia, itinerario_tipo, itinerario_orden, itinerario_activo", "itinerarios", "itinerario_activo = 'S' AND itinerario_tipo = ".$tipo, "ORDER BY itinerario_orden ASC", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_vuelos[] = array("id"=>$this->row_db_1["itinerario_id"], "vuelo"=>$this->row_db_1["itinerario_vuelo"], "salida"=>$this->row_db_1["itinerario_salida"], "destino"=>$this->row_db_1["itinerario_destino"], "llegada"=>$this->row_db_1["itinerario_llegada"], "frecuencia"=>$this->row_db_1["itinerario_frecuencia"], "tipo"=>$this->row_db_1["itinerario_tipo"], "orden"=>$this->row_db_1["itinerario_orden"], "activo"=>$this->row_db_1["itinerario_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"items de vuelos obtenidos", "data"=>$array_vuelos, "count"=>$x));
	}	
	// obtener datos de una tarifa por id
	public function getNoticiaById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_noticia = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("noticia_id, noticia_titulo, noticia_contenido, noticia_img, noticia_fecha, noticia_activo", "noticias", "noticia_id = '{$id}'", "", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			if ($this->row_db_1["noticia_activo"] == "S"){
				$status = "Activo";
			}else{
				$status = "Inactivo";
			}
			$array_noticia[] = array("id"=>$this->row_db_1["noticia_id"], "titulo"=>$this->row_db_1["noticia_titulo"], "contenido"=>$this->row_db_1["noticia_contenido"], "img"=>$this->row_db_1["noticia_img"], "fecha"=>$this->row_db_1["noticia_fecha"], "activo"=>$this->row_db_1["noticia_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos de la noticia obtenidos", "noticiaList"=>$array_noticia, "count"=>$x));
	}
	// guardar registro
	public function saveLaserUser($firstname, $lastname, $birthday, $birthmonth, $birthyear, $country, $emailreg, $pwdreg, $telefono, $celular, $acceptinfo, $acceptoffers){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_response = array();
		$this->doConnect();
		$cifrado = "";
		$cifrado=strtolower(substr(base64_encode($pwdreg), 0, 3)."*".substr(md5($pwdreg), 0, 3));
		$this->rs_db_1 = $this->rs->select("usuario_id", "usuarios", "usuario_email = '{$emailreg}'", "", $this->link);
		if (!$this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$this->rs->insert("usuarios", "usuario_nombres, usuario_apellidos, usuario_dianac, usuario_mesnac, usuario_anonac, usuario_nacionalidad, usuario_email, usuario_pwd, usuario_tlf, usuario_cel, usuario_accept1, usuario_accept2", "'{$firstname}', '{$lastname}','{$birthday}','{$birthmonth}','{$birthyear}','{$country}','{$emailreg}','{$cifrado}','{$telefono}','{$celular}','{$acceptinfo}','{$acceptoffers}'", $this->link);	
			$array_response = array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados");
		}else{
			$array_response = array("result"=>false, "response"=>"ERROR", "message"=>"Error, ya existe un usuario con el correo electrónico indicado.");
		}		
		$this->doDisconnect();
		return json_encode($array_response);
	}
	// actualizar registro
	public function updateLaserUser($firstname, $lastname, $birthday, $birthmonth, $birthyear, $country, $emailreg, $telefono, $celular, $acceptinfo, $acceptoffers, $id){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_response = array();
	    $this->doConnect();
	    $cifrado = "";
	    $cifrado=strtolower(substr(base64_encode($pwdreg), 0, 3)."*".substr(md5($pwdreg), 0, 3));
        $this->rs->update("usuarios", "usuario_nombres = '{$firstname}', usuario_apellidos = '{$lastname}', usuario_dianac = '{$birthday}', usuario_mesnac = '{$birthmonth}', usuario_anonac = '{$birthyear}', usuario_nacionalidad = '{$country}', usuario_email = '{$emailreg}', usuario_tlf = '{$telefono}', usuario_cel = '{$celular}', usuario_accept1 = '{$acceptinfo}', usuario_accept2 = '{$acceptoffers}'", "usuario_id = '{$id}'", $this->link);
        $array_response = array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados");
	    $this->doDisconnect();
	    return json_encode($array_response);
	}
	// obtener datos de un usuario por id
	public function getUserById($id){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_datausuario = array();
	    $this->doConnect();
	    $x = 0;
	    $status = "";
	    $this->rs_db_1 = $this->rs->select("usuario_id, usuario_nombres, usuario_apellidos, usuario_dianac, usuario_mesnac, usuario_anonac, usuario_nacionalidad, usuario_email, usuario_pwd, usuario_tlf, usuario_cel, usuario_accept1, usuario_accept2", "usuarios", "usuario_id = '{$id}'", "", $this->link);
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_datausuario[] = array("id"=>$this->row_db_1["usuario_id"], "nombres"=>$this->row_db_1["usuario_nombres"], "apellidos"=>$this->row_db_1["usuario_apellidos"], "dianac"=>$this->row_db_1["usuario_dianac"], "mesnac"=>$this->row_db_1["usuario_mesnac"], "anonac"=>$this->row_db_1["usuario_anonac"], "nacionalidad"=>$this->row_db_1["usuario_nacionalidad"], "email"=>$this->row_db_1["usuario_email"], "telefono"=>$this->row_db_1["usuario_tlf"], "celular"=>$this->row_db_1["usuario_cel"], "accept1"=>$this->row_db_1["usuario_accept1"], "accept2"=>$this->row_db_1["usuario_accept2"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Datos del usuario obtenidos", "data"=>$array_datausuario, "count"=>$x));
	}
	// obtener paises
	public function getCountriesList(){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_paises = array();
	    $this->doConnect();
	    $x = 0;
	    $this->rs_db_1 = $this->rs->select("id, pais", "Paises", "id != 0", "ORDER BY pais ASC", $this->link);
	    $this->row_db_1 = $this->rs->fetch($this->rs_db_1);        
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_paises[] = array("id"=>$this->row_db_1["id"], "pais"=>$this->row_db_1["pais"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Lista de paises obtenida", "data"=>$array_paises, "count"=>$x));
	}	
	// verificar email en la db
	public function checkEmailAddress($email){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $this->doConnect();
		$finded = false;
		$response_array = array();
	    $this->rs_db_1 = $this->rs->select("usuario_id", "usuarios", "usuario_email = '{$email}'", "", $this->link);
	    if ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $finded = true;
	    }
		if ($finded){
			$response_array = json_encode(array("result"=>true, "response"=>"OK", "message"=>"Correo encontrado", "id"=>$usuario_id));	
		}else{
			$response_array = json_encode(array("result"=>false, "response"=>"ERROR", "message"=>"Correo no encontrado", "id"=>""));			
		}		
	    $this->doDisconnect();
	    return $response_array;
	}
	// cambiar contraseña...
	public function updatePwd($email, $pwd){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $this->doConnect();
		$finded = false;
		$response_array = array();
	    $cifrado = "";
	    $cifrado=strtolower(substr(base64_encode($pwd), 0, 3)."*".substr(md5($pwd), 0, 3));		
	    $this->rs->update("usuarios", "usuario_pwd = '{$cifrado}'", "usuario_email = '{$email}'", $this->link);
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"contraseña modificada"));	
	}	
	// obtener secciones antes de viajar por id
	public function getViajarById($id){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_vuelos = array();
		$this->doConnect();
		$status = "";
		$this->rs_db_1 = $this->rs->select("contenido_id, contenido_nombre, contenido_contenido", "contenidos", "contenido_id = ".$id, "", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_vuelos[] = array("id"=>$this->row_db_1["contenido_id"], "nombre"=>$this->row_db_1["contenido_nombre"], "contenido"=>$this->row_db_1["contenido_contenido"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"datos de item de antes de viajar obtenidos", "articuloList"=>$array_vuelos, "count"=>$x));
	}	
	public function renderfranquiciatabla1(){
		$buffer = "";		
		$json_tarifasequip = array();
		$json_tarifasequip = json_decode($this->getTarifasEquipajeList());
		for ($x = 0; $x < sizeof($json_tarifasequip->data); $x++){
			$buffer.= "<tr><td>".$json_tarifasequip->data[$x]->desc."</td><td>".$json_tarifasequip->data[$x]->mia."</td><td>".$json_tarifasequip->data[$x]->sdq."</td><td>".$json_tarifasequip->data[$x]->pty."</td><td>".$json_tarifasequip->data[$x]->cur."</td><td>".$json_tarifasequip->data[$x]->aua."</td><td>".$json_tarifasequip->data[$x]->gye."</td></tr>";
		}
		return $buffer;
	}	
	public function renderfranquiciatabla2(){
		$buffer = "";		
		$json_tarifasdesc = array();
		$json_tarifasdesc = json_decode($this->getTarifasDescList());
		for ($x = 0; $x < sizeof($json_tarifasdesc->data); $x++){
			$buffer.= "<tr><td>".$json_tarifasdesc->data[$x]->desc1."</td><td>".$json_tarifasdesc->data[$x]->desc2."</td></tr>";
		}
		return $buffer;
	}	
	public function renderitinerariotabla1(){
		$buffer = "";		
		$json_vuelosnac = array();
		$json_vuelosnac = json_decode($this->getVuelosList(0));
		for ($x = 0; $x < sizeof($json_vuelosnac->data); $x++){
			$buffer.= "<tr><td>".$json_vuelosnac->data[$x]->vuelo."</td><td>".$json_vuelosnac->data[$x]->salida."</td><td>".$json_vuelosnac->data[$x]->destino."</td><td>".$json_vuelosnac->data[$x]->llegada."</td><td>".$json_vuelosnac->data[$x]->frecuencia."</td></tr>";
		}
		return $buffer;
	}	
	public function renderitinerariotabla2(){
		$buffer = "";		
		$json_vuelosint = array();
		$json_vuelosint = json_decode($this->getVuelosList(1));
		for ($x = 0; $x < sizeof($json_vuelosint->data); $x++){
			$buffer.= "<tr><td>".$json_vuelosint->data[$x]->vuelo."</td><td>".$json_vuelosint->data[$x]->salida."</td><td>".$json_vuelosint->data[$x]->destino."</td><td>".$json_vuelosint->data[$x]->llegada."</td><td>".$json_vuelosint->data[$x]->frecuencia."</td></tr>";
		}
		return $buffer;
	}
	public function doFind($data){
		$this->rs_db_1 = null;
		$this->row_db_1 = null;
		$array_data = array();
		$this->doConnect();
		$x = 0;
		$status = "";
		$this->rs_db_1 = $this->rs->select("contenido_id, contenido_nombre, contenido_contenido, contenido_url", "contenidos", "contenido_contenido like '%{$data}%'", "", $this->link);
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_data[] = array("id"=>$this->row_db_1["contenido_id"], "nombre"=>$this->row_db_1["contenido_nombre"], "contenido"=>substr(strip_tags(str_replace("'", "", str_replace("&nbsp;", "", str_replace("\r", "", str_replace("\n", "", $this->row_db_1["contenido_contenido"]))))), 0, 255)."...", "url"=>$this->row_db_1["contenido_url"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"resultados de la busqueda obtenidos", "articuloList"=>$array_data, "count"=>$x));
	}
	// guardar registro
	public function saveJurada($param){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_response = array();
	    $array_param = array();
        /*	    
            1 $nombrepila = $_POST["nombrepila"];
            2 $apellido = $_POST["apellido"];
            3 $gender = $_POST["gender"];
            4 $fechanacimiento = $_POST["fechanacimiento"];
            5 $nacionalidad = $_POST["nacionalidad"];
            6 $numeropasaporte = $_POST["numeropasaporte"];
            7 $pais = $_POST["pais"];
            8 $callenro = $_POST["callenro"];
            9 $ciudad = $_POST["ciudad"];
            10 $telefonocontacto = $_POST["telefonocontacto"];
            11 $lineaaerea = $_POST["lineaaerea"];
            12 $fechavuelo = $_POST["fechavuelo"];
            13 $numvuelo = $_POST["numvuelo"];
            14 $nombrelugar = $_POST["nombrelugar"];
            15 $fechallegadapais = $_POST["fechallegadapais"];
            16 $fechasalidapais = $_POST["fechasalidapais"];
            17 $companiatransporte = $_POST["companiatransporte"];
            18 $primerpaisembarque = $_POST["primerpaisembarque"];
            19 $paistransitoantes = $_POST["paistransitoantes"];
            20 $paisesvisitados30 = $_POST["paisesvisitados30"];
            21 $fiebre = $_POST["fiebre"];
            22 $respiratoria = $_POST["respiratoria"];
            23 $tos = $_POST["tos"];
            24 $cabeza = $_POST["cabeza"];
            25 $garganta = $_POST["garganta"];
            26 $fatiga = $_POST["fatiga"];
            27 $secrecionnasal = $_POST["secrecionnasal"];
            28 $escalofrios = $_POST["escalofrios"];
            29 $dolormuscular = $_POST["dolormuscular"];
            30 $ninguno = $_POST["ninguno"];
            31 $otrossintomas = $_POST["otrossintomas"];
            32 $fechainiciosintomas = $_POST["fechainiciosintomas"];
            33 $direccionestadia = $_POST["direccionestadia"];	  
        */	    	    
	    $array_param = explode(";", $param);
	    $error = true;
	    $this->doConnect();
        
	    $this->rs_db_1 = $this->rs->select("ID", "declaraciones", "pasaporte='".$numeropasaporte."'", "", $this->link);
	    if (!$this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
            $this->rs->insert("declaraciones",
                "nombrepila,
                apellido,
                gender,
                fechanacimiento,
                nacionalidad,
                numeropasaporte,
                pais,
                callenro,
                ciudad,
                telefonocontacto,
                lineaaerea,
                fechavuelo,
                numvuelo,
                nombrelugar,
                fechallegadapais,
                fechasalidapais,
                companiatransporte,
                primerpaisembarque,
                paistransitoantes,
                paisesvisitados30,
                fiebre,
                respiratoria,
                tos,
                cabeza,
                garganta,
                fatiga,
                secrecionnasal,
                escalofrios,
                dolormuscular,
                ninguno,
                otrossintomas,
                fechainiciosintomas,
                direccionestadia
                ",
                "'".$array_param[0]."','".
                $array_param[1]."','".
                $array_param[2]."','".
                $array_param[3]."','".
                $array_param[4]."','".
                $array_param[5]."','".
                $array_param[6]."','".
                $array_param[7]."','".
                $array_param[8]."','".
                $array_param[9]."','".
                $array_param[10]."','".
                $array_param[11]."','".
                $array_param[12]."','".
                $array_param[13]."','".
                $array_param[14]."','".
                $array_param[15]."','".
                $array_param[16]."','".
                $array_param[17]."','".
                $array_param[18]."','".
                $array_param[19]."','".
                $array_param[20]."','".
                $array_param[21]."','".
                $array_param[22]."','".
                $array_param[23]."','".
                $array_param[24]."','".
                $array_param[25]."','".
                $array_param[26]."','".
                $array_param[27]."','".
                $array_param[28]."','".
                $array_param[29]."','".
                $array_param[30]."','".
                $array_param[31]."','".
                $array_param[32]."'", $this->link);
                $error = false;
                $query = $this->rs->query;
	    }
        if ($error){
            $array_response = array("result"=>false, "response"=>"ERROR", "message"=>"Error almacenando datos", "query"=>$query);	        
	    }else{
	        $array_response = array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados", "query"=>$query);
	    }
	    $this->doDisconnect();
	    return json_encode($array_response);
	}
	public function getContents(){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_paises = array();
	    $this->doConnect();
	    $x = 0;
	    $this->rs_db_1 = $this->rs->select("contenido_id, contenido_nombre", "contenidos", "contenido_skip = 0", "ORDER BY contenido_orden ASC", $this->link);
	    $this->row_db_1 = $this->rs->fetch($this->rs_db_1);
	    $query = "";
	    $query = $this->rs->query;
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_paises[] = array("id"=>$this->row_db_1["contenido_id"], "nombre"=>$this->row_db_1["contenido_nombre"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Lista de contenidos obtenida", "data"=>$array_paises, "count"=>$x, "query"=>$query));
	}
	public function getContentsRED(){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_paises = array();
	    $this->doConnect();
	    $x = 0;
	    $this->rs_db_1 = $this->rs->select("contenido_id, contenido_nombre, contenido_url", "contenidos", "contenido_skip = '1'", "ORDER BY contenido_orden ASC", $this->link);
	    $this->row_db_1 = $this->rs->fetch($this->rs_db_1);
	    $query = "";
	    $query = $this->rs->query;
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_paises[] = array("id"=>$this->row_db_1["contenido_id"], "nombre"=>$this->row_db_1["contenido_nombre"], "url"=>$this->row_db_1["contenido_url"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Lista de contenidos obtenida", "data"=>$array_paises, "count"=>$x, "query"=>$query));
	}
	// guardar registro
	public function saveJuradaNew($nombrepila,$apellido,$gender,$fechanacimiento,$nacionalidad,$numeropasaporte,$pais,$callenro,$ciudad,$telefonocontacto,$medio,$lineaaerea,$fechavuelo,$numvuelo,$nombrelugar,$fechallegadapais,$fechasalidapais,$companiatransporte,$primerpaisembarque,$paistransitoantes,$paisesvisitados30,$fiebre,$respiratoria,$tos,$cabeza,$garganta,$fatiga,$secrecionnasal,$escalofrios,$dolormuscular,$ninguno,$otrossintomas,$fechainiciosintomas,$direccionestadia,$firmauser){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_response = array();
	    $array_param = array();
	    $array_param = explode(";", $param);
	    $error = true;
	    $this->doConnect();
	    
	    $this->rs_db_1 = $this->rs->select("id", "dec_salud", "numeropasaporte='".$numeropasaporte."'", "", $this->link);
	    if (!$this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $this->rs->insert("dec_salud",
	            "nombrepila,
                apellido,
                gender,
                fechanacimiento,
                nacionalidad,
                numeropasaporte,
                pais,
                callenro,
                ciudad,
                telefonocontacto,
				medio,
                lineaaerea,
                fechavuelo,
                numvuelo,
                nombrelugar,
                fechallegadapais,
                fechasalidapais,
                companiatransporte,
                primerpaisembarque,
                paistransitoantes,
                paisesvisitados30,
                fiebre,
                respiratoria,
                tos,
                cabeza,
                garganta,
                fatiga,
                secrecionnasal,
                escalofrios,
                dolormuscular,
                ninguno,
                otrossintomas,
                fechainiciosintomas,
                direccionestadia,
                firmauser
                ",
	            "'".$nombrepila."','".
	            $apellido."','".
	            $gender."','".
	            $fechanacimiento."','".
	            $nacionalidad."','".
	            $numeropasaporte."','".
	            $pais."','".
	            $callenro."','".
	            $ciudad."','".
	            $telefonocontacto."','".
	            $medio."','".
	            $lineaaerea."','".
	            $fechavuelo."','".
	            $numvuelo."','".
	            $nombrelugar."','".
	            $fechallegadapais."','".
	            $fechasalidapais."','".
	            $companiatransporte."','".
	            $primerpaisembarque."','".
	            $paistransitoantes."','".
	            $paisesvisitados30."','".
	            $fiebre."','".
	            $respiratoria."','".
	            $tos."','".
	            $cabeza."','".
	            $garganta."','".
	            $fatiga."','".
	            $secrecionnasal."','".
	            $escalofrios."','".
	            $dolormuscular."','".
	            $ninguno."','".
	            $otrossintomas."','".
	            $fechainiciosintomas."','".
	            $direccionestadia."','".
	            $firmauser."'", $this->link);
	        $error = false;
	        $query = $this->rs->query;
	    }
	    if ($error){
	        $array_response = array("result"=>false, "response"=>"ERROR", "message"=>"Error almacenando datos", "query"=>$query);
	    }else{
	        $array_response = array("result"=>true, "response"=>"OK", "message"=>"Datos almacenados", "query"=>$query);
	    }
	    $this->doDisconnect();
	    return json_encode($array_response);
	}
	public function getContentsByType($type){
	    $this->rs_db_1 = null;
	    $this->row_db_1 = null;
	    $array_contents = array();
	    $this->doConnect();
	    $x = 0;
	    $this->rs_db_1 = $this->rs->select("contenido_id, contenido_nombre", "contenidos", "contenido_skip = $type", "ORDER BY contenido_orden ASC", $this->link);
	    $query = "";
	    $query = $this->rs->query;
	    while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
	        $array_contents[] = array("id"=>$this->row_db_1["contenido_id"], "nombre"=>$this->row_db_1["contenido_nombre"]);
	        $x++;
	    }
	    $this->doDisconnect();
	    return json_encode(array("result"=>true, "response"=>"OK", "message"=>"Lista de contenidos obtenida", "data"=>$array_contents, "count"=>$x, "query"=>$query));
	}
}
?>
