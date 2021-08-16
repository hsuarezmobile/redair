<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deleteViajar($id);
?>	
<br>
<center>Se ha eliminado exitosamente el item de antes de viajar indicado<br><a href="?m=viajar">Volver al listado de antes de viajar.</a></center>