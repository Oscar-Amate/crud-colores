<?php

// ============================================
// ÓSCAR AMATE
// ============================================

include_once 'conexion.php'; 
include_once 'functions/functions.php';
session_start();

// Leer
$sql_leer = "SELECT * FROM colores";
$gsent = $pdo->prepare($sql_leer);
$gsent->execute();
$resultado = $gsent->fetchAll();

// Agregar
if(!empty($_POST)) {

	$color = isset($_POST['color']) ? strtolower($_POST['color']) : false;
	$descripcion = isset($_POST['descripcion']) ? strtolower($_POST['descripcion']) : false;

	

	$mensaje = false;

	if($color && $descripcion) {
		if($color == 'azul' || $color == 'rojo' || $color == 'amarillo' || $color == 'verde' || $color == 'celeste' || $color == 'ligero' || $color == 'negro') {
			$sql_agregar = "INSERT INTO colores VALUES(NULL, ?, ?);";
			$sentencia_agregar = $pdo->prepare($sql_agregar);
			$sentencia_agregar->execute(array($color, $descripcion));
			header('Location:index.php');
		} else {
			$mensaje = 'El color no coincide con ninguno.';
		}
		
	} else {
		$mensaje = 'Los campos no pueden estar vacíos.';
	}

	// Cerrar conexión
	$sentencia_agregar = null;
	$pdo = null;
}


if($_GET) {

	$id = $_GET['id'];
	$sql_unico = "SELECT * FROM colores WHERE id = ?";
	$gsent_unico = $pdo->prepare($sql_unico);
	$gsent_unico->execute(array($id));
	$resultado_unico = $gsent_unico->fetch();

	// Cerrar conexión
	$gsent_unico = null;
	$pdo = null;
	
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Ejercicio YT_colores</title>
	<link rel="stylesheet" href="assets/css/styles.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.2/css/all.css" integrity="sha384-rtJEYb85SiYWgfpCr0jn174XgJTn4rptSOQsMroFBPQSGLdOC5IbubP6lJ35qoM9" crossorigin="anonymous">
</head>
<body>
	<div class="container">

		<div class="filas">
			<div class="columnas">

				<?php foreach ($resultado as $dato): ?>
					<div class="alerta <?=$dato['color'];?>">
						<?=$dato['color'];?> - <?=$dato['descripcion'];?>
						<a href="eliminar.php?id=<?=$dato['id'];?>">
							<i class="fas fa-trash-alt"></i>
						</a>
						<a href="index.php?id=<?=$dato['id'];?>">
							<i class="fas fa-pen"></i>
						</a>
						
					</div>
				<?php endforeach; ?>
			</div>

			<div class="columnas">
				<?php if(!$_GET): ?>
					<h2>Agregar elementos</h2>
					<form class="form" method="post">
						<input type="text" name="color" placeholder="Color...">
						<input type="text" name="descripcion" placeholder="Descripción...">
						<button class="">Agregar</button>
						<?php if(isset($mensaje)): ?>
							<p><?=$mensaje?></p>
						<?php endif; ?>
					</form>
				<?php endif; ?>
				<?php if($_GET): ?>
					<h2>Editar elementos</h2>
					<form class="form" method="get" action="editar.php">
						<input type="text" name="color" value="<?=$resultado_unico['color'];?>" placeholder="Color...">
						<input type="text" name="descripcion" value="<?=$resultado_unico['descripcion'];?>" placeholder="Descripción...">
						<input type="hidden" name="id" value="<?=$resultado_unico['id'];?>">
						<button class="">Agregar</button>
					</form>
				<?php endif; ?>

			</div>
		</div>
	</div>
</body>
</html>

<?php $pdo = null; $gsent = null; ?>
