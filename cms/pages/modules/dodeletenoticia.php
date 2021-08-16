<?php
$id = $_GET["id"];
$json_data = array();
$json_data = $dataServ->deleteNoticia($id);
?>	
<br>
<center>Se ha eliminado exitosamente la noticia indicada<br><a href="?m=noticia">Volver al listado de noticias.</a></center>