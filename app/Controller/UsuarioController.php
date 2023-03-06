<?php


class UsuarioController
{
  public static function cadastro()
  {
    include './app/View/modules/Usuario/Cadastro.php';
  }

  public static function login()
  {
    include './app/View/modules/Usuario/Login.php';
  }
}
?>