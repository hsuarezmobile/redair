<?php 
	$x = 0;
	$json_data = array();
	$json_data = json_decode($dataServ->getTiposContenidos());
	//echo "<pre>"; var_dump($json_data); die();
?>            
<script>
function doEditContenido(ids){
	window.location = "?m=contenido_edit&id=" + ids;		
}
function doDeleteContenido(ids){
	wheretogoyes = "?m=dodeletecontenido&id=" + ids;
	wheretogono = "#";
	wheretogo = "?m=contenido";
	showQuestionMessage("¿Desea usted eliminar este item de Experiencia RED?");		
}
</script>
            <!-- /.row -->
            <br><div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Experiencia RED
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
						                            Listado de items Experiencia Red | <a href="main.php?m=contenido_add">Agregar item</a>
						                        </div>
						                        <!-- /.panel-heading -->
						                        <div class="panel-body">
						                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						                                <thead>
						                                    <tr>
						                                        <th width="60%">Items</th>	
						                                        <th width="39%">Acciones</th>
						                                    </tr>
						                                </thead>
						                                <tbody>
						                                	<?php if (isset($json_data->data)){ ?>
						                                		<?php for ($x = 0; $x < sizeof($json_data->data); $x++){ 
						                                			?>						                                
							                                    <tr class="odd gradeX">
							                                        <td><?php echo $json_data->data[$x]->nombre; ?></td>							                                        
							                                        <td class="center"><button type="button" class="btn btn-primary btn-circle" title="Editar" onclick="javascript:doEditContenido('<?php echo $json_data->data[$x]->id ?>');"><i class="fa fa-list"></i></button>&nbsp;<button type="button" class="btn btn-warning btn-circle" title="Eliminar" onclick="doDeleteContenido('<?php echo $json_data->data[$x]->id ?>');"><i class="fa fa-times"></i></button></td>
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