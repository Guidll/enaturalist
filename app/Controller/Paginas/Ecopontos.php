<?php

namespace App\Controller\Paginas;

use \App\Controller\Utilidades\View;
use \App\Controller\Utilidades\Paginacao;
use \App\Model\Entidades\Ecopontos as EntidadeEcopontos;

class Ecopontos extends Paginas
{
  // Retorna o conteúdo da view home
  public static function ecopontosPegar($requisicao) {
    $conteudo = View::renderizar('paginas/ecopontos', [
      'itens' => self::ecopontosItensPegar($requisicao, $objPaginacao),
      'paginacao' => parent::paginacaoPegar($requisicao, $objPaginacao),
    ]);

    return parent::paginaPegar('Ecopontos', $conteudo);
  }


  public static function ecopontosCadastrar($requisicao) 
  {
    $dadosPost = $requisicao->urlParametrosPostPegar();
    $objEcoponto = new EntidadeEcopontos;
    $objEcoponto->endereco = $dadosPost['endereco'];
    $objEcoponto->tag = $dadosPost['tag'];
    $objEcoponto->cadastrar();

    return self::ecopontosPegar($requisicao);
  }


  private static function ecopontosItensPegar($requisicao, &$objPaginacao)
  {
    $itens = '';

    $quantidadeTotal = EntidadeEcopontos::ecopontosPegar(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

    $urlParametros = $requisicao->urlParametrosPegar();

    $paginaAtual = $urlParametros['pagina'] ?? 1;

    $objPaginacao = new Paginacao($quantidadeTotal, $paginaAtual, 3);

    $resultado = EntidadeEcopontos::ecopontosPegar(null, 'id DESC', $objPaginacao->getLimit());

    while($objEcoponto = $resultado->fetchObject(EntidadeEcopontos::class)) {
      $itens .= View::renderizar('paginas/ecopontos/itens', [
        'endereco' => $objEcoponto->endereco,
        'tag' => $objEcoponto->tag,
      ]);
    }

    return $itens;
  }
}