<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;

class Pagina
{
  public static function paginaPegar($titulo, $conteudo)
  {
    return View::renderizar('admin/pagina', [
      'titulo' => $titulo,
      'conteudo' => $conteudo,
    ]);
  }
}

