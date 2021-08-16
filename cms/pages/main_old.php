<?php
	// ****************************************
	// proyect: cms mobile
	// version: 1.0a
	// date: 19-01-2019
	// module: login validation
	// author: Humberto Suarez
	// ****************************************
	session_start();
	// security check, not annonymous allowed in here.
	if (!isset($_SESSION["uid"])){
		header("Location: login.html?error=2");
	}
	include("../webservices/connClass.php");
	include ("../webservices/dataService.php");
	$module = "";
	$module = @$_GET['m'];
	$dataServ = null;
    $dataServ = new dataService();	
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="CMS LASER AIRLINES">
    <meta name="author" content="Humberto Suarez - hsuarezx@gmail.com">

    <title>Manejador de Contenidos Movil - LASER AIRLINES</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="../vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

	<script type="text/javascript" src="../tinymce/jscripts/tiny_mce/tiny_mce.js"></script>	
	
	    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <script type="text/javascript">
        tinyMCE.init({
        		theme : "advanced",
                mode : "textareas",
				selector : "textarea.editor"
        });
    </script>

</head>
<script>
var wheretogo = "";
var wheretogoyes = "";
var wheretogono = "";
function showErrorMessage(errormsg){
	document.getElementById("errormsg").style.display = "block";
	document.getElementById("errormsgtext").innerHTML = errormsg;
}
function closeErrorMessage(){
	document.getElementById("errormsg").style.display = "none";
}
function showSuccessMessage(){
	document.getElementById("successmsg").style.display = "block";
}
function closeSuccessMessage(){
	document.getElementById("successmsg").style.display = "none";
}
function showQuestionMessage(message){
	document.getElementById("questionmsgtitle").innerHTML = message;
	document.getElementById("questionmsg").style.display = "block";
}
function closeQuestionMessage (){
	document.getElementById("questionmsg").style.display = "none";
}

</script>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0; background-color: white;">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar" style="background-color:#f0ad4e; !IMPORTANT"><span id="userinfo"></span></span>
                    <span class="icon-bar" style="background-color:#f0ad4e; !IMPORTANT"></span>
                    <span class="icon-bar" style="background-color:#f0ad4e; !IMPORTANT"></span>
                </button>
                <a class="navbar-brand"><img src="../imgs/logo.png" style="float: left;top: 3px; position: absolute; left: 10px; height: 55px;"></a>
            </div>
            <!-- /.navbar-header -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
						<?php  if ($dataServ->checkpermiso("configuraciones")){ ?>
                    	<li><a href="main.php?m=settings"><i class="fa fa-wrench fa-fw"></i>Configuraciones</a></li>                    	
						<?php  } ?>
						<?php  if ($dataServ->checkpermiso("vitrina")){ ?>
                    	<li><a href="main.php?m=vitrina"><i class="fa fa-wrench fa-fw"></i>Vitrinas</a></li>                    	
						<?php  } ?>
						<?php  if ($dataServ->checkpermiso("tarifa")){ ?>
                    	<li><a href="main.php?m=tarifa"><i class="fa fa-wrench fa-fw"></i>Tarifas</a></li>                    	
						<?php  } ?>
						<?php  if ($dataServ->checkpermiso("noticia")){ ?>
                    	<li><a href="main.php?m=noticia"><i class="fa fa-wrench fa-fw"></i>Noticias</a></li>                    	
						<?php  } ?>						
		                <li><a href="closeSession.php"><i class="fa fa-sign-out fa-fw"></i>Cerrar Sesi&oacute;n</a></li> 		                
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
        <?php 
        	if (isset($module) && $module != ""){
        		include ("modules/".$module.".php");
        	}else{
        		include ("modules/trans.php");        		
        	}
        	//echo "modules/".$module.".php";
        ?>        	     
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <div id="successmsg" class="modal-content" style="display:none; top:30%; float: left; position: absolute; left: 10%; z-index: 999; width: 80%;"> 
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Mensaje del sistema</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true" onclick="javascript:closeErrorMessage();">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="successmsgtitle" style="display:inline-block; text-align:center; width:100%; font-size:16px; font-weight:normal; font-family: verdana; padding: 10px;">Operación Exitosa</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="javascript:closeSuccessMessage();window.location=wheretogo;">Close</button>
      </div>
    </div> 
    <div id="questionmsg" class="modal-content" style="display:none; top:30%; float: left; position: absolute; left: 10%; z-index: 999; width: 80%;"> 
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pregunta del sistema</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true" onclick="javascript:closeErrorMessage();">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="questionmsgtitle" style="display:inline-block; text-align:center; width:100%; font-size:16px; font-weight:normal; font-family: verdana; padding: 10px;"></div>
      </div>
      <div class="modal-footer">
		<button type="button" class="btn btn-default"  style="display: inline-block" onclick="javascript:closeQuestionMessage();window.location=wheretogoyes;">SI</button>
		<button type="button" class="btn btn-default" style="display: inline-block" onclick="javascript:closeQuestionMessage();window.location=wheretogono;">NO</button>
      </div>
    </div>   
    <div id="errormsg" class="modal-content" style="display:none; top:30%; float: left; position: absolute; left: 10%; z-index: 999; width: 80%;"> 
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ha ocurrido un error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true" onclick="javascript:closeErrorMessage();">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="errormsgtext" style="display:inline-block; text-align:center; width:100%; font-size:16px; font-weight:normal; font-family: verdana; padding: 10px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="javascript:closeErrorMessage();">Close</button>
      </div>
    </div>   
    
    


    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <!-- <script src="../vendor/raphael/raphael.min.js"></script> -->
    <!-- <script src="../vendor/morrisjs/morris.min.js"></script> -->
    <!-- <script src="../data/morris-data.js"></script> -->

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>

</html>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <!-- <script src="../vendor/raphael/raphael.min.js"></script> -->
    <!-- <script src="../vendor/morrisjs/morris.min.js"></script> -->
    <!-- <script src="../data/morris-data.js"></script> -->

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
</body>

</html>