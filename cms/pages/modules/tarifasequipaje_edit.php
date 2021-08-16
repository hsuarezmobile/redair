<?php 
	$x = 0;
	$id = $_GET["id"];
	$json_data = array();
	$json_data = json_decode($dataServ->getTarifaEquipajeById($id));
?>
<script>
function validate() {
    let files = new FormData(),
        url = 'modules/tarifasequipaje_action.php';
		if (document.getElementById("desc").value == ""){
			showErrorMessage("Disculpe, debe indicar la descripción de la tarifa");
		}else if (document.getElementById("mia").value == ""){
			showErrorMessage("Disculpe, debe indicar el valor MIA");
		}else if (document.getElementById("sdo").value == ""){
			showErrorMessage("Disculpe, debe indicar el valor SDO");
		}else if (document.getElementById("pty").value == ""){
			showErrorMessage("Disculpe, debe indicar el valor PTY");						
		}else if (document.getElementById("cur").value == ""){
			showErrorMessage("Disculpe, debe indicar el valor CUR");						
		}else if (document.getElementById("aua").value == ""){
			showErrorMessage("Disculpe, debe indicar el valor AUA");						
		}else if (document.getElementById("gye").value == ""){
			showErrorMessage("Disculpe, debe indicar el valor GYE");						
		}else if (document.getElementById("orden").value == ""){
			showErrorMessage("Disculpe, debe indicar el orden de aparición de la tarifa");
		}else{	  
			var formData = new FormData();
			formData.append('desc', document.getElementById("desc").value);
			formData.append('mia', document.getElementById("mia").value);
			formData.append('sdo', document.getElementById("sdo").value);
			formData.append('pty', document.getElementById("pty").value);
			formData.append('cur', document.getElementById("cur").value);
			formData.append('aua', document.getElementById("aua").value);
			formData.append('gye', document.getElementById("gye").value);
			formData.append('orden', document.getElementById("orden").value);
			formData.append('activo', document.getElementById("activo").value);
			formData.append('id', document.getElementById("id").value);
			$.ajax({
			   url : 'modules/tarifasequipaje_action.php',
			   type : 'POST',
			   data : formData,
			   processData: false,
			   contentType: false,
			   success : function(datax) {
					var myObj = JSON.parse(datax);
					if (myObj.response == "OK"){
						wheretogo = "main.php?m=tarifasequipaje";
						showSuccessMessage();
					}else{
						showErrorMessage("Disculpe, ha ocurrido un error almacenando los datos de la tarifa de equipaje");
					}												  
			   }
			});
		}
}	
</script>
<br>          <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Editar tarifa de equipaje</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=tarifasequipaje'">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" method="post" action="javascript:validate();">
										<div class="form-group" style="display:none;">
											<input id="id" class="form-control"  value="<?php echo $id ?>">
										</div>									
                                        <div class="form-group">
                                            <label>Descripción de la tarifa de equipaje</label>
                                            <input id="desc" class="form-control" placeholder="Ingrese descripción de la tarifa de equipaje" value="<?php echo $json_data->tarifaEquipajeList[0]->desc ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>MIA</label>
                                            <input id="mia" class="form-control" placeholder="Ingrese valor MIA" value="<?php echo $json_data->tarifaEquipajeList[0]->mia ?>">
                                        </div>	
                                        <div class="form-group">
                                            <label>SDO</label>
                                            <input id="sdo" class="form-control" placeholder="Ingrese valor SDO" value="<?php echo $json_data->tarifaEquipajeList[0]->sdq ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>PTY</label>
                                            <input id="pty" class="form-control" placeholder="Ingrese valor PTY" value="<?php echo $json_data->tarifaEquipajeList[0]->pty ?>">
                                        </div>										
                                        <div class="form-group">
                                            <label>CUR</label>
                                            <input id="cur" class="form-control" placeholder="Ingrese valor CUR" value="<?php echo $json_data->tarifaEquipajeList[0]->cur ?>">
                                        </div>										
                                        <div class="form-group">
                                            <label>AUA</label>
                                            <input id="aua" class="form-control" placeholder="Ingrese valor AUA" value="<?php echo $json_data->tarifaEquipajeList[0]->aua ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>GYE</label>
                                            <input id="gye" class="form-control" placeholder="Ingrese valor GYE" value="<?php echo $json_data->tarifaEquipajeList[0]->gye ?>">
                                        </div>																													
                                        <div class="form-group">
                                            <label>Estado de la tarifa</label>
                                            <select id="activo" class="form-control">
                                                <option value="S" <?php if ($json_data->tarifaEquipajeList[0]->activo == "S"){ ?>selected<?php } ?>>Activo</option>
                                                <option value="N" <?php if ($json_data->tarifaEquipajeList[0]->activo == "N"){ ?>selected<?php } ?>>Inactivo</option>
                                            </select>
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Orden de aparición</label>
                                            <input id="orden" class="form-control" placeholder="Ingrese orden de aparición de la tarifa" value="<?php echo $json_data->tarifaEquipajeList[0]->orden ?>">
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