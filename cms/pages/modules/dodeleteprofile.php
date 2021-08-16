<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deleteProfile($id);
?>	
<br>
<center>Se ha eliminado exitosamente el perfil de usuario indicado<br><a href="?m=settings">Volver al listado de perfil de usuarios.</a></center>