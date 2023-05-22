<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Controller\Paginas\Paginas;
use \App\Controller\Utilidades\Paginacao;
use \App\Model\Entidades\Doacao as EntidadeDoacao;
use \App\Model\Entidades\Usuario as EntidadeUsuario;

class DoacaoInstituicao extends Pagina
{
  // Retorna o conteúdo da view home
  public static function getDoacao($requisicao) {
    $conteudo = View::renderizar('admin/doacao-instituicao', [
      'itens' => self::doacaoItensPegar($requisicao, $objPaginacao),
      'paginacao' => Paginas::paginacaoPegar($requisicao, $objPaginacao),
    ]);

    return parent::getPainelInstituicao('Doação Instituições', $conteudo, 'doacao');
  }


  public static function setDoacao($requisicao) 
  {
    $dadosPost = $requisicao->urlParametrosPostPegar();
    $objDoacao = new EntidadeDoacao;
    $objDoacao->material = $dadosPost['material'];
    $objDoacao->quantidade = $dadosPost['quantidade'];
    $objDoacao->cadastrar();

    return self::getDoacao($requisicao);
  }
  
  public static function getDoacaoEditar($requisicao, $id) 
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);
    
    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
    }

    $conteudo = View::renderizar('admin/doacao-instituicao/editar', [
      'material' => $objDoacao->material,
      'quantidade' => $objDoacao->quantidade,
    ]);

    return parent::getPainel('Editar doacao', $conteudo, 'doacao');
  }


  public static function setDoacaoEditar($requisicao, $id) 
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);
    
    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
    }

    $dadosPost = $requisicao->urlParametrosPostPegar();
    $objDoacao->material = $dadosPost['material'] ?? $objDoacao->material;
    $objDoacao->quantidade = $dadosPost['quantidade'] ?? $objDoacao->quantidade;
    $objDoacao->atualizar();

    $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao/' . $objDoacao->id . '/editar');
  }


  public static function getDoacaoExcluir($requisicao, $id) 
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);
    
    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
    }

    $conteudo = View::renderizar('admin/doacao-instituicao/excluir', [
      'material' => $objDoacao->material,
      'quantidade' => $objDoacao->quantidade,
    ]);

    return parent::getPainel('Excluir doacao', $conteudo, 'doacao');
  }


  public static function setDoacaoExcluir($requisicao, $id) 
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);
    
    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
    }

    // $dadosPost = $requisicao->urlParametrosPostPegar();
    // $objDoacao->material = $dadosPost['material'] ?? $objDoacao->material;
    // $objDoacao->quantidade = $dadosPost['quantidade'] ?? $objDoacao->quantidade;
    $objDoacao->excluir($id);

    $requisicao->roteadorPegar()->redirecionar('/admin/doacao-instituicao');
  }

  private static function doacaoItensPegar($requisicao, &$objPaginacao)
  {
    $itens = '';

    $quantidadeTotal = EntidadeDoacao::doacaoPegar(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

    $urlParametros = $requisicao->urlParametrosPegar();

    $paginaAtual = $urlParametros['pagina'] ?? 1;

    $objPaginacao = new Paginacao($quantidadeTotal, $paginaAtual, 3);

    $resultado = EntidadeDoacao::doacaoPegar(null, 'id DESC', $objPaginacao->getLimit());

    while($objDoacao = $resultado->fetchObject(EntidadeDoacao::class)) {
      $usuarioEndereco = EntidadeUsuario::getUsuarioEndereco();
      $usuarioCelular = EntidadeUsuario::getUsuarioCelular();

      $itens .= View::renderizar('admin/doacao/itens-instituicao', [
        'material' => $objDoacao->material,
        'quantidade' => $objDoacao->quantidade,
        'endereco' => $usuarioEndereco,
        'celular' => $usuarioCelular,
      ]);
    }

    // print_r($itens);

    return $itens;
  }
}