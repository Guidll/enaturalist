<?php

namespace App\Controller\Paginas;

use \App\Controller\Utilidades\View;
use \App\Model\Entidades\Usuario;

class Home extends Paginas
{
  // Retorna o conteúdo da view home
  public static function homePegar() {
    $objeto_usuario = new Usuario;

    $conteudo = View::renderizar('paginas/home', [
      'nome' => $objeto_usuario->nome,
    ]);

    return parent::paginaPegar('eNaturalist', $conteudo);
  }
}