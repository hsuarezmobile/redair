<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deleteArticuloNoIndemnizable($id);
?>	
<br>
<center>Se ha eliminado exitosamente el artìculo no indemnizable indicado<br><a href="?m=articulos">Volver al listado de artìculo no indemnizable.</a></center>