<!--/
    SCRIPT PASARELA
    Verifica si viene del index
    Inicia la sesion
    Encrypta el password
    Procesa, el password y el usuario, con la clase CapturaInformacion   
/-->
<?php
	if(isset($_POST["usuario"])){
		session_start();
		$usr = $_POST['usuario'];
		$pwd = sha1($_POST['password']);
		include '../class/CapturaInformacion.class.php';
                $modulo = new CapturaInformacion();
                $_SESSION['usuario']=$usr;
                if($modulo->identificar($usr,$pwd)==true){
                    header('Location: ../inicio.php');					
		}else{
                    header("Location: ../index.php?mensaje=error01");
		}
	}else{
		header("Location: ../index.php?mensaje=error02");
	}
?>
    