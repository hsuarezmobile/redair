<?php 
	$x = 0;
	$id = $_GET["id"];
	$json_data = array();
	$json_data = json_decode($dataServ->getNoticiaById($id));
?>
<script>
function validate() {
    let files = new FormData(), // you can consider this as 'data bag'
    url = 'modules/noticia_action.php';
	if (document.getElementById("titulo").value == ""){
		showErrorMessage("Disculpe, debe indicar el titulo de la noticia");
	}else if (document.getElementById("fecha").value == ""){
		showErrorMessage("Disculpe, debe indicar la fecha de la noticia");
	}else{	  
		var formData = new FormData();
		formData.append('archivo', $('#archivo')[0].files[0]);
		formData.append('archivo2', $('#archivo2')[0].files[0]);
		formData.append('fecha', document.getElementById("fecha").value);
		formData.append('titulo', document.getElementById("titulo").value);
		formData.append('description', tinymce.get('desc').getContent());
		formData.append('activo', document.getElementById("activo").value);
		formData.append('id', document.getElementById("id").value);
		$.ajax({
		   url : 'modules/noticia_action.php',
		   type : 'POST',
		   data : formData,
		   processData: false,
		   contentType: false,
		   success : function(datax) {
				var myObj = JSON.parse(datax);
				if (myObj.response == "OK"){
					wheretogo = "main.php?m=noticia";
					showSuccessMessage();
				}else{
					showErrorMessage("Disculpe, ha ocurrido un error almacenando los datos de la noticia");
				}												  
		   }
		});
	}
}	
</script>
<?php 
	$currdate = date('Y-m-d').' '.date('h:m:s');
?>

<br>          <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Editar Noticia</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=noticia';">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" action="javascript:validate();" method="post">
										<div class="form-group" style="display:none;">
											<input id="id" class="form-control"  value="<?php echo $id ?>">
										</div>
                                        <div class="form-group">
                                            <label>Titulo de la noticia</label>
                                            <input id="titulo" class="form-control" placeholder="Ingrese nombre de la noticia" value="<?php echo $json_data->noticiaList[0]->titulo ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Fecha</label>
                                            <input id="fecha" class="form-control" placeholder="Ingrese fecha de creación de la noticia" value="<?php echo $json_data->noticiaList[0]->fecha ?>">
                                        </div>	
                                        <div class="form-group">																											                                        
                                            <label>Contenido</label>
                                            <textarea id="desc" name="desc" class="form-control" rows="3" placeholder="Ingrese contenido de la noticia"><?php echo $json_data->noticiaList[0]->contenido ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Imagen pequeña actual</label>
                                            <a href="../../../assets/img/noticias/<?php echo $json_data->noticiaList[0]->img2 ?>" target="blank">Haga click aca para ver la imagen actual</a>
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Imagen pequeña</label>
                                            <input id="archivo2" type="file"> Ancho = 265px x Alto = 225px, formato JPG peso menor de 1 mb
                                        </div>                                                         
                                        <div class="form-group">
                                            <label>Imagen grande actual</label>
                                            <a href="../../../assets/img/noticias/<?php echo $json_data->noticiaList[0]->img ?>" target="blank">Haga click aca para ver la imagen actual</a>
                                        </div>                                         
                                        <div class="form-group">
                                            <label>Imagen grande</label>
                                            <input id="archivo" type="file"> Ancho = 1124px x Alto = 400px, formato JPG peso menor de 1 mb
                                        </div>        
                                        <div class="form-group">
                                            <label>Estado de la noticia</label>
                                            <select id="activo" class="form-control">
                                                <option value="S" <?php if ($json_data->noticiaList[0]->activo == "S"){ ?>selected<?php } ?>>Activo</option>
                                                <option value="N" <?php if ($json_data->noticiaList[0]->activo == "N"){ ?>selected<?php } ?>>Inactivo</option>
                                            </select>
                                        </div> 
                                        <button type="button" onclick="javascript:validate();" class="btn btn-default">Guardar</button>
                                   </form>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->