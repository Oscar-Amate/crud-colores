<?php 

function eliminar_sesion($sesion) {
	if(isset($_SESSION[$sesion])) {
		$_SESSION[$sesion] = null;
		unset($_SESSION[$sesion]);
	} 
	return $sesion;
}