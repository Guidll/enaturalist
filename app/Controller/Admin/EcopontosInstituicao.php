<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Controller\Paginas\Paginas;
use \App\Controller\Utilidades\Paginacao;
use \App\Model\Entidades\Ecopontos as EntidadeEcopontos;
use \App\Model\Entidades\Usuario as EntidadeUsuario;

class EcopontosInstituicao extends Pagina
{
  // Retorna o conteúdo da view home
  public static function getEcopontos($requisicao) {
    $conteudo = View::renderizar('admin/ecopontos-instituicao', [
      'itens' => self::ecopontosItensPegar($requisicao, $objPaginacao),
      'paginacao' => Paginas::paginacaoPegar($requisicao, $objPaginacao),
    ]);

    return parent::getPainelInstituicao('Ecopontos Instituição', $conteudo, 'ecopontos');
  }


  public static function setEcopontos($requisicao) 
  {
    $dadosPost = $requisicao->urlParametrosPostPegar();
    $objEcoponto = new EntidadeEcopontos;
    $objEcoponto->endereco = $dadosPost['endereco'];
    $objEcoponto->tag = $dadosPost['tag'];
    $objEcoponto->cadastrar();

    return self::getEcopontos($requisicao);
  }
  
  public static function getEcopontosEditar($requisicao, $id) 
  {
    $objEcoponto = EntidadeEcopontos::getEcopontoPorId($id);
    
    if (! $objEcoponto instanceof EntidadeEcopontos) {
      $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos-instituicao');
    }

    $conteudo = View::renderizar('admin/ecopontos/editar-instituicao', [
      'endereco' => $objEcoponto->endereco,
      'tag' => $objEcoponto->tag,
    ]);

    return parent::getPainelInstituicao('Editar ecopontos', $conteudo, 'ecopontos-instituicao');
  }


  public static function setEcopontosEditar($requisicao, $id) 
  {
    $objEcoponto = EntidadeEcopontos::getEcopontoPorId($id);
    
    if (! $objEcoponto instanceof EntidadeEcopontos) {
      $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos-instituicao');
    }

    $dadosPost = $requisicao->urlParametrosPostPegar();
    $objEcoponto->endereco = $dadosPost['endereco'] ?? $objEcoponto->endereco;
    $objEcoponto->tag = $dadosPost['tag'] ?? $objEcoponto->tag;
    $objEcoponto->atualizar();

    $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos-instituicao/' . $objEcoponto->id . '/editar');
  }


  public static function getEcopontosExcluir($requisicao, $id) 
  {
    $objEcoponto = EntidadeEcopontos::getEcopontoPorId($id);
    
    if (! $objEcoponto instanceof EntidadeEcopontos) {
      $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos-instituicao');
    }

    $conteudo = View::renderizar('admin/ecopontos/excluir-instituicao', [
      'endereco' => $objEcoponto->endereco,
      'tag' => $objEcoponto->tag,
    ]);

    return parent::getPainelInstituicao('Excluir ecopontos', $conteudo, 'ecopontos');
  }


  public static function setEcopontosExcluir($requisicao, $id) 
  {
    $objEcoponto = EntidadeEcopontos::getEcopontoPorId($id);
    
    if (! $objEcoponto instanceof EntidadeEcopontos) {
      $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos');
    }

    $dadosPost = $requisicao->urlParametrosPostPegar();
    $objEcoponto->endereco = $dadosPost['endereco'] ?? $objEcoponto->endereco;
    $objEcoponto->tag = $dadosPost['tag'] ?? $objEcoponto->tag;
    $objEcoponto->excluir($id);

    $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos-instituicao');
  }

  private static function ecopontosItensPegar($requisicao, &$objPaginacao)
  {
    $itens = '';

    $usuarioId = EntidadeUsuario::getUsuarioId($_SESSION['admin']['usuario']['id']);

    $quantidadeTotal = EntidadeEcopontos::ecopontosPegar('id_usuario = ' . $usuarioId, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

    $urlParametros = $requisicao->urlParametrosPegar();

    $paginaAtual = $urlParametros['pagina'] ?? 1;

    $objPaginacao = new Paginacao($quantidadeTotal, $paginaAtual, 3);

    $resultado = EntidadeEcopontos::ecopontosPegar('id_usuario = ' . $usuarioId, 'id DESC', $objPaginacao->getLimit());

    while($objEcoponto = $resultado->fetchObject(EntidadeEcopontos::class)) {
      $itens .= View::renderizar('admin/ecopontos/itens-instituicao', [
        'id' => $objEcoponto->id,
        'endereco' => $objEcoponto->endereco,
        'tag' => $objEcoponto->tag,
      ]);
    }

    return $itens;
  }
}