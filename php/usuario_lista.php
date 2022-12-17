<?php

$inicio=($pagina>0) ? ($pagina*$registros-$registros) : 0;

if (isset($busqueda) and $busqueda!="") {
  $consulta_datos = "SELECT * FROM usuario WHERE usuario_id!='".$_SESSION['id']."'
   AND (usuario_nombre = '%$busqueda%' or usuario_apellido='%$busqueda%' 
   or usuario_usuario='%$busqueda%' or usuario_email='%$busqueda%') 
   ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

  $consulta_total = "SELECT COUNT(usuario_id) FROM usuario WHERE 
  usuario_id!='".$_SESSION['id']."' AND (usuario_nombre = '%$busqueda%' 
  or usuario_apellido='%$busqueda%' or usuario_usuario='%$busqueda%' 
  or usuario_email='%$busqueda%')";
  
} else {
  $consulta_datos = "SELECT * FROM usuario WHERE usuario_id!='".$_SESSION['id']."'
   ORDER BY usuario_nombre ASC LIMIT $inicio,$registros";

  $consulta_total = "SELECT COUNT(usuario_id) FROM usuario WHERE 
  usuario_id!='".$_SESSION['id']."'";
}

$conexion = conexion();

?>