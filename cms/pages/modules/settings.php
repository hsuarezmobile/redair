<?php 
	$x = 0;
	$json_data = array();
	$json_data2 = array();
	$json_data = json_decode($dataServ->getUserList());
	$json_data2 = json_decode($dataServ->getProfileList());
?>            
<script>
function doDeleteProfile(ids){
	wheretogoyes = "?m=dodeleteprofile&id=" + ids;
	wheretogono = "#";
	wheretogo = "?m=settings";
	showQuestionMessage("¿Desea usted eliminar este perfil de usuario?");	
}
function doDeleteUser(ids){
	wheretogoyes = "?m=dodeleteuser&id=" + ids;
	wheretogono = "#";
	wheretogo = "?m=settings";
	showQuestionMessage("¿Desea usted eliminar este usuario?");		
}
function doEditUser(ids){
	window.location = "?m=settings_user_edit&id=" + ids;		
}
function doEditProfile(ids){
	window.location = "?m=settings_profile_edit&id=" + ids;		
}
</script>
            <!-- /.row -->
           <br> <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Configuraciones
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#home" data-toggle="tab">Usuarios</a>
                                </li>
                                <li><a href="#profile" data-toggle="tab">Perfiles</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="home">
						            <div class="row">
						                <div class="col-lg-12">
						                    <div class="panel panel-default">
						                        <div class="panel-heading">
						                            Listado de usuarios registrados | <a href="main.php?m=settings_user_add">Agregar usuario</a>
						                        </div>
						                        <!-- /.panel-heading -->
						                        <div class="panel-body">
						                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
						                                <thead>
						                                    <tr>
						                                        <th>Usuario</th>						                                        
						                                        <th>Estatus</th>
						                                        <th>Acciones</th>
						                                    </tr>
						                                </thead>
						                                <tbody>
						                                	<?php if (isset($json_data->userlist)){ ?>
						                                		<?php for ($x = 0; $x < sizeof($json_data->userlist); $x++){ ?>						                                
							                                    <tr class="odd gradeX">
							                                        <td><?php echo $json_data->userlist[$x]->nombres ?></td>							                                        
							                                        <td><?php echo $json_data->userlist[$x]->activo ?></td>
							                                        <td class="center"><button type="button" class="btn btn-primary btn-circle" title="Editar" onclick="doEditUser(<?php echo $json_data->userlist[$x]->id ?>);"><i class="fa fa-list"></i></button>&nbsp;<button type="button" class="btn btn-warning btn-circle" title="Eliminar" onclick="doDeleteUser(<?php echo $json_data->userlist[$x]->id ?>);"><i class="fa fa-times"></i></button></td>
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
							                                        <td class="center"><button type="button" class="btn btn-primary btn-circle" title="Editar" onclick="doEditProfile('<?php echo $json_data2->profilelist[$x]->id ?>');"><i class="fa fa-list"></i></button>&nbsp;<button type="button" class="btn btn-warning btn-circle" title="Eliminar" onclick="doDeleteProfile('<?php echo $json_data2->profilelist[$x]->id ?>');"><i class="fa fa-times"></i></button></td>
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