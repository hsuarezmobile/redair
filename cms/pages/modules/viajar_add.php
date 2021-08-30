<script>
function validate() {
    let files = new FormData(),
        url = 'modules/viajar.php';
		var formData = new FormData();
		formData.append('desc1', tinymce.get('desc1').getContent());
		formData.append('id', document.getElementById("id").value);
		formData.append('nombre', document.getElementById("nombre").value);
		formData.append('orden', document.getElementById("orden").value);
		$.ajax({
		   url : 'modules/viajar_action.php',
		   type : 'POST',
		   data : formData,
		   processData: false,
		   contentType: false,
		   success : function(datax) {
				var myObj = JSON.parse(datax);
				if (myObj.response == "OK"){
					wheretogo = "main.php?m=viajar";
					showSuccessMessage();
				}else{
					showErrorMessage("Disculpe, ha ocurrido un error almacenando los datos de la sección antes de viajar");
				}												  
		   }
		});
}	
</script>
<br>          <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Agregar item antes de viajar</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=viajar'">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" method="post" action="javascript:validate();">
										<div class="form-group" style="display:none;">
											<input id="id" class="form-control"  value="<?php echo $id ?>">
										</div>
										<div class="form-group">
											<label>Indique nombre del item de antes de viajar</label>
											<input id="nombre" class="form-control" value="">
										</div>
                                        <div class="form-group">
                                            <label>Contenido de la sección <?php echo $json_data->articuloList[0]->nombre ?></label>
                                            <textarea id="desc1" style="height:600px" class="form-control"><?php echo $json_data->articuloList[0]->contenido ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Orden de aparición</label>
                                            <input id="orden" class="form-control" placeholder="Ingrese orden de aparición" value="0">
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