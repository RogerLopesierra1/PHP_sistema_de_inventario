<?php
// conexion a la base de datos
function conexion(){
	$pdo = new PDO('mysql:host=localhost;dbname=inventario', 'root', '');
	return $pdo;
}

// verificacion de datos 
function verificar_datos($filtro, $cadena){
	if (preg_match("/^".$filtro."$/",$cadena)) {
		return false;
	} else {
		return true;
	}
	
}

?>