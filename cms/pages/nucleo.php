<?php 
session_start();
header("Content-Type: text/html; charset=utf-8");
$str="";
htmlspecialchars($str, ENT_NOQUOTES, "UTF-8");
include ("includes/creditos.txt"); 
include ("clases/operaciones_basicas.php");
include ("includes/dbconn.php");
$nombreuser = "";
$nombreuser = @$_SESSION['nombres'];
$idmenux = "";
$idmenux = @$_GET['idmenux']; // --> contiene el id del menu, para extenderlo by default
$idx="";
$idx = @$_GET['idx']; // --> contiene el id del submenu, para fines de permisologia en 2 capa
$uid = "";
$uidx = "";
$idmenu = "";
$uid = @$_GET['uid'];
$uidx = @$_GET['uid'];
$perfil_id = "";

//forzar a usar utf8 en los querys de la db.
mysql_query("SET NAMES utf8;");
if (isset($uid) && $uid != ""){
	$uidx = base64_decode($uid);
	$rs_db_0 = $rs->select("*", "cms_usuarios", "usuario_id=".$uidx, "");
	if ($row_db_0 = $rs->fetch($rs_db_0)){	
		$swd_username = $row_db_0['usuario_username'];
		$nombres = $row_db_0['usuario_nombres']." ".$row_db_0['usuario_apellidos'];
		$swd_user_id = $row_db_0['usuario_id'];
		$perfil_id = $row_db_0['perfil_id'];
	}
}else{
?>
	<script type="text/javascript">
		window.alert("Debe iniciar sesión para poder usar el sistema.");
		window.location = "index.php";
	</script>	
<?php
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">  
<link href="css/estilos.css" rel="stylesheet" type="text/css" />
<title>Administrador de Contenidos - Cinex Venezuela</title>
<link rel="stylesheet" href="thickbox/thickbox.css" type="text/css" media="screen" />
<script type="text/javascript" src="thickbox/jquery.js"></script>
<script type="text/javascript" src="thickbox/thickbox.js"></script>
<script src="js/jquery.tools.min.js"></script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
<link rel="stylesheet" href="fancybox/source/jquery.fancybox.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/jquery.fancybox.pack.js?v=2.0.5"></script>
<link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-buttons.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-buttons.js?v=2.0.5"></script>
<link rel="stylesheet" href="fancybox/source/helpers/jquery.fancybox-thumbs.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="fancybox/source/helpers/jquery.fancybox-thumbs.js?v=2.0.5"></script>
<script language="JavaScript" src="js/validaciones.js"></script>
<script type="text/javascript" src="tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="select2/select_dependientes2.js"></script>
<link rel="stylesheet" href="colorbox/example4/colorbox-cinex-blanco.min.css" />
<script type="text/javascript" language="javascript" src="colorbox/jquery.colorbox-min.js"></script>
<script type="text/javascript">
tinyMCE.init({
		theme : "advanced",
        mode : "textareas"
});
</script>
<style type="text/css">
body {
	margin-top: 6px;
	background-color: #ececec;
}
.fancybox-outer{
    width: 500px;
    height: 200px;
}
</style>
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
			'href'              : 'msgerror.php?tipo=' + tipo + '&idx=<?php echo $idx ?>&idmenux=<?php echo $idmenux ?>&uid=<?php echo $uid ?>',
			'title'             : '',
			'type'              : 'iframe'
			}
		);
	}
	function mensaje(tipo){
		$.fancybox(		
			{
        	'autoDimensions'	: false,
			'width'         	: 420,
			'height'        	: 252,
			'transitionIn'		: 'elastic',
			'transitionOut'		: 'elastic',
			'href'              : 'msgnormal.php?tipo=' + tipo + '&idx=<?php echo $idx ?>&idmenux=<?php echo $idmenux ?>&uid=<?php echo $uid ?>',
			'title'             : '',
			'type'              : 'iframe'
			}
		);
	}	
	function borrar(tipo, erid, s){
		$.fancybox(		
			{
        	'autoDimensions'	: false,
			'width'         	: 420,
			'height'        	: 252,
			'transitionIn'		: 'elastic',
			'transitionOut'		: 'elastic',
			'href'              : 'msgpregunta.php?tipo=' + tipo + '&erid=' + erid + '&s=' + s + '&idx=<?php echo $idx ?>&idmenux=<?php echo $idmenux ?>&uid=<?php echo $uid ?>',
			'title'             : '',
			'type'              : 'iframe'
			}
		);
	}
	function previewboletin(url){
		$.fancybox(		
			{
        	'autoDimensions'	: false,
			'width'         	: 420,
			'height'        	: 252,
			'transitionIn'		: 'elastic',
			'transitionOut'		: 'elastic',
			'href'              : url,
			'title'             : '',
			'type'              : 'iframe'
			}
		);
	}	
	function up(ids){
		document.getElementById(ids).style.display="none";
	}
	function down(ids){
		document.getElementById(ids).style.display="block";
	}
	function updown(ids){
		if (document.getElementById('d' + ids).style.display=="block"){
			document.getElementById('d' + ids).style.display="none";
			document.getElementById('imgx' + ids).src="img/adown.png";
			document.getElementById('imgx' + ids).title="Haga click para desplegar";
		}else if (document.getElementById('d' + ids).style.display=="none"){
			document.getElementById('d' + ids).style.display="block";
			document.getElementById('imgx' + ids).src="img/aup.png";
			document.getElementById('imgx' + ids).title="Haga click para replegar";			
		}
	}
	function loader(mensaje){
		$.colorbox({html:"<div style='padding-top:20px'><center><img src='img/loader_cinex_1.gif' height='100px' width='100px'></center><br><h1 style='font-size:14px; font-weight:bold; color: black;'><center>"+mensaje+"</center></h1></div>", fixed:true, overlayClose: false, closeButton: false, scrolling: false, iframe: false, width: "400px", height: "250px"});
	}
	function mensaje_success(mensaje){
		$.colorbox({html:"<div style='padding-top:20px'><center><img src='img/success.png' height='100px' width='100px'></center><br><h1 style='font-size:14px; font-weight:bold; color: black;'><center>"+mensaje+"</center></h1><br><center><a href='javascript:$.colorbox.close();'>Cerrar</a></center></div>", fixed:true, overlayClose: false, closeButton: false, scrolling: false, iframe: false, width: "400px", height: "300px"});
	}
	function mensaje_error(mensaje){
		$.colorbox({html:"<div style='padding-top:20px'><center><img src='img/error.png' height='100px' width='100px'></center><br><h1 style='font-size:14px; font-weight:bold; color: black;'><center>"+mensaje+"</center></h1><br><center><a href='javascript:$.colorbox.close();'>Cerrar</a></center></div>", fixed:true, overlayClose: false, closeButton: false, scrolling: false, iframe: false, width: "400px", height: "300px"});
	}	
    function cerrarloader() {
    	return $.colorbox.close();
    }	
