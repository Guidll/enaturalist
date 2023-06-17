<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Controller\Paginas\Paginas;
use \App\Controller\Utilidades\Paginacao;
use \App\Model\Entidades\Doacao as EntidadeDoacao;
use \App\Model\Entidades\Usuario as EntidadeUsuario;

class Doacao extends Pagina
{
  // Retorna o conteúdo da view home
  public static function getDoacao($requisicao) {
    $conteudo = View::renderizar('admin/doacao', [
      'itens' => self::doacaoItensPegar($requisicao, $objPaginacao),
      'paginacao' => Paginas::paginacaoPegar($requisicao, $objPaginacao),
    ]);

    return parent::getPainel('Doação', $conteudo, 'doacao');
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
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao');
    }

    $conteudo = View::renderizar('admin/doacao/editar', [
      'material' => $objDoacao->material,
      'quantidade' => $objDoacao->quantidade,
    ]);

    return parent::getPainel('Editar doacao', $conteudo, 'doacao');
  }


  public static function setDoacaoEditar($requisicao, $id) 
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);
    
    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao');
    }

    $dadosPost = $requisicao->urlParametrosPostPegar();
    $objDoacao->material = $dadosPost['material'] ?? $objDoacao->material;
    $objDoacao->quantidade = $dadosPost['quantidade'] ?? $objDoacao->quantidade;
    $objDoacao->atualizar();

    $requisicao->roteadorPegar()->redirecionar('/admin/doacao/' . $objDoacao->id . '/editar');
  }


  public static function getDoacaoExcluir($requisicao, $id) 
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);
    
    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao');
    }

    $conteudo = View::renderizar('admin/doacao/excluir', [
      'material' => $objDoacao->material,
      'quantidade' => $objDoacao->quantidade,
    ]);

    return parent::getPainel('Excluir doacao', $conteudo, 'doacao');
  }


  public static function setDoacaoExcluir($requisicao, $id) 
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);
    
    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao');
    }

    // $dadosPost = $requisicao->urlParametrosPostPegar();
    // $objDoacao->material = $dadosPost['material'] ?? $objDoacao->material;
    // $objDoacao->quantidade = $dadosPost['quantidade'] ?? $objDoacao->quantidade;
    $objDoacao->excluir($id);

    $requisicao->roteadorPegar()->redirecionar('/admin/doacao');
  }

  private static function doacaoItensPegar($requisicao, &$objPaginacao)
  {
    $itens = '';
    
    $usuarioId = EntidadeUsuario::getUsuarioId();
    $usuarioEndereco = EntidadeUsuario::getUsuarioEnderecoPorId($usuarioId);
    $usuarioCelular = EntidadeUsuario::getUsuarioCelularPorId($usuarioId);

    $quantidadeTotal = EntidadeDoacao::doacaoPegar('id_usuario = ' . $usuarioId, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;


    $urlParametros = $requisicao->urlParametrosPegar();

    $paginaAtual = $urlParametros['pagina'] ?? 1;

    $objPaginacao = new Paginacao($quantidadeTotal, $paginaAtual, 3);

    $resultado = EntidadeDoacao::doacaoPegar('id_usuario = ' . $usuarioId, 'id DESC', $objPaginacao->getLimit());

    while($objDoacao = $resultado->fetchObject(EntidadeDoacao::class)) {
      $itens .= View::renderizar('admin/doacao/itens', [
        'id' => $objDoacao->id,
        'id_usuario' => $usuarioId,
        'material' => $objDoacao->material,
        'quantidade' => $objDoacao->quantidade,
        'endereco' => $usuarioEndereco,
        'celular' => $usuarioCelular,
      ]);
    }

    return $itens;
  }
}