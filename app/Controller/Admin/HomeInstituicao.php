<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;

class HomeInstituicao extends Pagina
{
  // Renderiza o conteudo da view
  public static function getHome($requisicao)
  {
    $conteudo = View::renderizar('admin/instituicao', []);

    return parent::getPainelInstituicao('Home', $conteudo, 'home');
  }
}