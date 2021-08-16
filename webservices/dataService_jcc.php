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
 		$this->link = $this->dbconn->conectarse("localhost:8080", "laserdev", "*Jmr-ze=Jx*z4yk");
 		$this->dbconn->seleccionar_db("laserweb", $this->link);
 	//	$this->link = $this->dbconn->conectarse("localhost", "root", "");
 	//	$this->dbconn->seleccionar_db("laser", $this->link);		
	}
	private function doDisconnect(){
		$this->dbconn->desconectarse($this->link);
		unset($this->rs);
		unset($this->dbconn);		
	}
	public function getActiveVitrinas(){
	    $arrayVitrinas = array();
	    $this->doConnect();
	    $this->rs_db_1 = $this->rs->select("vitrina_id, vitrina_nombre, vitrina_img", "vitrinas", "vitrina_activo = 'S'", "ORDER BY vitrina_orden ASC");
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
	    $this->rs_db_1 = $this->rs->select("tarifa_id, tarifa_nombre, tarifa_destino, tarifa_monto, tarifa_img, tarifa_orden, tarifa_activo", "tarifas", "tarifa_id > 0", "ORDER BY tarifa_orden ASC");
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
		$this->rs_db_1 = $this->rs->select("noticia_id, noticia_titulo, noticia_contenido, noticia_img, noticia_fecha, noticia_activo", "noticias", "noticia_id > 0", "ORDER BY noticia_fecha DESC");
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_noticia[] = array("id"=>$this->row_db_1["noticia_id"], "titulo"=>$this->row_db_1["noticia_titulo"], "contenido"=>$this->row_db_1["noticia_contenido"], "img"=>$this->row_db_1["noticia_img"], "fecha"=>$this->row_db_1["noticia_fecha"], "activo"=>$this->row_db_1["noticia_activo"]);
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
		$this->rs_db_1 = $this->rs->select("equipajetar_id, equipajetar_desc, equipajetar_mia, equipajetar_sdq, equipajetar_pty, equipajetar_cur, equipajetar_aua, equipajetar_gye, equipajetar_orden, equipajetar_activo", "equipaje_tarifa", "equipajetar_activo = 'S'", "ORDER BY equipajetar_orden ASC");
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
		$this->rs_db_1 = $this->rs->select("equipajedes_id, equipajedes_desc1, equipajedes_desc2, equipajedes_activo, equipajedes_orden", "equipaje_descripcion", "equipajedes_activo = 'S'", "ORDER BY equipajedes_orden ASC");
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
	    $this->rs_db_1 = $this->rs->select("tarifacar_id, tarifacar_tipomercancia, tarifacar_peso, tarifacar_montoves, tarifacar_miscelaneo, tarifacar_conexion, tarifacar_orden, tarifacar_activo", "tarifa_carga", "tarifacar_activo = 'S'", "ORDER BY tarifacar_orden ASC");
		while ($this->row_db_1 = $this->rs->fetch($this->rs_db_1)){
			$array_tarcarga[] = array("id"=>$this->row_db_1["tarifacar_id"], "tipo"=>$this->row_db_1["tarifacar_tipomercancia"], "peso"=>$this->row_db_1["tarifacar_peso"], "montoves"=>$this->row_db_1["tarifacar_montoves"], "miscelaneo"=>$this->row_db_1["tarifacar_miscelaneo"], "conexion"=>$this->row_db_1["tarifacar_conexion"], "orden"=>$this->row_db_1["tarifacar_orden"], "activo"=>$this->row_db_1["tarifacar_activo"]);
			$x++;
		}
		$this->doDisconnect();
		return json_encode(array("result"=>true, "response"=>"OK", "message"=>"descripcion de tarifas de carga obtenidas", "data"=>$array_tarcarga, "count"=>$x));
	}	
}
?>