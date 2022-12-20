<?php

$user_id_del = limpiar_cadena($_GET['user_id_del']);

// verificando usuario
$check_usuario = conexion();
$check_usuario = $check_usuario->query("SELECT usuario_id FROM usuario 
WHERE usuario_id='$user_id_del'");

if ($check_usuario->rowCount()==1) {
  // verificando producto
  $check_producto = conexion();
  $check_producto = $check_producto->query("SELECT usuario_id FROM producto 
  WHERE usuario_id='$user_id_del' LIMIT 1");

  if ($check_producto->rowCount()<=0) {
    $eliminar_usuario = conexion();
    $eliminar_usuario = $eliminar_usuario->prepare("DELETE FROM usuario 
    WHERE usuario_id=:id");

    $eliminar_usuario->execute([":id"=>$user_id_del]);
    
    if ($eliminar_usuario->rowCount()==1) {
      echo(
        '<div class="notification is-info is-light">
          <button class="delete"></button>
          <strong>!Usuario eliminado</strong><br/>
          los datos del usuario se eliminaron con exito
        </div>'
      );
    } else {
      echo(
        '<div class="notification is-danger is-light">
          <button class="delete"></button>
          <strong>!Ocurrio un error inesperado</strong><br/>
          NO podemos eliminar usuario, por favor intente nuevamente
        </div>'
      );
    }
    

  } else {
    echo(
      '<div class="notification is-danger is-light">
        <button class="delete"></button>
        <strong>!Ocurrio un error inesperado</strong><br/>
        NO podemos eliminar usuario ya que tiene productos registrados
      </div>'
    );
  }
  $check_producto=null;

} else {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      el USUARIO que intenta eliminar no existe
    </div>'
  );
}


?>