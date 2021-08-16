<?php 
	$x = 0;
	$json_data = array();
	$json_data = json_decode($dataServ->getvuelosList());
?>            
<script>
function doDeleteVuelo(ids){
	wheretogoyes = "?m=dodeleteitinerarios&id=" + ids;
	wheretogono = "#";
	wheretogo = "?m=settings";
	showQuestionMessage("¿Desea usted eliminar este itinerario de vuelo?");		
}
function doEditVuelo(ids){
	window.location = "?m=itinerarios_edit&id=" + ids;
}
</script>
            <!-- /.row -->
            <br><div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                           Itinerarios de vuelos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="home">
						            <div class="row">
						                <div class="col-lg-12">
						                    <div class="panel panel-default">
						                        <div class="panel-heading">
						                            Listado de itinerarios de vuelos | <a href="main.php?m=itinerarios_add">Agregar itinerario de vuelo</a>
						                        </div>
						                        <!-- /.panel-heading -->
						                        <div class="panel-body">
						                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						                                <thead>
						                                    <tr>
						                                        <th>Vuelos</th>						                                        
																<th>Tipo</th>
						                                        <th>Estatus</th>
						                                        <th>Acciones</th>
						                                    </tr>
						                                </thead>
						                                <tbody>
						                                	<?php if (isset($json_data->data)){ ?>
						                                		<?php for ($x = 0; $x < sizeof($json_data->data); $x++){ 
						                                				$status = "";
																		$tipo = "";
						                                				if ($json_data->data[$x]->activo == "S"){
						                                					$status = "Activo";
						                                				}else{
						                                					$status = "Inactivo";
						                                				}
						                                				if ($json_data->data[$x]->tipo == 0){
						                                					$tipo = "Nacional";
						                                				}else{
						                                					$tipo = "Internacional";
						                                				}																		
						                                			?>						                                
							                                    <tr class="odd gradeX">
							                                        <td><?php echo $json_data->data[$x]->vuelo; ?></td>							                                        
																	<td><?php echo $tipo; ?></td>
																	<td><?php echo $status; ?></td>
							                                        <td class="center"><button type="button" class="btn btn-primary btn-circle" title="Editar" onclick="doEditVuelo('<?php echo $json_data->data[$x]->id ?>');"><i class="fa fa-list"></i></button>&nbsp;<button type="button" class="btn btn-warning btn-circle" title="Eliminar" onclick="doDeleteVuelo('<?php echo $json_data->data[$x]->id ?>');"><i class="fa fa-times"></i></button></td>
							                                    </tr>
							                                    <?php } ?>
						                                    <?php } ?>
						                                </tbody>
						                            </table>
						                        </div>
						                        <!-- /.panel-body -->
						                    </div>
						                    <!-- /.panel -->
						                </div>
						                <!-- /.col-lg-12 -->
						            </div>
						            <!-- /.row -->                                
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            <!-- /.row -->