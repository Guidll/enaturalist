<?php

namespace App\Controller\Paginas;

use \App\Controller\Utilidades\View;

class Paginas
{
  // Retorna o topo para pagina modelo
  private static function topoPegar()
  {
    return View::renderizar('paginas/topo');
  }

  // Retorna o rodape para pagina modelo
  private static function rodapePegar()
  {
    return View::renderizar('paginas/rodape');
  }

  // Retorna o conteúdo da view
  public static function paginaPegar($titulo, $conteudo) {
    return View::renderizar('paginas/pagina', [
      'titulo' => $titulo,
      'topo' => self::topoPegar(),
      'conteudo' => $conteudo,
      'rodape' => self::rodapePegar(),
    ]);
  }
}