<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Controller\Paginas\Paginas;
use \App\Controller\Utilidades\Paginacao;
use \App\Model\Entidades\Ecopontos as EntidadeEcopontos;
use \App\Model\Entidades\Endereco as EntidadeEndereco;

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


  private static function ecopontosItensPegar($requisicao, &$objPaginacao)
  {
    $itens = '';

    $urlParametros = $requisicao->urlParametrosPegar();
    $filtro_estado = $urlParametros['filtro-estado'] ?? '';
    $filtro_cidade = $urlParametros['filtro-cidade'] ?? '';
    $filtro = '';
    $condicao = [];

    if ($filtro_estado && empty($filtro_cidade)) {
      $filtro = 'estado = ' . '"' . $filtro_estado . '"';
    }
    else if ($filtro_estado && $filtro_cidade) {
      $filtro = 'estado = ' . '"' . $filtro_estado . '"' . ' AND cidade = ' . '"' . $filtro_cidade . '"';
    }
    else {
      $filtro = '';
    }

    $enderecos = EntidadeEndereco::consultarEndereco($filtro);

    while ($objEndereco = $enderecos->fetchObject(EntidadeEndereco::class)) {
      $condicao[] = $objEndereco->getId();
    }


    if (empty($condicao)) {
      $condicao = 'IS NULL';
    }
    else {
      $condicao = implode(',', $condicao);
    }

    $quantidadeTotal = EntidadeEcopontos::ecopontosPegar('FIND_IN_SET(endereco, ' . '"' . $condicao . '"' . ')', null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

    $urlParametros = $requisicao->urlParametrosPegar();

    $paginaAtual = $urlParametros['pagina'] ?? 1;

    $objPaginacao = new Paginacao($quantidadeTotal, $paginaAtual, 3);

    $resultadoEcopontos = EntidadeEcopontos::ecopontosPegar('FIND_IN_SET(endereco, ' . '"' . $condicao . '"' . ')', 'id DESC', $objPaginacao->getLimit());

    while($objEcoponto = $resultadoEcopontos->fetchObject(EntidadeEcopontos::class)) {
      $resultadoEnderecos = EntidadeEndereco::consultarEnderecoPorId($objEcoponto->getEndereco());

      $objEndereco = $resultadoEnderecos;
      $endereco = $objEndereco->getRua() . ', ' . $objEndereco->getNumero() . ', ' . $objEndereco->getBairro() . ' - ' . $objEndereco->getCidade() . ' - ' . $objEndereco->getEstado();

      $itens .= View::renderizar('admin/ecopontos/itens', [
        'id' => $objEcoponto->id,
        'endereco' => $endereco,
        'tag' => $objEcoponto->tag,
      ]);
    }

    return $itens;
  }
}