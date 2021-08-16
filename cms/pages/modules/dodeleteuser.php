<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deleteUser($id);
?>	
<br>
<center>Se ha eliminado exitosamente el usuario indicado<br><a href="?m=settings">Volver al listado de usuarios.</a></center>