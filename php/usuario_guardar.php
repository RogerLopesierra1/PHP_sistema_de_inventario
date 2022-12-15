<?php
require_once("main.php");

#almacenar datos
$nombre = limpiar_cadena($_POST['usuario_nombre']);
$apellido = limpiar_cadena($_POST['usuario_apellido']);

$usuario = limpiar_cadena($_POST['usuario_usuario']);
$email = limpiar_cadena($_POST['usuario_email']);

$clave_1 = limpiar_cadena($_POST['usuario_clave_1']);
$clave_2 = limpiar_cadena($_POST['usuario_clave_2']);

#verificando campos obligatorios
if ($nombre=="" || $apellido=="" || $usuario=="" || $clave_1=="" 
  ||$clave_2=="") {
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
if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)) {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      EL NOMBRE no coincide con el formato solicitado
    </div>'
  );
  exit();
}

if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$apellido)) {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      EL APELLIDO no coincide con el formato solicitado
    </div>'
  );
  exit();
}

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

if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1)) {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      EL CLAVE_1 no coincide con el formato solicitado
    </div>'
  );
  exit();
}

if (verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)) {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      EL CLAVE_2 no coincide con el formato solicitado
    </div>'
  );
  exit();
}

if ($email!="") {
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $check_email = conexion();
    $check_email = $check_email->query("SELECT usuario_email FROM 
      `usuario` WHERE usuario_email='$email'");
      if ($check_email->rowCount()>0) {
        echo(
          '<div class="notification is-danger is-light">
            <button class="delete"></button>
            <strong>!Ocurrio un error inesperado</strong><br/>
            EL EMAIL ya existe, seleccione otro correo
          </div>'
        );
        exit();
      }
    $check_email = null;
  } else {
    echo(
      '<div class="notification is-danger is-light">
        <button class="delete"></button>
        <strong>!Ocurrio un error inesperado</strong><br/>
        EL EMAIL no es valido
      </div>'
    );
    exit();
  }
  
}

# verificando usuario
$check_usuario = conexion();
$check_usuario = $check_usuario->query("SELECT usuario_usuario FROM 
  `usuario` WHERE usuario_usuario='$usuario'");
  if ($check_usuario->rowCount()>0) {
    echo(
      '<div class="notification is-danger is-light">
        <button class="delete"></button>
        <strong>!Ocurrio un error inesperado</strong><br/>
        EL USUARIO ya existe, seleccione otro usuario
      </div>'
    );
    exit();
  }
$check_usuario = null;

# VERIFICANDO CLAVES y encriptando
if ($clave_1!=$clave_2) {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      LAS CLAVES no coinciden
    </div>'
  );
  exit();
} else {
  $clave = password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]);
}

$guardar_usuario = conexion();
$guardar_usuario = $guardar_usuario->prepare("INSERT INTO usuario
(usuario_nombre, usuario_apellido, usuario_usuario, usuario_clave, usuario_email) 
VALUES (:nombre, :apellido, :usuario, :clave, :email)");

$marcadores = [
  "nombre"=>$nombre,
  "apellido"=>$apellido,
  "usuario"=>$usuario,
  "clave"=>$clave,
  "email"=>$email
];

$guardar_usuario->execute($marcadores);

if ($guardar_usuario->rowCount()==1) {
  echo(
    '<div class="notification is-info is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      REGISTRO EXITOSO
    </div>'
  );
} else {
  echo(
    '<div class="notification is-danger is-light">
      <button class="delete"></button>
      <strong>!Ocurrio un error inesperado</strong><br/>
      NO se pudo registrar el usuario
    </div>'
  );
}

$guardar_usuario = null;

?>