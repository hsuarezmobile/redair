<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deleteContenido($id);
?>	
<br>
<center>Se ha eliminado exitosamente el item de experiencia red indicado<br><a href="?m=contenido">Volver al listado de experiencia RED.</a></center>