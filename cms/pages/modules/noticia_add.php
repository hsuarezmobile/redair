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
                            <b>Agregar nueva noticia</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=noticia';">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" method="post" action="javascript:validate();">
                                        <div class="form-group">
                                            <label>Título</label>
                                            <input id="titulo" class="form-control" placeholder="Ingrese titulo de la noticia">
                                        </div>
                                        <div class="form-group">
                                            <label>Fecha</label>
                                            <input id="fecha" class="form-control" value="<?php echo $currdate; ?>" placeholder="Ingrese fecha de creacion de la noticia">
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Contenido</label>
                                            <textarea id="desc" name="desc" class="form-control" rows="3" placeholder="Ingrese contenido de la noticia"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Imagen pequeña</label>
                                            <input id="archivo2" type="file"> Ancho = 265px x Alto = 225px, formato JPG peso menor de 1 mb
                                        </div>        
                                        <div class="form-group">
                                            <label>Imagen grande</label>
                                            <input id="archivo" type="file"> Ancho = 1124px x Alto = 400px, formato JPG peso menor de 1 mb
                                        </div>        
                                        <div class="form-group">
                                            <label>Estado de la noticia</label>
                                            <select id="activo" class="form-control">
                                                <option value="S">Activo</option>
                                                <option value="N">Inactivo</option>
                                            </select>
                                        </div>                                        
                                        <button type="button" onclick="javascript:validate();" class="btn btn-default">Guardar</button>
                                        <button type="reset" class="btn btn-default">Reiniciar</button>
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