<?php
$modulo_buscador = limpiar_cadena($_POST['modulo_buscador']);

$modulos = ["usuario", "categoria", "producto"];

if (in_array($modulo_buscador, $modulos)) {
  
} else {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      NO podemos procesar su peticion
    </div>'
  );
  
}


?>