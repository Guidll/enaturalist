<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;

class Alerta
{
  // Retorna uma mensagem de sucesso
  public static function getSucesso($mensagem)
  {
    return View::renderizar('admin/alerta',[
      'tipo' => 'sucesso',
      'estilizacao' => 'text-green-500',
      'mensagem' => $mensagem,
    ]);
  }


  // Retorna uma mensagem de sucesso
  public static function getErro($mensagem)
  {
    return View::renderizar('admin/alerta',[
      'tipo' => 'erro',
      'estilizacao' => 'text-red-500',
      'mensagem' => $mensagem,
    ]);
  }
}