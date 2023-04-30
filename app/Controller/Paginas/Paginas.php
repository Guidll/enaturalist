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


  // Retorna a paginacao dos ecopontos
  public static function paginacaoPegar($requisicao, $objPaginacao) {
    $paginas = $objPaginacao->getPages();

    // Verifica quantidade de paginas se for apenas 1 pagina n chama o elemento paginacao
    if (count($paginas) <= 1) return '';

    $links = '';

    // Url atual sem GETs
    $url = $requisicao->roteadorPegar()->urlAtualPegar();

    $urlParametros = $requisicao->urlParametrosPegar();
    
    foreach($paginas as $pagina) {
      $urlParametros['pagina'] = $pagina['page'];

      $link = $url . '?' . http_build_query($urlParametros);

      $links .= View::renderizar('paginas/paginacao/item', [
        'item' => $pagina['page'],
        'link' => $link,
        'ativo' => $pagina['current'] ? '!bg-blue-500 !text-white' : '',
      ]);
    }

    return View::renderizar('paginas/paginacao/paginacao', [
      'itens' => $links,
    ]);
  }
}