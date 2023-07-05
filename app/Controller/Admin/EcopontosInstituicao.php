<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Controller\Paginas\Paginas;
use \App\Controller\Utilidades\Paginacao;
use \App\Model\Entidades\Ecopontos as EntidadeEcopontos;
use \App\Model\Entidades\Endereco as EntidadeEndereco;
use \App\Model\Entidades\Instituicao as EntidadeInstituicao;

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
    $objEndereco = new EntidadeEndereco;

    $objEcoponto->tag = $dadosPost['tag'];
    $objEcoponto->cadastrar();

    $objEndereco->setCep($dadosPost['cep']);
    $objEndereco->setRua($dadosPost['rua']);
    $objEndereco->setNumero($dadosPost['numero']);
    $objEndereco->setBairro($dadosPost['bairro']);
    $objEndereco->setCidade($dadosPost['cidade']);
    $objEndereco->setEstado($dadosPost['estado']);

    $objEndereco->setIdUsuario($_SESSION['admin']['usuario']['id']);
    $objEndereco->cadastrar();

    // Atualiza o endereço do usuario
    $objEcoponto->setEcopontoEndereco($objEndereco->getId());

    return self::getEcopontos($requisicao);
  }

  public static function getEcopontosEditar($requisicao, $id)
  {
    $objEcoponto = EntidadeEcopontos::getEcopontoPorId($id);

    if (! $objEcoponto instanceof EntidadeEcopontos) {
      $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos-instituicao');
    }

    $objEndereco = EntidadeEndereco::consultarEnderecoPorId($objEcoponto->getEndereco());
    $estado = $objEndereco->getEstado();
    $estadoOpcoes = '
      <option value="AC" ' . ($estado == 'AC' ? 'selected' : '') .'>Acre</option>
      <option value="AL" ' . ($estado == 'AL' ? 'selected' : '') .'>Alagoas</option>
      <option value="AP" ' . ($estado == 'AP' ? 'selected' : '') .'>Amapá</option>
      <option value="AM" ' . ($estado == 'AM' ? 'selected' : '') .'>Amazonas</option>
      <option value="BA" ' . ($estado == 'BA' ? 'selected' : '') .'>Bahia</option>
      <option value="CE" ' . ($estado == 'CE' ? 'selected' : '') .'>Ceará</option>
      <option value="DF" ' . ($estado == 'DF' ? 'selected' : '') .'>Distrito Federal</option>
      <option value="ES" ' . ($estado == 'ES' ? 'selected' : '') .'>Espírito Santo</option>
      <option value="GO" ' . ($estado == 'GO' ? 'selected' : '') .'>Goiás</option>
      <option value="MA" ' . ($estado == 'MA' ? 'selected' : '') .'>Maranhão</option>
      <option value="MT" ' . ($estado == 'MT' ? 'selected' : '') .'>Mato Grosso</option>
      <option value="MS" ' . ($estado == 'MS' ? 'selected' : '') .'>Mato Grosso do Sul</option>
      <option value="MG" ' . ($estado == 'MG' ? 'selected' : '') .'>Minas Gerais</option>
      <option value="PA" ' . ($estado == 'PA' ? 'selected' : '') .'>Pará</option>
      <option value="PB" ' . ($estado == 'PB' ? 'selected' : '') .'>Paraíba</option>
      <option value="PR" ' . ($estado == 'PR' ? 'selected' : '') .'>Paraná</option>
      <option value="PE" ' . ($estado == 'PE' ? 'selected' : '') .'>Pernambuco</option>
      <option value="PI" ' . ($estado == 'PI' ? 'selected' : '') .'>Piauí</option>
      <option value="RJ" ' . ($estado == 'RJ' ? 'selected' : '') .'>Rio de Janeiro</option>
      <option value="RN" ' . ($estado == 'RN' ? 'selected' : '') .'>Rio Grande do Norte</option>
      <option value="RS" ' . ($estado == 'RS' ? 'selected' : '') .'>Rio Grande do Sul</option>
      <option value="RO" ' . ($estado == 'RO' ? 'selected' : '') .'>Rondônia</option>
      <option value="RR" ' . ($estado == 'RR' ? 'selected' : '') .'>Roraima</option>
      <option value="SC" ' . ($estado == 'SC' ? 'selected' : '') .'>Santa Catarina</option>
      <option value="SP" ' . ($estado == 'SP' ? 'selected' : '') .'>São Paulo</option>
      <option value="SE" ' . ($estado == 'SE' ? 'selected' : '') .'>Sergipe</option>
      <option value="TO" ' . ($estado == 'TO' ? 'selected' : '') .'>Tocantins</option>';

    $conteudo = View::renderizar('admin/ecopontos/editar-instituicao', [
      'cep' => $objEndereco->getCep(),
      'rua' => $objEndereco->getRua(),
      'numero' => $objEndereco->getNumero(),
      'bairro' => $objEndereco->getBairro(),
      'cidade' => $objEndereco->getCidade(),
      'estado' => $estadoOpcoes,
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

    $objEcoponto->tag = $dadosPost['tag'] ?? $objEcoponto->tag;
    $objEcoponto->atualizar();

    $objEndereco = EntidadeEndereco::consultarEnderecoPorId($objEcoponto->getEndereco());
    $objEndereco->setCep($dadosPost['cep'] ?? $objEndereco->getCep());
    $objEndereco->setRua($dadosPost['rua'] ?? $objEndereco->getRua());
    $objEndereco->setNumero($dadosPost['numero'] ?? $objEndereco->getNumero());
    $objEndereco->setBairro($dadosPost['bairro'] ?? $objEndereco->getBairro());
    $objEndereco->setCidade($dadosPost['cidade'] ?? $objEndereco->getCidade());
    $objEndereco->setEstado($dadosPost['estado'] ?? $objEndereco->getEstado());
    $objEndereco->atualizar();

    $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos-instituicao/' . $objEcoponto->id . '/editar');
  }


  public static function getEcopontosExcluir($requisicao, $id)
  {
    $objEcoponto = EntidadeEcopontos::getEcopontoPorId($id);

    if (! $objEcoponto instanceof EntidadeEcopontos) {
      $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos-instituicao');
    }

    $objEndereco = EntidadeEndereco::consultarEnderecoPorId($objEcoponto->getEndereco());

    $conteudo = View::renderizar('admin/ecopontos/excluir-instituicao', [
      'cep' => $objEndereco->getCep(),
      'rua' => $objEndereco->getRua(),
      'numero' => $objEndereco->getNumero(),
      'bairro' => $objEndereco->getBairro(),
      'cidade' => $objEndereco->getCidade(),
      'estado' => $objEndereco->getEstado(),
      'tag' => $objEcoponto->tag,
    ]);

    return parent::getPainelInstituicao('Excluir ecopontos', $conteudo, 'ecopontos');
  }


  public static function setEcopontosExcluir($requisicao, $id)
  {
    $objEcoponto = EntidadeEcopontos::getEcopontoPorId($id);
    $objEndereco = EntidadeEndereco::consultarEnderecoPorId($objEcoponto->getEndereco());


    if (! $objEcoponto instanceof EntidadeEcopontos) {
      $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos');
    }

    $dadosPost = $requisicao->urlParametrosPostPegar();
    $objEcoponto->endereco = $dadosPost['endereco'] ?? $objEcoponto->endereco;
    $objEcoponto->tag = $dadosPost['tag'] ?? $objEcoponto->tag;

    $objEcoponto->excluir();
    $objEndereco->excluir();

    $requisicao->roteadorPegar()->redirecionar('/admin/ecopontos-instituicao');
  }

  private static function ecopontosItensPegar($requisicao, &$objPaginacao)
  {
    $itens = '';

    $usuarioId = $_SESSION['admin']['usuario']['id'];

    $quantidadeTotal = EntidadeEcopontos::ecopontosPegar('id_usuario = ' . $usuarioId, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

    $urlParametros = $requisicao->urlParametrosPegar();

    $paginaAtual = $urlParametros['pagina'] ?? 1;

    $objPaginacao = new Paginacao($quantidadeTotal, $paginaAtual, 3);

    $resultadoEcopontos = EntidadeEcopontos::ecopontosPegar('id_usuario = ' . $usuarioId, 'id DESC', $objPaginacao->getLimit());
    $resultadoEnderecos = EntidadeEndereco::consultarEndereco('id_usuario = ' . $usuarioId, 'id DESC');

    while($objEcoponto = $resultadoEcopontos->fetchObject(EntidadeEcopontos::class) and $objEndereco = $resultadoEnderecos->fetchObject(EntidadeEndereco::class)) {
      $endereco = $objEndereco->getRua() . ', ' . $objEndereco->getNumero() . ', ' . $objEndereco->getBairro() . ' - ' . $objEndereco->getCidade() . ' - ' . $objEndereco->getEstado();

      $itens .= View::renderizar('admin/ecopontos/itens-instituicao', [
        'id' => $objEcoponto->id,
        'endereco' => $endereco,
        'tag' => $objEcoponto->tag,
      ]);
    }

    return $itens;
  }
}