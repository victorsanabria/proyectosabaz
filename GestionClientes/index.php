 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Software de Gestion de Clientes</title>
<style type="text/css" >
	@import url("css/animate.css");
	@import url("css/index.css");
</style>

<?php
	session_start();
	if(isset($_GET['mensaje'])){
		$mensaje = $_GET['mensaje'];
		if ($mensaje == 'despedida') {
			$msj = "Vuelva pronto, lo estaremos esperando...";
		}elseif($mensaje == 'error01'){
			$msj = "Error en usuario y/o contraseña. Vuelva a intentarlo.";
		}elseif($mensaje == 'error02'){
			$msj = "Usted debe ingresar al portal de forma correcta !!";
		}
		unset ($_GET['mensaje']);
	}else{
		$msj = "";
	}
	session_destroy();
?>
</head>
<body>
<div class='form animated flipInX'>
	<center>
		<h6 class="animated infinite pulse"><strong><?php echo $msj; ?></strong></h6>
                <img src="images/logo.jpg" alt="Gestión Total" style="width:250px" />
	</center>
	<br />
	<form id="formulario" action="controller/pasarela.php" method='post'>
		<input id="usr" name="usuario" placeholder='Usuario' type='text' required="required">
		<input id="pwd" name="password" placeholder='Contraseña' type='password' required="required">
        <button>Ingresar</button>
	</form>
    <?php 
	
?>
</div>

</body>
</html>
