<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Model\Entidades\Usuario as EntidadeUsuario;

class Home extends Pagina
{
  // Renderiza o conteudo da view
  public static function getHome($requisicao)
  {
    $conteudo = View::renderizar('admin/home', []);

    return parent::getPainel('Home', $conteudo, 'home');
  }
}