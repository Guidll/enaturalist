<?php

namespace App\Sessao\Admin;

class Login
{

  private static function inicio()
  {
    // Necessario verificar se sessao ja esta ativa
    if (session_status() != PHP_SESSION_ACTIVE) {
      session_start();
    }
  }

  public static function login($objUsuario)
  {
    self::inicio();

    // Defini a sessao do usuario
    $_SESSION['admin']['usuario'] = [
      'id' => $objUsuario->id,
      'nome' => $objUsuario->nome,
      'email' => $objUsuario->email,
    ];

    return true;
  }
}