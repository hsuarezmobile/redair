<?php 
	$x = 0;
	$id = $_GET["id"];
	$json_data = array();
	$json_data = json_decode($dataServ->getContenidosTipoxById($id));
?>
<script>
function validate() {
    	let files = new FormData();
        url = 'modules/viajar.php';
		var formData = new FormData();
		formData.append('nombre', document.getElementById("id").value);
		formData.append('id', document.getElementById("id").value);
		formData.append('archivo', $('#archivo')[0].files[0]);
		$.ajax({
		   url : 'modules/contenidox_action.php',
		   type : 'POST',
		   data : formData,
		   processData: false,
		   contentType: false,
		   success : function(datax) {
				var myObj = JSON.parse(datax);
				if (myObj.response == "OK"){
					wheretogo = "main.php?m=contenidox";
					showSuccessMessage();
				}else{
					showErrorMessage("Disculpe, ha ocurrido un error almacenando los datos");
				}												  
		   }
		});
}	
function titlecallback(){
	$.fancybox.close();
	getTable();
}
function getTable(){
	$.ajax({
		url: 'modules/elements.php?seccion=<?php echo $id ?>',
		success: function(respuesta) {
			elements.innerHTML = respuesta;
		},
		error: function() {
	        console.log("No se ha podido obtener la información");
	    }
	});
}
function deleteElement(ids){
	$.ajax({
		url: 'modules/dodeleteelement.php?id=' + ids,
		success: function(respuesta) {
			getTable();
		},
		error: function() {
	        console.log("No se ha podido obtener la información");
	    }
	});
}
function doDelete(ids){
	wheretogoyes = "javascript:deleteElement('" + ids + "')";
	wheretogono = "#";
	wheretogo = "main.php?m=contenidox_edit&id=".$id;
	showQuestionMessage("¿Desea usted eliminar este elemento del contenido de la sección?");		
}
</script>
<br>          <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>Editar item de contenido</b>&nbsp;|&nbsp;<a href="javascript:window.location='?m=contenidox'">Regresar</a>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <form role="form" id="form1" name="form1" method="post" action="javascript:validate();">
										<div class="form-group" style="display:none;">
											<input id="id" class="form-control"  value="<?php echo $id ?>">
										</div>																		
                                        <div class="form-group">
                                            <label>Sección: <?php echo $id ?></label>
										</div>
										<div class="form-group">
											<label>Contenido de la sección</label><br>
                                            <div class="container" style="margin-top: 20px;">
                                                  <a href="modules/agregar_titulo.php?id=<?php echo $id ?>&section=<?php echo $id ?>" data-fancybox data-options='{"type" : "iframe", "iframe" : {"preload" : false, "css" : {"width" : "50%", "height" : "280px"}}}'>
                                                      <div class="card" title="Haga clic para agregar un titulo" alt="Haga clic para agregar un titulo" style="display: inline-block;text-align:center;padding: 10px;width:10%;cursor:pointer;border: 1px;border-style: solid;padding: 20px;border-radius: 3px;border-color: #bebebe;margin-bottom:20px;height: 10%;">
                                    					<span class="glyphicon glyphicon-font"></span> 
                                                        <div class="card-body">
                                                          <h4 class="card-title">Título</h4>
                                                        </div>
                                                      </div>
                                                  </a>
                                                  <a href="modules/agregar_parrafo.php?id=<?php echo $id ?>&section=<?php echo $id ?>" data-fancybox data-options='{"type" : "iframe", "iframe" : {"preload" : false, "css" : {"width" : "50%", "height" : "400px"}}}'>
                                                      <div class="card" title="Haga clic para agregar un parrafo" alt="Haga clic para agregar un parrafo" style="display: inline-block;text-align:center;padding: 10px;width:10%;cursor:pointer;border: 1px;border-style: solid;padding: 20px;border-radius: 3px;border-color: #bebebe;margin-bottom:20px;height: 10%;">
                                    					<span class="glyphicon glyphicon-align-justify"></span> 
                                                        <div class="card-body">
                                                          <h4 class="card-title">Parrafo</h4>
                                                        </div>
                                                      </div>
                                                  </a>
                                                  <a href="modules/agregar_lista.php?id=<?php echo $id ?>&section=<?php echo $id ?>" data-fancybox data-options='{"type" : "iframe", "iframe" : {"preload" : false, "css" : {"width" : "60%", "height" : "800px"}}}'>  
                                                      <div class="card" title="Haga clic para agregar una viñeta" alt="Haga clic para agregar una viñeta" style="display: inline-block;text-align:center;padding: 10px;width:10%;cursor:pointer;border: 1px;border-style: solid;padding: 20px;border-radius: 3px;border-color: #bebebe;margin-bottom:20px;height: 10%;">
                                    					<span class="glyphicon glyphicon-list"></span> 
                                                        <div class="card-body">
                                                          <h4 class="card-title">Viñeta</h4>
                                                        </div>
                                                      </div>
                                                  </a>
                                                  <a href="modules/agregar_acordeon.php?id=<?php echo $id ?>&section=<?php echo $id ?>" data-fancybox data-options='{"type" : "iframe", "iframe" : {"preload" : false, "css" : {"width" : "60%", "height" : "880px"}}}'>
                                                      <div class="card" title="Haga clic para agregar un acordeón" alt="Haga clic para agregar un acordeón" style="display: inline-block;text-align:center;padding: 10px;width:10%;cursor:pointer;border: 1px;border-style: solid;padding: 20px;border-radius: 3px;border-color: #bebebe;margin-bottom:20px;height: 10%;">
                                    					<span class="glyphicon glyphicon-menu-hamburger"></span>
                                                        <div class="card-body">
                                                          <h4 class="card-title">Acordeón</h4>
                                                        </div>
                                                      </div>
                                                  </a>                                          
                                			</div>
											<div style="width:100%; height:20px;"></div>											
											<label>Elementos de contenido creados</label>
											<div id="elements" name="elements">
											</div>
										</div>
										<?php if ($json_data->contenidosList[0]->imagen != ""){ ?>
                                        <div class="form-group">
                                            <label>Imagen actual</label>
                                            <a href="../../../img/blog-img/<?php echo $json_data->contenidosList[0]->imagen ?>" target="blank">Haga click aca para ver la imagen actual</a>
                                        </div>                                         
										<?php } ?>
                                        <div class="form-group">
                                            <label>Imagen</label>
                                            <input id="archivo" type="file"> Ancho = 350px x Alto = 350px, formato JPG peso menor de 1 mb
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
            
<style>
    .mceLayout{
        display:none !important;
    }
    #parrafo{
        display: block !important;
    }
</style>
<script>
	getTable();
</script>            