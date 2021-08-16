<?php 
	$x = 0;
	$json_data = array();
	$json_data = json_decode($dataServ->getProfileList());	
?>
<script>
function validate(){
	if (document.getElementById("surname").value == ""){
		showErrorMessage("Disculpe, debe indicar los nombres del usuario");
	}else if (document.getElementById("lastname").value == ""){
		showErrorMessage("Disculpe, debe indicar los apellidos del usuario");
	}else if (document.getElementById("username").value == ""){
		showErrorMessage("Disculpe, debe indicar el nombre de usuario");
	}else if (document.getElementById("pwd").value == ""){
		showErrorMessage("Disculpe, debe indicar la contraseña del usuario");
	}else{	
		var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) { 				
				var myObj = JSON.parse(this.responseText);
				if (myObj.response == "OK"){
					wheretogo = "main.php?m=settings";
					showSuccessMessage();
				}else{
					showErrorMessage("Disculpe, ha ocurrido un error almacenando los datos del usuario");
				}					
			}
		};
		xhttp.open("GET", "modules/settings_user_add_action.php?surname=" + document.getElementById("surname").value + "&lastname=" + document.getElementById("lastname").value + "&username=" + document.getElementById("username").value + "&pwd=" + document.getElementById("pwd").value + "&perfil=" + document.getElementById("perfil").value + "&status=" + document.getElementById("status").value, true);
		xhttp.send(); 			
	}
}
</script>
<br>          <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Agregar nuevo usuario</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=settings';">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" action="javascript:validate();" method="post">
                                        <div class="form-group">
                                            <label>Nombres del usuario</label>
                                            <input id="surname" class="form-control" placeholder="Ingrese nombres del usuario">
                                        </div>
                                        <div class="form-group">
                                            <label>Apellidos del usuario</label>
                                            <input id="lastname" class="form-control" placeholder="Ingrese apellidos del usuario">
                                        </div>
                                        <div class="form-group">
                                            <label>Nombre de usuario del cms</label>
                                            <input id="username" class="form-control" placeholder="Ingrese nombre de usuario para la sesión en el cms">
                                        </div>
                                        <div class="form-group">
                                            <label>Contraseña</label>
                                            <input id="pwd" class="form-control" placeholder="Ingrese la contraseña a usar para iniciar sesión en el cms">
                                        </div>                                                                                                                        
                                        <div class="form-group">
                                            <label>Perfil asociado</label>
                                            <select id="perfil" class="form-control">
		                                	<?php if (isset($json_data->profilelist)){ ?>
		                                		<?php for ($x = 0; $x < sizeof($json_data->profilelist); $x++){ ?>
		                                			<option value="<?php echo $json_data->profilelist[$x]->id ?>"><?php echo $json_data->profilelist[$x]->nombre ?></option>						                                
			                                    <?php } ?>
		                                    <?php } ?>                                                                                           
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Estado del usuario</label>
                                            <select id="status" class="form-control">
                                                <option value="S">Activo</option>
                                                <option value="N">Inactivo</option>
                                            </select>
                                        </div>                                        
                                        <button type="submit" class="btn btn-default">Guardar</button>
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
