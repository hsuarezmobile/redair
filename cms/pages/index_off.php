<?php 
	include ("clases/operaciones_basicas.php");
	include ("includes/dbconn.php");
	header('Content-Type: text/html; charset=UTF-8');
	$error_login=false;	
	if ($_POST){
		//--> leemos nombre de usuario y contraseña
		$username=$_POST['username'];
		$password=$_POST['password'];
		//--> ciframos el password
		$cifrado=strtolower(substr(base64_encode($password), 0, 3)."*".substr(md5($password), 0, 3));
		$rs_db_0 = $rs->select("usuario_id", "cms_usuarios", "usuario_username = '".$username."' and usuario_pwd = '".$cifrado."' and usuario_activo = 'S'", "");
		echo $rs->query;
		if ($row_db_0 = $rs->fetch($rs_db_0)){
			$remote_ip = "";
			$remote_host = "";
			$remote_ip = $_SERVER['REMOTE_ADDR'];
			$remote_host = $_SERVER['HTTP_USER_AGENT'];

			$rs->insert("cms_log", "usuario_id, log_descripcion, log_fechahora, log_remotehost, log_remoteip", $row_db_0['usuario_id'].", 'Inicio de sesion', NOW(), '".$remote_host."', '".$remote_ip."'");
?>
			<script>
				window.location="nucleo.php?uid=<?php echo base64_encode($row_db_0['usuario_id']); ?>";
			</script>
<?php 				
		}else{
			$error_login=true;			
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Manejador de Contenidos Movil - Cinex Venezuela</title>
<meta name="robots" content="noindex" />
<link rel="shortcut icon" href="" />
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.tools.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.0.5"></script>
<link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=2.0.5"></script>
<link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=2.0.5"></script>
</head>
<script type="text/javascript">
	function error(tipo){
		$.fancybox(		
			{
        	'autoDimensions'	: false,
			'width'         	: 420,
			'height'        	: 252,
			'transitionIn'		: 'elastic',
			'transitionOut'		: 'elastic',
			'href'              : 'msgerror.php?tipo=' + tipo,
			'title'             : '',
			'type'              : 'iframe'
			}
		);
	}
	function validar_form(){
		if (document.getElementById('username').value == ""){
			error('1');
			document.getElementById('username').focus();		
		}else if (document.getElementById('password').value == ""){
			error('2');
			document.getElementById('password').focus();					
		}else{
			document.getElementById('form_login').action = "index.php";
			document.getElementById('form_login').submit();
		}
	}		
</script>

<body>
<form method="post" action="javascript:validar_form();" id="form_login" name="form_login">
  <table cellspacing="5" align="center" style="margin:0px auto; width:400px; border:2px solid #CCCCCC; background:#FFF; margin-top:15%">
    <tr>
      <td colspan="2" align="center" style="background-color:#000000" ><center>
        <img src="imgs/logo_cinexTudesconex-mag.png" width="264" height="75">
      </center></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><center>Inicie sesi&oacute;n con su nombre de usuario y contrase&ntilde;a.</center></td>
    </tr>
    <tr>
      <td width="138" align="right"><div align="right">Usuario&nbsp;:&nbsp;</div></td>
      <td width="239"><input name="username" type="text" id="username" size="30" maxlength="20" onkeyup = "if(event.keyCode == 13) validar_form()" /></td>
    </tr>
    <tr>
      <td align="right"><div align="right">Contrase&ntilde;a&nbsp;:&nbsp;</div></td>
      <td><input name="password" type="password" id="password" size="30" maxlength="20"  onkeyup = "if(event.keyCode == 13) validar_form()" /></td>
    </tr>
    <tr>
      <td align="right">&nbsp;</td>
      <td><input type="button" name="boton" id="boton" value="Aceptar" onclick="javascript:validar_form();" /></td>
    </tr>
    <tr>
      <td colspan="2"></td>
    </tr>
  </table>
  <br /><br />
  <div style="text-align:center; width:100%">
  <strong class="txt_small">Administrador de contenidos </strong> <span class="txt_small"><strong>|</strong> </span><span class="linkcreditos">2017 Suramericana de espectáculos S.A. RIF: J-00045832-4 © Copyright 2017. Cinex. Todos los derechos reservados</span>
  </div>
</form>
<?php if ($error_login){ ?>
<script type="text/javascript">
   	error(3);
</script>
<?php } ?>
<!-- hsc 2017 -->
</body>
</html>
