<?php

#almacenar datos
$usuario = limpiar_cadena($_POST['login_usuario']);
$clave = limpiar_cadena($_POST['login_clave']);

#verificando campos obligatorios
if ($usuario=="" || $clave=="") {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      no has llenado todos los campos que son obligatorios
    </div>'
  );
  exit();
}

# verificando integridad de los datos
if (verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)) {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      EL USUARIO no coincide con el formato solicitado
    </div>'
  );
  exit();
}

if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)) {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      LA CLAVE no coincide con el formato solicitado
    </div>'
  );
  exit();
}

$check_user = conexion();
$check_user = $check_user->query("SELECT * FROM `usuario` WHERE 
usuario_usuario='$usuario'");

if ($check_user->rowCount()==1) {
  $check_user = $check_user->fetch();
  if (password_verify($clave, $check_user['usuario_clave'])) {

    $_SESSION['id'] = $check_user['usuario_id'];
    $_SESSION['nombre'] = $check_user['usuario_nombre'];
    $_SESSION['apellido'] = $check_user['usuarioapellidod'];
    $_SESSION['usuario'] = $check_user['usuario_usuario'];

    if (headers_sent()) {
      echo("<script>window.location.href='index.php?vista=home'</script>");      
    } else {
      header("Location: index.php?vista=home");
    }
    

  } else {
    echo(
      '<div class="notification is-danger is-light">
        <button class="delete"></button>
        <strong>!Ocurrio un error inesperado</strong><br/>
        CLAVE incorrecta
      </div>'
    );
  }
  
} else {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      USUARIO o CLAVE incorrectos
    </div>'
  );
}
$check_user = null;

?>