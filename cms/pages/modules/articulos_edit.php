<?php 
	$x = 0;
	$id = $_GET["id"];
	$json_data = array();
	$json_data = json_decode($dataServ->getArticuloNoIndemnizableById($id));
?>
<script>
function validate() {
    let files = new FormData(),
        url = 'modules/articulos.php';
		if (document.getElementById("desc1").value == ""){
			showErrorMessage("Disculpe, debe indicar la descripción del articulo no indemnizable");
		}else if (document.getElementById("desc2").value == ""){
			showErrorMessage("Disculpe, debe indicar la descripción 2 del articulo no indemnizable");
		}else if (document.getElementById("orden").value == ""){
			showErrorMessage("Disculpe, debe indicar el orden del articulo no indemnizable");
		}else{	  
			var formData = new FormData();
			formData.append('desc1', document.getElementById("desc1").value);
			formData.append('desc2', document.getElementById("desc2").value);
			formData.append('orden', document.getElementById("orden").value);
			formData.append('activo', document.getElementById("activo").value);
			formData.append('id', document.getElementById("id").value);
			$.ajax({
			   url : 'modules/articulos_action.php',
			   type : 'POST',
			   data : formData,
			   processData: false,
			   contentType: false,
			   success : function(datax) {
					var myObj = JSON.parse(datax);
					if (myObj.response == "OK"){
						wheretogo = "main.php?m=articulos"
						showSuccessMessage();
					}else{
						showErrorMessage("Disculpe, ha ocurrido un error almacenando los datos del articulo no indemnizable");
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
                            <b>Editar artìculo no indemnizable</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=articulos'">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" method="post" action="javascript:validate();">
										<div class="form-group" style="display:none;">
											<input id="id" class="form-control"  value="<?php echo $id ?>">
										</div>																		
                                        <div class="form-group">
                                            <label>Descripción #1 del artìculo no indemnizable</label>
                                            <input id="desc1" class="form-control" placeholder="Ingrese descripción #1" value="<?php echo $json_data->articuloList[0]->desc1 ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Descripción #2 del artìculo no indemnizable</label>
                                            <input id="desc2" class="form-control" placeholder="Ingrese descripción #2" value="<?php echo $json_data->articuloList[0]->desc2 ?>">
                                        </div>	
                                        <div class="form-group">
                                            <label>Estado del artìculo no indemnizable</label>
                                            <select id="activo" class="form-control">
                                                <option value="S" <?php if ($json_data->articuloList[0]->activo == "S"){ ?>selected<?php } ?>>Activo</option>
                                                <option value="N" <?php if ($json_data->articuloList[0]->activo == "N"){ ?>selected<?php } ?>>Inactivo</option>
                                            </select>
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Orden de aparición</label>
                                            <input id="orden" class="form-control" placeholder="Ingrese orden del artículo no indemnizable" value="<?php echo $json_data->articuloList[0]->orden ?>">
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