<?php
session_start();
include 'class/CapturaInformacion.class.php';
if (!isset($_SESSION['usuario'])) {
    //si no existe usuario
    header('Location: pages/AccesoDenegado.php');
} else {
    $Asesor = $_SESSION['usuario'];
    $modulo = new CapturaInformacion();
    $result = $modulo->getDatosUsuario($Asesor);
   
    if (sizeof($result) == 0) {
        header('Location: pages/AccesoDenegado.php');
    } else {
        $nombre = ucwords(strtolower(utf8_encode($result[0]['nombre'])));
        $perfil = $result[0]['perfil'];
        $menu = $modulo->getMenuCompleto($result[0]['perfil'], $Asesor);
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta charset="UTF-8">
                <meta http-equiv="content-type" content="text/html; charset=UTF8">
                <title>Gestion de Clientes</title>
                <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
                <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
                <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" /> 
                <link href="css/Red.css" rel="stylesheet" type="text/css" /> 
                <script src="js/jquery1.9.js"></script>    
                <script src="compatibility/respond.min.js"></script>				   
                <script src="compatibility/html5shiv.js"></script>				   
                <script src="js/bootstrap.min.js" type="text/javascript"></script>            
                <script src="js/AdminLTE/app.js" type="text/javascript"></script>  
            </head>
            <body class="skin-blue">      
                <header class="header">
                    <a href="inicio.php" class="logo">             
                        <!-- imagen campaña-->
                       <img src="images/VYS.png" style="width:100%;height: 100px"/> 
                    </a>
                    
                    <nav class="navbar navbar-static-top" role="navigation" align="center">     
<!--                        <img src="images/Banner_2.png" style="width:700px;height:100px" align="center"/> -->
                      <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button"> 
                            <span class="sr-only">Toggle navigation</span> 
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <div class="navbar-right">
                                <ul class="nav navbar-nav">
                                    <li class="dropdown user user-menu">
                                        <a href="#" class="dropdown-toggle " data-toggle="dropdown">
                                            <font color='#F9F9F9'><i class="glyphicon glyphicon-user"></i></font>
                                            <span><font color='#F9F9F9'><?php echo $nombre ?><i class="caret"></i></font></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <!-- User image -->
                                            <li class="user-header bg-light-blue">     
<!--                                              <img src="http:/images/VYS.png" style="width: 80%;height: 60px" alt="User Image" />-->
                                                <br/>
                                                <br/>
                                                <p>
                                                    <font color='#0C223F'><?php echo $nombre . '-' . $perfil; ?></font>
                                                    <small><font color='#0C223F'>Logeado desde <?php echo $hoy = date("g:i a"); ?></font></small>
                                                </p>
                                            </li>                                
                                            <!-- Menu Footer-->
                                            <li class="user-footer">                                 
                                                <div class="pull-right">
                                                    <a href="index.php" class="btn btn-default btn-flat">Salir</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                    </nav>
                </header>
                <div class="wrapper row-offcanvas row-offcanvas-left">           
                    <aside class="left-side sidebar-offcanvas">               
                        <section class="sidebar">               
                            <div class="user-panel">
                                <div class="pull-left info">
                                    <p>Hola, <?php echo ($nombre); ?></p>
                                    <a><i class="fa fa-circle text-success"></i> En linea</a>
                                </div>
                            </div>                   
                            <ul class="sidebar-menu">
                                <!--Aca se carga el menu php-->
                                <?php echo utf8_encode($menu) ?>
                                <!-- fin menu-->
                            </ul>
                        </section>
                        <div style="position: fixed; bottom: 0; width: 100%">
                            <table>
                                <tr>
                                    <td>
                                        <img src="img/chrome.png" width="20" height="20"/> 
                                    </td>
                                    <td>
                                        <h6> <font color="#666666"> Para mejor Funcionamiento Utilizar:<br/> -Google Chrome<br/></h6>
                                    </td>
                                </tr>
                            </table>
                        </div>    
                    </aside>         
                    <aside class="right-side"> 
                        <iframe src="pages/blanco.php" name="centerframe" align="center" frameBorder=0 width="82%" style="height: 90%;position: absolute;overflow-x: auto;" frameSpacing=0>
                        </iframe> 
                    </aside>
                </div>
            </body>
        </html>
        <?php
    }
}
?>