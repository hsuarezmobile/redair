<script>
function validate() {
    let files = new FormData(), // you can consider this as 'data bag'
        url = 'modules/blog_entry_action.php';

		if (document.getElementById("surname").value == ""){
			showErrorMessage("Disculpe, debe indicar los nombres y apellidos del creador de la noticia");
		}else if (document.getElementById("fecha").value == ""){
			showErrorMessage("Disculpe, debe indicar la fecha de creación de la noticia");
		}else if (document.getElementById("titulo").value == ""){
			showErrorMessage("Disculpe, debe indicar el titulo de la noticia");		
		}else if (document.getElementById("description").value == ""){
			showErrorMessage("Disculpe, debe indicar el contenido de la noticia");
		}else{	  
			var formData = new FormData();
			formData.append('archivo', $('#archivo')[0].files[0]);
			formData.append('surname', document.getElementById("surname").value);
			formData.append('fecha', document.getElementById("fecha").value);
			formData.append('titulo', document.getElementById("titulo").value);
			formData.append('description', document.getElementById("description").value);
			formData.append('activo', document.getElementById("activo").value);
			$.ajax({
			   url : 'modules/blog_entry_action.php',
			   type : 'POST',
			   data : formData,
			   processData: false,
			   contentType: false,
			   success : function(datax) {
					var myObj = JSON.parse(datax);
					if (myObj.response == "OK"){
						wheretogo = "main.php?m=blog";
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
                            <b>Agregar nueva noticia</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=blog';">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" method="post" action="javascript:validate();">
                                        <div class="form-group">
                                            <label>Autor</label>
                                            <input id="surname" class="form-control" placeholder="Ingrese nombres y apellidos">
                                        </div>
                                        <div class="form-group">
                                            <label>Fecha</label>
                                            <input id="fecha" class="form-control" value="<?php echo $currdate; ?>" placeholder="Ingrese fecha de creacion de la entrada">
                                        </div>
                                        <div class="form-group">
                                            <label>Título</label>
                                            <input id="titulo" class="form-control" placeholder="Ingrese titulo de la entrada">
                                        </div>
                                        <div class="form-group">
                                            <label>Contenido</label>
                                            <textarea id="description" class="form-control" rows="3" placeholder="Ingrese contenido de la entrada"></textarea>
                                        </div>          
                                        <div class="form-group">
                                            <label>Imagen</label>
                                            <input id="archivo" type="file"> Ancho = 440px x Alto = 240px, formato JPG peso menor de 1 mb
                                        </div>        
                                        <div class="form-group">
                                            <label>Estado de la entrada</label>
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