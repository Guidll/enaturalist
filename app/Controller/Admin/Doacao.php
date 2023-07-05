<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Controller\Paginas\Paginas;
use \App\Controller\Utilidades\Paginacao;
use \App\Model\Entidades\Doacao as EntidadeDoacao;
use \App\Model\Entidades\Usuario as EntidadeUsuario;
use \App\Model\Entidades\Endereco as EntidadeEndereco;
use \App\Model\Entidades\Solicitacao as EntidadeSolicitacao;
use \App\Model\Entidades\Instituicao as EntidadeInstituicao;
use \App\Model\Entidades\Ecopontos as EntidadeEcopontos;

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


  public static function getDoacaoAceitar($requisicao, $id)
  {
    $id_doacao = $id;

    $objDoacao = EntidadeDoacao::getDoacaoPorId($id_doacao);
    $objSolicitacao = EntidadeSolicitacao::consultarSolicitacaoPorIdDoacao($id_doacao);

    $id_instituicao = $objSolicitacao->getIdInstituicao();

    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao');
    }

    $endereco = '';

    $resultado = EntidadeEndereco::consultarEndereco('id_usuario = ' . $id_instituicao);

    while ($objEndereco = $resultado->fetchObject(EntidadeEndereco::class)) {
      $endereco .= '<li>' . $objEndereco->getRua() . ', ' . $objEndereco->getNumero() . ', ' . $objEndereco->getBairro() . ' - ' . $objEndereco->getCidade() . ' - ' . $objEndereco->getEstado() . '</li>';
    }

    $conteudo = View::renderizar('admin/doacao/aceitar', [
      'material' => $objDoacao->material,
      'quantidade' => $objDoacao->quantidade,
      'endereco' => $endereco,
    ]);

    return parent::getPainel('Aceitar doacao', $conteudo, 'doacao');
  }


  public static function setDoacaoAceitar($requisicao, $id)
  {
    $id_doacao = $id;

    $objDoacao = EntidadeDoacao::getDoacaoPorId($id_doacao);
    $objSolicitacao = EntidadeSolicitacao::consultarSolicitacaoPorIdDoacao($id_doacao);

    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao');
    }

    $id_solicitacao = $objSolicitacao->getId();
    $objSolicitacao->excluir($id_solicitacao);
    $objDoacao->setAceito(1);
    $objDoacao->atualizar();

    $requisicao->roteadorPegar()->redirecionar('/admin/doacao');
  }


  public static function getDoacaoRecusar($requisicao, $id)
  {
    $objDoacao = EntidadeDoacao::getDoacaoPorId($id);

    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao');
    }

    $conteudo = View::renderizar('admin/doacao/recusar', [
      'material' => $objDoacao->material,
      'quantidade' => $objDoacao->quantidade,
    ]);

    return parent::getPainel('Recusar doacao', $conteudo, 'doacao');
  }


  public static function setDoacaoRecusar($requisicao, $id)
  {
    $id_doacao = $id;

    $objDoacao = EntidadeDoacao::getDoacaoPorId($id_doacao);
    $objSolicitacao = EntidadeSolicitacao::consultarSolicitacaoPorIdDoacao($id_doacao);

    if (! $objDoacao instanceof EntidadeDoacao) {
      $requisicao->roteadorPegar()->redirecionar('/admin/doacao');
    }

    $id_solicitacao = $objSolicitacao->getId();
    $objSolicitacao->excluir($id_solicitacao);

    $objDoacao->setRequisitado(0);
    $objDoacao->setAceito(0);
    $objDoacao->atualizar();

    $requisicao->roteadorPegar()->redirecionar('/admin/doacao');
  }

  private static function doacaoItensPegar($requisicao, &$objPaginacao)
  {
    $itens = '';

    $usuarioId = EntidadeUsuario::getUsuarioId();
    $usuarioCelular = EntidadeUsuario::getUsuarioCelularPorId($usuarioId);

    $objEndereco = EntidadeEndereco::consultarEnderecoPorIdUsuario($usuarioId);
    $endereco = $objEndereco->getRua() . ', ' . $objEndereco->getNumero() . ', ' . $objEndereco->getBairro() . ' - ' . $objEndereco->getCidade() . ' - ' . $objEndereco->getEstado();

    $quantidadeTotal = EntidadeDoacao::doacaoPegar("id_usuario = $usuarioId AND aceito = 0", null, null, "COUNT(*) as qtd")->fetchObject()->qtd;

    $urlParametros = $requisicao->urlParametrosPegar();

    $paginaAtual = $urlParametros['pagina'] ?? 1;

    $objPaginacao = new Paginacao($quantidadeTotal, $paginaAtual, 3);

    $resultado = EntidadeDoacao::doacaoPegar("id_usuario = $usuarioId AND aceito = 0", 'requisitado DESC', $objPaginacao->getLimit());

    while($objDoacao = $resultado->fetchObject(EntidadeDoacao::class)) {
      $requisitado = $objDoacao->getRequisitado();
      $id_doacao = $objDoacao->getId();
      $link_aceito =
        '<a href="' . URL . '/admin/doacao/' . $id_doacao . '/aceitar" class="block p-2 bg-blue-500 text-white rounded-md">
        Aceitar doação
        </a>';
      $link_recusado =
        '<a href="' . URL . '/admin/doacao/' . $id_doacao . '/recusar" class="block p-2 bg-red-500 text-white rounded-md">
        Recusar doação
        </a>';

      $itens .= View::renderizar('admin/doacao/itens', [
        'id' => $objDoacao->getId(),
        'id_usuario' => $usuarioId,
        'material' => $objDoacao->getMaterial(),
        'quantidade' => $objDoacao->getQuantidade(),
        'endereco' => $endereco,
        'celular' => $usuarioCelular,
        'link-aceitar' => $requisitado == 1 ? $link_aceito : '',
        'link-recusar' => $requisitado == 1 ? $link_recusado : '',
      ]);
    }

    return $itens;
  }
}