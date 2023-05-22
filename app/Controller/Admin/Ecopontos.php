<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Controller\Paginas\Paginas;
use \App\Controller\Utilidades\Paginacao;
use \App\Model\Entidades\Ecopontos as EntidadeEcopontos;

class Ecopontos extends Pagina
{
  // Retorna o conteúdo da view home
  public static function getEcopontos($requisicao) {
    $conteudo = View::renderizar('admin/ecopontos', [
      'itens' => self::ecopontosItensPegar($requisicao, $objPaginacao),
      'paginacao' => Paginas::paginacaoPegar($requisicao, $objPaginacao),
    ]);

    return parent::getPainel('Ecopontos', $conteudo, 'ecopontos');
  }


  // public static function ecopontosCadastrar($requisicao) 
  // {
  //   $dadosPost = $requisicao->urlParametrosPostPegar();
  //   $objEcoponto = new EntidadeEcopontos;
  //   $objEcoponto->endereco = $dadosPost['endereco'];
  //   $objEcoponto->tag = $dadosPost['tag'];
  //   $objEcoponto->cadastrar();

  //   return self::getEcopontos($requisicao);
  // }
  
  // public static function getEcopontosEditar($requisicao, $id) 
  // {
  //   $objEcoponto = EntidadeEcopontos::getEcopontoPorId($id);
    
  //   if (! $objEcoponto instanceof EntidadeEcopontos) {
  //     $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos');
  //   }

  //   $conteudo = View::renderizar('admin/ecopontos/editar', [
  //     'endereco' => $objEcoponto->endereco,
  //     'tag' => $objEcoponto->tag,
  //   ]);

  //   return parent::getPainel('Editar ecopontos', $conteudo, 'ecopontos');
  // }


  // public static function setEcopontosEditar($requisicao, $id) 
  // {
  //   $objEcoponto = EntidadeEcopontos::getEcopontoPorId($id);
    
  //   if (! $objEcoponto instanceof EntidadeEcopontos) {
  //     $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos');
  //   }

  //   $dadosPost = $requisicao->urlParametrosPostPegar();
  //   $objEcoponto->endereco = $dadosPost['endereco'] ?? $objEcoponto->endereco;
  //   $objEcoponto->tag = $dadosPost['tag'] ?? $objEcoponto->tag;
  //   $objEcoponto->atualizar();

  //   $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos/' . $objEcoponto->id . '/editar');
  // }


  // public static function getEcopontosExcluir($requisicao, $id) 
  // {
  //   $objEcoponto = EntidadeEcopontos::getEcopontoPorId($id);
    
  //   if (! $objEcoponto instanceof EntidadeEcopontos) {
  //     $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos');
  //   }

  //   $conteudo = View::renderizar('admin/ecopontos/excluir', [
  //     'endereco' => $objEcoponto->endereco,
  //     'tag' => $objEcoponto->tag,
  //   ]);

  //   return parent::getPainel('Excluir ecopontos', $conteudo, 'ecopontos');
  // }


  // public static function setEcopontosExcluir($requisicao, $id) 
  // {
  //   $objEcoponto = EntidadeEcopontos::getEcopontoPorId($id);
    
  //   if (! $objEcoponto instanceof EntidadeEcopontos) {
  //     $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos');
  //   }

  //   $dadosPost = $requisicao->urlParametrosPostPegar();
  //   $objEcoponto->endereco = $dadosPost['endereco'] ?? $objEcoponto->endereco;
  //   $objEcoponto->tag = $dadosPost['tag'] ?? $objEcoponto->tag;
  //   $objEcoponto->excluir($id);

  //   $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos');
  // }

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
        'id' => $objEcoponto->id,
        'endereco' => $objEcoponto->endereco,
        'tag' => $objEcoponto->tag,
      ]);
    }

    return $itens;
  }
}