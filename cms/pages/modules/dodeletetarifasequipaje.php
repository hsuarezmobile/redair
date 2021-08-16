<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deleteTarifaEquipaje($id);
?>	
<br>
<center>Se ha eliminado exitosamente la tarifa de equipaje indicada<br><a href="?m=tarifasequipaje">Volver al listado de tarifas de equipaje.</a></center>