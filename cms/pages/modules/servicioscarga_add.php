<script>
function validate() {
    let files = new FormData(),
        url = 'modules/servicioscarga.php';
		if (document.getElementById("tipo").value == ""){
			showErrorMessage("Disculpe, debe indicar el tipo del servicio de carga");
		}else if (document.getElementById("peso").value == ""){
			showErrorMessage("Disculpe, debe indicar el peso del servicio de carga");
		}else if (document.getElementById("monto").value == ""){
			showErrorMessage("Disculpe, debe indicar el monto del servicio de carga");			
		}else if (document.getElementById("orden").value == ""){
			showErrorMessage("Disculpe, debe indicar el orden del articulo no indemnizable");
		}else{	  
			var formData = new FormData();
			formData.append('tipo', document.getElementById("tipo").value);
			formData.append('peso', document.getElementById("peso").value);
			formData.append('monto', document.getElementById("monto").value);
			formData.append('misc', document.getElementById("misc").value);
			formData.append('con', document.getElementById("con").value);
			formData.append('orden', document.getElementById("orden").value);
			formData.append('activo', document.getElementById("activo").value);
			$.ajax({
			   url : 'modules/servicioscarga_action.php',
			   type : 'POST',
			   data : formData,
			   processData: false,
			   contentType: false,
			   success : function(datax) {
					var myObj = JSON.parse(datax);
					if (myObj.response == "OK"){
						wheretogo = "main.php?m=servicioscarga"
						showSuccessMessage();
					}else{
						showErrorMessage("Disculpe, ha ocurrido un error almacenando los datos del servicio de carga");
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
                            <b>Agregar nuevo Servicios de Carga</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=servicioscarga'">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" method="post" action="javascript:validate();">
                                        <div class="form-group">
                                            <label>Tipo de mercancia</label>
                                            <input id="tipo" class="form-control" placeholder="Ingrese tipo">
                                        </div>
                                        <div class="form-group">
                                            <label>Peso</label>
                                            <input id="peso" class="form-control" placeholder="Ingrese peso">
                                        </div>	
                                        <div class="form-group">
                                            <label>Monto</label>
                                            <input id="monto" class="form-control" placeholder="Ingrese monto">
                                        </div>	
                                        <div class="form-group">
                                            <label>Miscelaneo</label>
                                            <select id="misc" class="form-control">
                                                <option value="1">SI</option>
                                                <option value="0">NO</option>
                                            </select>
                                        </div> 
                                        <div class="form-group">
                                            <label>Conexión</label>
                                            <select id="con" class="form-control">
                                                <option value="1">SI</option>
                                                <option value="0">NO</option>
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
                                            <label>Orden de aparición</label>
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