<?php 
$json_menucontent = array();
$json_menucontent2 = array();
$dataServ = null;
$dataServ = new dataService();
$json_menucontent = json_decode($dataServ->getContentsByType('0'));
$json_menucontent2 = json_decode($dataServ->getContentsByType('1'));
?>
<!-- HSC 2020 -->
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navigation">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a id="logoredair" class="navbar-brand" href="index.php"><img id="logolaserimg" src="assets/img/logo.png" alt="" style="height:44px;"></a></div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse yamm" id="navigation">
                  
                    <ul class="main-nav nav navbar-nav navbar-right">
                     <li class="dropdown ymm-sw " data-wow-delay="0.1s">
                            <a href="#" class="dropdown-toggle " data-toggle="dropdown" data-hover="dropdown" data-delay="200">Experiencia RED<b class="caret"></b></a>
                            <ul class="dropdown-menu navbar-nav">
                                <?php if (isset($json_menucontent2)){
                                    for ($x = 0; $x < sizeof($json_menucontent2->data); $x++){
                                        $url = "";
                                        $url = "generic.php?id=".$json_menucontent2->data[$x]->id;
                                        ?>
									<li>
                                    <a href="<?php echo $url ?>"><?php echo $json_menucontent2->data[$x]->nombre ?></a>
                                </li>
								<?php } } ?>

                       </ul>
                      </li>

                     
                        <!--<li class="wow fadeInDown" data-wow-delay="0.1s"><a class="menuitem" href="checkin.php">Check In </a></li>-->
						
						
					<li class="dropdown ymm-sw " data-wow-delay="0.1s">
                            <a href="#" class="dropdown-toggle " data-toggle="dropdown" data-hover="dropdown" data-delay="200">Antes de viajar <b class="caret"></b></a>
                            <ul class="dropdown-menu navbar-nav">
                                <?php if (isset($json_menucontent)){
                                    for ($x = 0; $x < sizeof($json_menucontent->data); $x++){
                                        $url = "";
                                        $url = "generic.php?id=".$json_menucontent->data[$x]->id;
                                        ?>
									<li>
                                    <a href="<?php echo $url ?>"><?php echo $json_menucontent->data[$x]->nombre ?></a>
                                </li>
								<?php } } ?>

                            </ul>
                        </li>
						
						<li class="dropdown ymm-sw " data-wow-delay="0.1s">
                            <a href="#" class="dropdown-toggle " data-toggle="dropdown" data-hover="dropdown" data-delay="200">Atención al Cliente <b class="caret"></b></a>
                            <ul class="dropdown-menu navbar-nav">
                                <li>
                                    <a href="contacto.php">Contáctenos </a>
                                </li>
								
								<li>
                                    <a href="generic.php?id=26">Puntos de Venta y oficinas</a>
                                </li>
								
								<li>
                                    <a href="noticias.php">Noticias</a>
                                </li>
								
                            </ul>
                        </li>
						
					
						
						  <div class="button navbar-right">
<?php if (!isset($_SESSION["uid"]) || @$_SESSION["uid"] == ""){ ?>						  
                        <button id="loginButton" class="navbar-btn nav-button wow bounceInRight login" onclick="javascript:showLogin();" data-wow-delay="0.4s">Login</button>
                        <button id="registerButton" class="navbar-btn nav-button wow fadeInRight" onclick="javascript:showRegister();" data-wow-delay="0.5s">Registro</button>
<?php } ?>						
						<!-- <div id="userInfo" style="display:none;position: absolute;font-size: 12px;font-weight: bold;float: left;margin-top: -21px;left: 74%;"></div> -->
						
					<!--	<button class="btn  toggle-btn" type="button"><i class="fa fa-bars"></i></button>-->
						
				 		<button class="wow fadeInRigh"  type="submit" onclick="javascript:window.location='finder.php';"><i class="fa fa-search"></i></button>
					<!-- 	<button class="wow fadeInRigh" type="submit"><img src="assets/img/reino-unido.svg" width="18px" height="18px" alt="inglés"></button>  -->
                    </div>
 
                  </ul>
					
					
					
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <!-- End of nav bar -->
