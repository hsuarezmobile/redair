<?php 
	$x = 0;
	$json_data = array();
	$json_data = json_decode($dataServ->getDeclaracionList());
?>            
<script>
function doDeleteVitrina(ids){
	wheretogoyes = "?m=dodeletedeclaraciones&id=" + ids;
	wheretogono = "#";
	wheretogo = "?m=settings";
	showQuestionMessage("¿Desea usted eliminar esta declaración?");		
}
function doEditVitrina(ids){
	window.location = "?m=declaraciones_edit&id=" + ids;		
}
</script>
            <!-- /.row -->
            <br><div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            DECLARACIÓN DE SALUD DEL VIAJERO
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
						                            Listado de Declaraciones de viajeros
						                        </div>
						                        <!-- /.panel-heading -->
						                        <div class="panel-body">
						                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						                                <thead>
						                                    <tr>
						                                        <th>Viajero</th>						                                        
						                                        <th>Pasaporte</th>
						                                        <th>Acciones</th>
						                                    </tr>
						                                </thead>
						                                <tbody>
						                                	<?php if (isset($json_data->virinasList)){ 
						                                	    for ($x = 0; $x < sizeof($json_data->virinasList); $x++){
				                                			?>						                                
							                                    <tr class="odd gradeX">
							                                        <td><?php echo $json_data->virinasList[$x]->nombres; ?></td>							                                        
							                                        <td><?php echo $json_data->virinasList[$x]->pasaporte; ?></td>
							                                        <td class="center"><button type="button" class="btn btn-primary btn-circle" title="Editar" onclick="doEditVitrina('<?php echo $json_data->virinasList[$x]->id ?>');"><i class="fa fa-list"></i></button></td>
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