<?php	
	if( isset($_SESSION['id_usuario']) ){
		header('Location:/index.php');
	}

	$msg_error = '&nbsp;';
	if( isset($_POST['submit']) ){

		$username = $_POST['rut'];
		$password = $_POST['clave'];

		$conexion = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=creativex") or die('No se pudo conectar: ' . pg_last_error());
		$q = "SELECT rut, contrasena FROM usuario WHERE rut='$username'";
		$r = pg_query($q) or die(pg_last_error());

		if( $row = pg_fetch_assoc($r) ){
			if( $row['contrasena'] == $password ){
				$_SESSION['id_usuario'] = $r['rut'];

				pg_free_result($r);
				pg_close($conexion);
				header('Location:');
			}
			else{
				$msg_error = "Clave erronea.";
			}
		}else{
			$msg_error = "Usuario no existe.";
		}
		pg_free_result($r);
		pg_close($conexion);
	}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>Login Jim 2014</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="css/default.css">
	</head>
	<body>
		<div id="login_box">
			<h1>Login</h1>
			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<input type="text" name="rut" placeholder="Rut Usuario" autocomplete="off">
				<input type="password" name="clave" placeholder="Clave">
				<button type="submit" name="submit" value="ingresar">Ingresar</button>
				<?php echo $msg_error; ?>
			</form>
		</div>
	</body>
	
</html>