</script>
<body>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0" style="border-width:1px; border-style:solid; border-color:#ebebeb; -moz-border-radius:4px; -webkit-border-radius:4px;">
  <tr>
    <td><table width="900" border="0" cellspacing="0" cellpadding="0" style="background-repeat:repeat-x;">
      <tr style="background-color:#000000">
        <td width="720" height="71" align="left" valign="middle" style="padding-left:4px;"><img src="https://www.cinex.com.ve/img/logo_cinexTudesconex-mag.png" width="264" height="75"></td>
        <td width="180" align="left" valign="top"><table width="180" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="img/space.gif" width="5" height="5" /></td>
          </tr>
          <tr>
            <td class="linkcreditos" style="color:white">Bienvenido(a):</td>
          </tr>
          <tr>
            <td class="texto_titulo" style="color:white"><img src="img/space.gif" width="5" height="5" /></td>
          </tr>
          <tr>
            <td class="texto_titulo" style="color:white"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="12%"><img src="img/user.png" width="16" height="16" /></td>
                <td width="88%" class="linkcreditos" style="color:white"><strong><?php echo $nombres; ?></strong></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><img src="img/space.gif" width="5" height="5" /></td>
          </tr>
          <tr>
            <td align="left" style="color:white"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="12%" align="left" style="color:white">>></td>
				<td width="88%" align="left">&nbsp;<a href="nucleo.php?p=perfil&idmenux=<?php echo $idmenu ?>&idx=<?php echo $idx ?>&uid=<?php echo $uid?>&uidx=<?php echo $uidx?>" class="link_user" style="color:white">Mi Perfil</a></td>		  
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><img src="img/space.gif" width="5" height="5" /></td>
          </tr>		  
          <tr>
            <td align="left style="color:white"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="12%" align="left" style="color:white">>></td>
				<td width="88%" align="left">&nbsp;<a href="index.php" class="link_user" style="color:white" >Cerrar mi sesi&oacute;n</a></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td><img src="img/space.gif" width="5" height="5" /></td>
          </tr>		  
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left"><img src="img/space.gif" width="5" height="5" /></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#666666"><img src="img/space.gif" width="5" height="2" /></td>
  </tr>
  <tr>
    <td align="left"><img src="img/space.gif" width="5" height="5" /></td>
  </tr>
  <tr>
    <td align="left"><table width="890" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="200" align="left" valign="top"><table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
