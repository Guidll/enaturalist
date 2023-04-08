<?php

namespace App\Controller\Paginas;

use \App\Controller\Utilidades\View;
use \App\Model\Entidades\Usuario;

class Ecopontos extends Paginas
{
  // Retorna o conteúdo da view home
  public static function ecopontosPegar() {
    $objeto_usuario = new Usuario;

    $conteudo = View::renderizar('paginas/ecopontos', [
      'nome' => $objeto_usuario->nome,
    ]);

    return parent::paginaPegar('Ecopontos', $conteudo);
  }
}