<?php 
	$x = 0;
	$json_data = array();
	$json_data = json_decode($dataServ->getBlogList());
?>            
<script>
function doDeleteEntry(ids){
	wheretogoyes = "?m=dodeleteentry&id=" + ids;
	wheretogono = "#";
	wheretogo = "?m=settings";
	showQuestionMessage("¿Desea usted eliminar esta noticia?");		
}
function doEditEntry(ids){
	window.location = "?m=blog_entry_edit&id=" + ids;		
}
</script>
            <!-- /.row -->
            <br><div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Noticias
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
						                            Listado de noticias | <a href="main.php?m=blog_entry_add">Agregar noticia</a>
						                        </div>
						                        <!-- /.panel-heading -->
						                        <div class="panel-body">
						                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						                                <thead>
						                                    <tr>
						                                        <th>Noticia</th>						                                        
						                                        <th>Estatus</th>
						                                        <th>Acciones</th>
						                                    </tr>
						                                </thead>
						                                <tbody>
						                                	<?php if (isset($json_data->entriesList)){ ?>
						                                		<?php for ($x = 0; $x < sizeof($json_data->entriesList); $x++){ 
						                                				$status = "";
						                                				if ($json_data->entriesList[$x]->entry_activo == "S"){
						                                					$status = "Activo";
						                                				}else{
						                                					$status = "Inactivo";
						                                				}
						                                			?>						                                
							                                    <tr class="odd gradeX">
							                                        <td><?php echo $json_data->entriesList[$x]->titulo; ?></td>							                                        
							                                        <td><?php echo $status; ?></td>
							                                        <td class="center"><button type="button" class="btn btn-primary btn-circle" title="Editar" onclick="doEditEntry('<?php echo $json_data->entriesList[$x]->id ?>');"><i class="fa fa-list"></i></button>&nbsp;<button type="button" class="btn btn-warning btn-circle" title="Eliminar" onclick="doDeleteEntry('<?php echo $json_data->entriesList[$x]->id ?>');"><i class="fa fa-times"></i></button></td>
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
                                <div class="tab-pane fade" id="profile">
						                <div class="col-lg-12" style="padding-right: 0px; padding-left: 0px;">
						                    <div class="panel panel-default">
						                        <div class="panel-heading">
						                            Listado de perfiles | <a href="main.php?m=settings_profile_add">Agregar perfil</a>
						                        </div>
						                        <!-- /.panel-heading -->
						                        <div class="panel-body">
						                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						                                <thead>
						                                    <tr>
						                                        <th>Nombre</th>
						                                        <th>Estatus</th>
																<th>Acciones</th>
						                                    </tr>
						                                </thead>
						                                <tbody>
						                                	<?php if (isset($json_data2->profilelist)){ ?>
						                                		<?php for ($x = 0; $x < sizeof($json_data2->profilelist); $x++){ ?>						                                
							                                    <tr class="odd gradeX">
							                                        <td><?php echo $json_data2->profilelist[$x]->nombre ?></td>
							                                        <td><?php echo $json_data2->profilelist[$x]->activo ?></td>
							                                        <td class="center"><button type="button" class="btn btn-primary btn-circle" title="Editar"><i class="fa fa-list"></i></button>&nbsp;<button type="button" class="btn btn-warning btn-circle" title="Eliminar" onclick="doDeleteProfile('<?php echo $json_data2->profilelist[$x]->id ?>');"><i class="fa fa-times"></i></button></td>
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
                                </div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
            </div>
            <!-- /.row -->