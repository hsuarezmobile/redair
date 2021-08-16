<?php 
	$x = 0;
	$json_data = array();
	$json_data = json_decode($dataServ->getVitrinaList());
?>            
<script>
function doDeleteVitrina(ids){
	wheretogoyes = "?m=dodeletevitrina&id=" + ids;
	wheretogono = "#";
	wheretogo = "?m=settings";
	showQuestionMessage("¿Desea usted eliminar esta vitrina?");		
}
function doEditVitrina(ids){
	window.location = "?m=vitrina_edit&id=" + ids;		
}
</script>
            <!-- /.row -->
            <br><div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Vitrinas del home
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
						                            Listado de vitrinas | <a href="main.php?m=vitrina_add">Agregar vitrina</a>
						                        </div>
						                        <!-- /.panel-heading -->
						                        <div class="panel-body">
						                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						                                <thead>
						                                    <tr>
						                                        <th>Vitrina</th>						                                        
						                                        <th>Estatus</th>
						                                        <th>Acciones</th>
						                                    </tr>
						                                </thead>
						                                <tbody>
						                                	<?php if (isset($json_data->virinasList)){ ?>
						                                		<?php for ($x = 0; $x < sizeof($json_data->virinasList); $x++){ 
						                                				$status = "";
						                                				if ($json_data->virinasList[$x]->activo == "S"){
						                                					$status = "Activo";
						                                				}else{
						                                					$status = "Inactivo";
						                                				}
						                                			?>						                                
							                                    <tr class="odd gradeX">
							                                        <td><?php echo $json_data->virinasList[$x]->nombre; ?></td>							                                        
							                                        <td><?php echo $status; ?></td>
							                                        <td class="center"><button type="button" class="btn btn-primary btn-circle" title="Editar" onclick="doEditVitrina('<?php echo $json_data->virinasList[$x]->id ?>');"><i class="fa fa-list"></i></button>&nbsp;<button type="button" class="btn btn-warning btn-circle" title="Eliminar" onclick="doDeleteVitrina('<?php echo $json_data->virinasList[$x]->id ?>');"><i class="fa fa-times"></i></button></td>
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