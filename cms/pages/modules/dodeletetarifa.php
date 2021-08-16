<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deleteTarifa($id);
?>	
<br>
<center>Se ha eliminado exitosamente la vitrina indicada<br><a href="?m=tarifa">Volver al listado de tarifas.</a></center>