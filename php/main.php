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

// evitar inyeccion SQL
// limpiar cadena de texto
function limpiar_cadena($cadena){
	$cadena=trim($cadena);
	$cadena=stripslashes($cadena);
	$cadena=str_ireplace("<script>", "", $cadena);
	$cadena=str_ireplace("</script>", "", $cadena);
	$cadena=str_ireplace("<script src", "", $cadena);
	$cadena=str_ireplace("<script type=", "", $cadena);
	$cadena=str_ireplace("SELECT * FROM", "", $cadena);
	$cadena=str_ireplace("DELETE FROM", "", $cadena);
	$cadena=str_ireplace("INSERT INTO", "", $cadena);
	$cadena=str_ireplace("DROP TABLE", "", $cadena);
	$cadena=str_ireplace("DROP DATABASE", "", $cadena);
	$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
	$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
	$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
	$cadena=str_ireplace("<?php", "", $cadena);
	$cadena=str_ireplace("?>", "", $cadena);
	$cadena=str_ireplace("--", "", $cadena);
	$cadena=str_ireplace("^", "", $cadena);
	$cadena=str_ireplace("<", "", $cadena);
	$cadena=str_ireplace("[", "", $cadena);
	$cadena=str_ireplace("]", "", $cadena);
	$cadena=str_ireplace("==", "", $cadena);
	$cadena=str_ireplace(";", "", $cadena);
	$cadena=str_ireplace("::", "", $cadena);
	$cadena=trim($cadena);
	$cadena=stripslashes($cadena);
	return $cadena;
}

// funcion renombrar fotos
function renombrar_fotos($nombre){
	$nombre=str_ireplace(" ", "_", $nombre);
	$nombre=str_ireplace("/", "_", $nombre);
	$nombre=str_ireplace("#", "_", $nombre);
	$nombre=str_ireplace("-", "_", $nombre);
	$nombre=str_ireplace("$", "_", $nombre);
	$nombre=str_ireplace(".", "_", $nombre);
	$nombre=str_ireplace(",", "_", $nombre);
	$nombre=$nombre."_".rand(0,100);
	return $nombre;
}

?>