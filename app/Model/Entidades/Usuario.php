<?php

namespace App\Model\Entidades;

use \App\Controller\Utilidades\Banco;

class Usuario
{
  public $id;

  public $nome;

  public $email;

  public $senha;

  // 0 == restrito
  // 1 == total
  public $admin = 0;


  public static function usuarioPorEmailSelecionar($email)
  {
    return (new Banco('usuarios'))->select('email = "' . $email . '"')->fetchObject(self::class);
  }
}