<?php	
		$idpermisos = "";
		$rs_db_1 = $rs->select("*", "cms_menus", "menu_activo = 'S'", "order by menu_orden asc");	
		while ($row_db_1 = $rs->fetch($rs_db_1)){
			$idmenu=$row_db_1['menu_id'];
?>        
        <!-- INICIO ITEMS -->
          <tr>
            <td height="25" background="img/menu_bg.gif" style="padding-left:4px; cursor:pointer;" onclick="javascript:updown('<?php echo $idmenu ?>');" alt="Haga click para desplegar"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="90%" align="left"><strong><?php echo utf8_decode($row_db_1['menu_nombre']) ?></strong></td>
                <td width="10%" align="left"><img id="imgx<?php echo $idmenu ?>" name="imgx<?php echo $idmenu ?>" src="img/adown.png" width="16" height="16" border="0" /></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td bgcolor="#ffffff"  style="border-width:1px; border-style:solid; border-color:#ebebeb; -moz-border-radius:4px; -webkit-border-radius:4px;">
            <div id="d<?php echo $idmenu ?>" name="d<?php echo $idmenu ?>" style="display:none;">
            <table width="190" border="0" align="center" cellpadding="0" cellspacing="0">
			<?php					
                    $rs_db_2 = $rs->select("*", "cms_submenus", "submenu_activo = 'S' and menu_id = ".$row_db_1['menu_id'], "order by submenu_orden asc");	
                    while ($row_db_2 = $rs->fetch($rs_db_2)){
						$conpermiso = false;
						$rs_db_3 = $rs->select("perfil_permisos", "cms_perfiles", "perfil_id=".$perfil_id, "");	
						if ($row_db_3 = $rs->fetch($rs_db_3)){
							$idpermisos = explode(",", $row_db_3['perfil_permisos']);
							for ($i = 0; $i < sizeof($idpermisos); $i++){
								if ($idpermisos[$i] == $row_db_2['submenu_id']){
									$conpermiso = true;
									break;
								}
							}
					    if ($conpermiso){ // --> si tengo permiso, agregalo...
            ?>        
            <!-- INICIO SUBITEMS -->
              <tr>
                <td width="17" height="15" align="left" valign="middle" bgcolor="#FFFFFF"><img src="img/arrow_black.gif" width="10" height="10" /></td>
                <td width="173" height="20" align="left" valign="middle" bgcolor="#FFFFFF"><a href="nucleo.php?p=<?php echo $row_db_2['submenu_modulo'] ?>&idmenux=<?php echo $idmenu ?>&idx=<?php echo $row_db_2['submenu_id'] ?>&uid=<?php echo $uid?>" <?php if ($row_db_2['submenu_id'] != $idx){ ?>class="link_txt"<?php }else{ ?>class="link_sel"<?php } ?>><?php echo utf8_decode($row_db_2['submenu_nombre']) ?></a></td>
              </tr>
             <!-- FIN SUBITEMS -->
			<?php    }
				}
		} ?>             
            </table>
            </div>
            </td>
          </tr>
          <!-- FIN ITEMS -->
<?php   } ?>          
        </table></td>
        <td width="800" align="right" valign="top" style="padding-left:10px;">
<?php
		$p="";
		$p=@$_GET['p'];		
		if ($p != ""){
			include("modulos/".$p.".php");
		}else{
		    if ($perfil_id == "1"){
			     include("modulos/resumen.php");
		    }
		}
?>
<br /></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left"><img src="img/space.gif" width="5" height="5" /></td>
  </tr>
  <tr>
    <td align="left" bgcolor="#666666"><img src="img/space.gif" width="5" height="2" /></td>
  </tr>
  <tr>
    <td align="left"><img src="img/space.gif" width="5" height="5" /></td>
  </tr>
  <tr>
    <td align="left" valign="top"><center>
      <strong class="txt_small">Administrador de contenido </strong> <span class="txt_small"><strong>|</strong> </span><span class="linkcreditos">2017 Suramericana de espectáculos S.A. RIF: J-00045832-4 </span><span class="txt_small">|</span>&nbsp;<span class="linkcreditos">© Copyright 2017. Cinex.</span></center></td>
  </tr>
  <tr>
    <td align="left" valign="top"><img src="img/space.gif" width="5" height="10" /></td>
  </tr>
</table>
<?php 
	if ($idmenux != ""){
?>
		<script type="text/javascript">javascript:updown('<?php echo $idmenux ?>');</script>
<?php			
	}
?>
</body>
</html>
