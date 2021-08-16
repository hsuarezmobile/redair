<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deleteServiciosCarga($id);
?>	
<br>
<center>Se ha eliminado exitosamente el servicio de carga indicado<br><a href="?m=servicioscarga">Volver al listado de servicios de carga.</a></center>