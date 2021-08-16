<script>
function validate() {
    let files = new FormData(),
        url = 'modules/vitrina_action.php';

		if (document.getElementById("surname").value == ""){
			showErrorMessage("Disculpe, debe indicar el nombre de la vitrina");
		}else if (document.getElementById("orden").value == ""){
			showErrorMessage("Disculpe, debe indicar el orden de aparición de la vitrina");
		}else{	  
			var formData = new FormData();
			formData.append('archivo', $('#archivo')[0].files[0]);
			formData.append('surname', document.getElementById("surname").value);
			formData.append('orden', document.getElementById("orden").value);
			formData.append('activo', document.getElementById("activo").value);
			$.ajax({
			   url : 'modules/vitrina_action.php',
			   type : 'POST',
			   data : formData,
			   processData: false,
			   contentType: false,
			   success : function(datax) {
					var myObj = JSON.parse(datax);
					if (myObj.response == "OK"){
						wheretogo = "main.php?m=vitrina";
						showSuccessMessage();
					}else{
						showErrorMessage("Disculpe, ha ocurrido un error almacenando los datos de la vitrina");
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
                            <b>Agregar nueva vitrina</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=vitrina';">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" method="post" action="javascript:validate();">
                                        <div class="form-group">
                                            <label>Nombre de la vitrina</label>
                                            <input id="surname" class="form-control" placeholder="Ingrese nombre de la vitrina">
                                        </div>
                                        <div class="form-group">
                                            <label>Imagen</label>
                                            <input id="archivo" type="file"> Ancho = 1740px x Alto = 630px, formato JPG peso menor de 1 mb
                                        </div>        
                                        <div class="form-group">
                                            <label>Estado de la vitrina</label>
                                            <select id="activo" class="form-control">
                                                <option value="S">Activo</option>
                                                <option value="N">Inactivo</option>
                                            </select>
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Orden de aparición</label>
                                            <input id="orden" class="form-control" placeholder="Ingrese orden de aparición de la vitrina">
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