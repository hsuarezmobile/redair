<?php 
	$x = 0;
	$id = $_GET["id"];
	$json_data = array();
	$json_data = json_decode($dataServ->getProfileById($id));
?>
<script>
function validate(){
	if (document.getElementById("surname").value == ""){
		showErrorMessage("Disculpe, debe indicar los nombres del perfil");
	}else{	
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) { 				
				var myObj = JSON.parse(this.responseText);
				if (myObj.response == "OK"){
					wheretogo = "main.php?m=settings";
					showSuccessMessage();
				}else{
					showErrorMessage("Disculpe, ha ocurrido un error almacenando los datos del perfil");
				}					
			}
		};
		xhttp.open("GET", "modules/settings_profile_edit_action.php?nombre=" + document.getElementById("surname").value + "&permisos=" + document.getElementById("permisos").value + "&activo=" + document.getElementById("activo").value + "&id=<?php echo $id ?>", true);
		xhttp.send(); 			
	}
}
</script>
<br>          <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Editar perfil</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=settings';">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" action="javascript:validate();" method="post">
                                        <div class="form-group">
                                            <label>Nombre del perfil</label>
                                            <input id="surname" class="form-control" placeholder="Ingrese nombre del perfil"  value="<?php echo $json_data->userdata[0]->nombre; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Modulos permisados</label>
                                            <input id="permisos" class="form-control" placeholder="Ingrese los nombres de los modulos permisados, separados por coma"  value="<?php echo $json_data->userdata[0]->permisos; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Estado del perfil</label>
                                            <select id="activo" class="form-control">
                                                <option value="S" <?php if ($json_data->userdata[0]->activo == "S"){ ?>selected<?php } ?>>Activo</option>
                                                <option value="N" <?php if ($json_data->userdata[0]->activo == "N"){ ?>selected<?php } ?>>Inactivo</option>
                                            </select>
                                        </div>   
                                        <button type="submit" class="btn btn-default">Guardar</button>                                        
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
