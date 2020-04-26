<?php  

include_once 'conexion.php';
session_start();
$error = '';

if($_GET) {

	$id = isset($_GET['id']) ? $_GET['id'] : false;
	$color = isset($_GET['color']) ? $_GET['color'] : false;
	$descripcion = isset($_GET['descripcion']) ? $_GET['descripcion'] : false;

	if($color && $descripcion) {
		$sql_editar = 'UPDATE colores SET color = ?, descripcion = ? WHERE id = ?';
		$sentencia_editar = $pdo->prepare($sql_editar);
		$sentencia_editar->execute(array($color, $descripcion, $id));
		
	} else {
		$_SESSION['error'] = 'Los campos no pueden estar vacíos.';
	}

} else {
	$_SESSION['error'] = 'Los campos no pueden estar vacíos.';
}
header('Location:index.php');
// Cerrar conexión
$sentencia_editar = null;
$pdo = null;


?>