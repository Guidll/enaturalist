<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Model\Entidades\Usuario as EntendidadeUsuario;
use \App\Model\Entidades\Instituicao as EntendidadeInstituicao;
use \App\Model\Entidades\Endereco as EntidadeEndereco;

class Cadastro extends Pagina
{
  // ----------------------------
  // ----- Cadastro usuario -----
  // ----------------------------
  public static function getCadastro($requisicao, $mensagemErro = null)
  {
    $status = ! is_null($mensagemErro) ? Alerta::getErro($mensagemErro) : '';

    $conteudo = View::renderizar('admin/cadastro', [
      'status' => $status,
    ]);

    return parent::paginaPegar('Cadastro', $conteudo);
  }


  public static function setCadastro($requisicao)
  {
    $dadosPost = $requisicao->urlParametrosPostPegar();

    $objUsuario = new EntendidadeUsuario;
    $objEndereco = new EntidadeEndereco;

    $objUsuario->nome = $dadosPost['nome'];
    $objUsuario->email = $dadosPost['email'];
    $objUsuario->cpf = $dadosPost['cpf'];
    $objUsuario->senha = password_hash($dadosPost['senha'], PASSWORD_DEFAULT);
    $objUsuario->celular = $dadosPost['celular'];

    $objUsuario->setUsuario();


    $objEndereco->setCep($dadosPost['cep']);
    $objEndereco->setRua($dadosPost['rua']);
    $objEndereco->setNumero($dadosPost['numero']);
    $objEndereco->setBairro($dadosPost['bairro']);
    $objEndereco->setCidade($dadosPost['cidade']);
    $objEndereco->setEstado($dadosPost['estado']);

    $objEndereco->setIdUsuario($objUsuario->getId());
    $objEndereco->cadastrar();

    // Atualiza o endereço do usuario
    $objUsuario->setUsuarioEndereco($objEndereco->getId());

    return $requisicao->roteadorPegar()->redirecionar('/admin/login');
  }


  // --------------------------------
  // ----- Cadastro instituicao -----
  // --------------------------------
  public static function getCadastroInstituicao($requisicao, $mensagemErro = null)
  {
    $status = ! is_null($mensagemErro) ? Alerta::getErro($mensagemErro) : '';

    $conteudo = View::renderizar('admin/cadastro-instituicao', [
      'status' => $status,
    ]);

    return parent::paginaPegar('Cadastro Instituição', $conteudo);
  }


  public static function setCadastroInstituicao($requisicao)
  {
    $dadosPost = $requisicao->urlParametrosPostPegar();

    $objInstituicao = new EntendidadeInstituicao;
    $objEndereco = new EntidadeEndereco;

    $objInstituicao->setNome($dadosPost['nome']);
    $objInstituicao->setEmail($dadosPost['email']);
    $objInstituicao->setCnpj($dadosPost['cnpj']);
    $objInstituicao->setSenha(password_hash($dadosPost['senha'], PASSWORD_DEFAULT));
    $objInstituicao->setCelular($dadosPost['celular']);

    $objInstituicao->cadastrar();


    $objEndereco->setCep($dadosPost['cep']);
    $objEndereco->setRua($dadosPost['rua']);
    $objEndereco->setNumero($dadosPost['numero']);
    $objEndereco->setBairro($dadosPost['bairro']);
    $objEndereco->setCidade($dadosPost['cidade']);
    $objEndereco->setEstado($dadosPost['estado']);

    $objEndereco->setIdUsuario($objInstituicao->getId());
    $objEndereco->cadastrar();

    // Atualiza o endereço do usuario
    $objInstituicao->setUsuarioEndereco($objEndereco->getId());

    return $requisicao->roteadorPegar()->redirecionar('/admin/login');
  }
}