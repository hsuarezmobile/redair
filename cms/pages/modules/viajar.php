<?php 
	$x = 0;
	$json_data = array();
	$json_data = json_decode($dataServ->getViajarList());
?>            
<script>
function doEditViajar(ids){
	window.location = "?m=viajar_edit&id=" + ids;		
}
function doDeleteViajar(ids){
	wheretogoyes = "?m=dodeleteviajar&id=" + ids;
	wheretogono = "#";
	wheretogo = "?m=viajar";
	showQuestionMessage("¿Desea usted eliminar este item de antes de viajar?");		
}
</script>
            <!-- /.row -->
            <br><div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Antes de Viajar
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
						                            Listado de items sección antes de viajar | <a href="main.php?m=viajar_add">Agregar item</a>
						                        </div>
						                        <!-- /.panel-heading -->
						                        <div class="panel-body">
						                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						                                <thead>
						                                    <tr>
						                                        <th>Items</th>	
						                                        <th>Orden</th>						                                        
						                                        <th>Acciones</th>
						                                    </tr>
						                                </thead>
						                                <tbody>
						                                	<?php if (isset($json_data->data)){ ?>
						                                		<?php for ($x = 0; $x < sizeof($json_data->data); $x++){ 
						                                				$status = "";
						                                			?>						                                
							                                    <tr class="odd gradeX">
							                                        <td><?php echo $json_data->data[$x]->nombre; ?></td>							                                        
							                                        <td><?php echo $json_data->data[$x]->orden; ?></td>
							                                        <td class="center"><button type="button" class="btn btn-primary btn-circle" title="Editar" onclick="doEditViajar('<?php echo $json_data->data[$x]->id ?>');"><i class="fa fa-list"></i></button>&nbsp;<button type="button" class="btn btn-warning btn-circle" title="Eliminar" onclick="doDeleteViajar('<?php echo $json_data->data[$x]->id ?>');"><i class="fa fa-times"></i></button></td>
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