<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deleteEntry($id);
?>	
<br>
<center>Se ha eliminado exitosamente la entrada del blog indicada<br><a href="?m=blog">Volver al listado de entradas del blog.</a></center>