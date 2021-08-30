<?php 
	$x = 0;
	$id = $_GET["id"];
	$json_data = array();
	$json_data = json_decode($dataServ->getContenidosById($id));
	//echo "<pre>"; var_dump($json_data); die();
?>
<script>
function validate() {
    let files = new FormData(),
        url = 'modules/viajar.php';
		var formData = new FormData();
		formData.append('desc1', tinymce.get('desc1').getContent());
		formData.append('nombre', document.getElementById("nombre").value);
		formData.append('id', document.getElementById("id").value);
		$.ajax({
		   url : 'modules/contenido_action.php',
		   type : 'POST',
		   data : formData,
		   processData: false,
		   contentType: false,
		   success : function(datax) {
				var myObj = JSON.parse(datax);
				if (myObj.response == "OK"){
					wheretogo = "main.php?m=contenido";
					showSuccessMessage();
				}else{
					showErrorMessage("Disculpe, ha ocurrido un error almacenando los datos");
				}												  
		   }
		});
}	
</script>
<br>          <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Editar item de contenido</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=contenido'">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" method="post" action="javascript:validate();">
										<div class="form-group" style="display:none;">
											<input id="id" class="form-control"  value="<?php echo $id ?>">
										</div>																		
                                        <div class="form-group">
                                            <label>Titulo de la sección</label>
											<input id="nombre" style="width:100%;" class="form-control" value="<?php echo $json_data->data[0]->nombre ?>">
										</div>
										<div class="form-group">
											<label>Contenido de la sección</label>
                                            <textarea id="desc1" style="height:600px; width:100%;" class="form-control"><?php echo $json_data->data[0]->contenido ?></textarea>
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