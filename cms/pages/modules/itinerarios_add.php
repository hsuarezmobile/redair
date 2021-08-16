<script>
function validate() {
    let files = new FormData(),
        url = 'modules/itinerarios.php';
		if (document.getElementById("vuelo").value == ""){
			showErrorMessage("Disculpe, debe indicar el vuelo");
		}else if (document.getElementById("salida").value == ""){
			showErrorMessage("Disculpe, debe indicar la salida");
		}else if (document.getElementById("destino").value == ""){
			showErrorMessage("Disculpe, debe indicar el destino");
		}else if (document.getElementById("llegada").value == ""){
			showErrorMessage("Disculpe, debe indicar la llegada");
		}else if (document.getElementById("frecuencia").value == ""){
			showErrorMessage("Disculpe, debe indicar la frecuencia");
		}else if (document.getElementById("orden").value == ""){
			showErrorMessage("Disculpe, debe indicar el orden");
		}else{	  
			var formData = new FormData();
			formData.append('vuelo', document.getElementById("vuelo").value);
			formData.append('salida', document.getElementById("salida").value);
			formData.append('destino', document.getElementById("destino").value);
			formData.append('llegada', document.getElementById("llegada").value);
			formData.append('frecuencia', document.getElementById("frecuencia").value);
			formData.append('tipo', document.getElementById("tipo").value);
			formData.append('orden', document.getElementById("orden").value);
			formData.append('activo', document.getElementById("activo").value);
			$.ajax({
			   url : 'modules/itinerarios_action.php',
			   type : 'POST',
			   data : formData,
			   processData: false,
			   contentType: false,
			   success : function(datax) {
					var myObj = JSON.parse(datax);
					if (myObj.response == "OK"){
						wheretogo = "main.php?m=itinerarios"
						showSuccessMessage();
					}else{
						showErrorMessage("Disculpe, ha ocurrido un error almacenando los datos del itineario indicado");
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
                            <b>Agregar nuevo itinerario de vuelo</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=itinerarios'">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" method="post" action="javascript:validate();">
                                        <div class="form-group">
                                            <label>Vuelo</label>
                                            <input id="vuelo" class="form-control" placeholder="Ingrese vuelo">
                                        </div>
                                        <div class="form-group">
                                            <label>Salida</label>
                                            <input id="salida" class="form-control" placeholder="Ingrese salida">
                                        </div>	
                                        <div class="form-group">
                                            <label>Destino</label>
                                            <input id="destino" class="form-control" placeholder="Ingrese destino">
                                        </div>											
                                        <div class="form-group">
                                            <label>Llegada</label>
                                            <input id="llegada" class="form-control" placeholder="Ingrese llegada">
                                        </div>											
                                        <div class="form-group">
                                            <label>Frecuencia</label>
                                            <input id="frecuencia" class="form-control" placeholder="Ingrese frecuencia">
                                        </div>																					
                                        <div class="form-group">
                                            <label>Tipo de vuelo</label>
                                            <select id="tipo" class="form-control">
                                                <option value="0">Nacional</option>
                                                <option value="1">Internacional</option>
                                            </select>
                                        </div>                                        
                                        <div class="form-group">
                                            <label>Estado</label>
                                            <select id="activo" class="form-control">
                                                <option value="S">Activo</option>
                                                <option value="N">Inactivo</option>
                                            </select>
                                        </div>    
                                        <div class="form-group">
                                            <label>Orden</label>
                                            <input id="orden" class="form-control" placeholder="Ingrese orden">
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