<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deleteVitrina($id);
?>	
<br>
<center>Se ha eliminado exitosamente la vitrina indicada<br><a href="?m=vitrina">Volver al listado de vitrinas.</a></center>