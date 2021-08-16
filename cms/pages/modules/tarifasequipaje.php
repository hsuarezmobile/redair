<?php 
	$x = 0;
	$json_data = array();
	$json_data = json_decode($dataServ->getTarifaEquipajeList());
?>            
<script>
function doDeleteTarifa(ids){
	wheretogoyes = "?m=dodeletetarifasequipaje&id=" + ids;
	wheretogono = "#";
	wheretogo = "?m=settings";
	showQuestionMessage("¿Desea usted eliminar esta Tarifa de equipaje?");		
}
function doEditTarifa(ids){
	window.location = "?m=tarifasequipaje_edit&id=" + ids;		
}
</script>
            <!-- /.row -->
            <br><div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tarifas de Equipaje
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
						                            Listado de tarifas de equipaje | <a href="main.php?m=tarifasequipaje_add">Agregar tarifa de equipaje</a>
						                        </div>
						                        <!-- /.panel-heading -->
						                        <div class="panel-body">
						                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						                                <thead>
						                                    <tr>
						                                        <th>Tarifa</th>						                                        
						                                        <th>Estatus</th>
						                                        <th>Acciones</th>
						                                    </tr>
						                                </thead>
						                                <tbody>
						                                	<?php if (isset($json_data->data)){ ?>
						                                		<?php for ($x = 0; $x < sizeof($json_data->data); $x++){ 
						                                				$status = "";
						                                				if ($json_data->data[$x]->activo == "S"){
						                                					$status = "Activo";
						                                				}else{
						                                					$status = "Inactivo";
						                                				}
						                                			?>						                                
							                                    <tr class="odd gradeX">
							                                        <td><?php echo $json_data->data[$x]->desc; ?></td>							                                        
							                                        <td><?php echo $status; ?></td>
							                                        <td class="center"><button type="button" class="btn btn-primary btn-circle" title="Editar" onclick="doEditTarifa('<?php echo $json_data->data[$x]->id ?>');"><i class="fa fa-list"></i></button>&nbsp;<button type="button" class="btn btn-warning btn-circle" title="Eliminar" onclick="doDeleteTarifa('<?php echo $json_data->data[$x]->id ?>');"><i class="fa fa-times"></i></button></td>
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