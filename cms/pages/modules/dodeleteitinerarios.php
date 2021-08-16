<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deletevuelos($id);
?>	
<br>
<center>Se ha eliminado exitosamente el itinerario de vuelo indicado<br><a href="?m=itinerarios">Volver al listado de itinerarios de vuelo.</a></center>