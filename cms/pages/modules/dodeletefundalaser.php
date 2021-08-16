<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deletefundalaser($id);
?>	
<br>
<center>Se ha eliminado exitosamente el item de fundalaser indicado<br><a href="?m=vitrina">Volver al listado de items de fundalaser.</a></center>er>