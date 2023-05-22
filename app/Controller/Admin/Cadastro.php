<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Model\Entidades\Usuario as EntendidadeCadastro;

class Cadastro extends Pagina
{
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

    $objCadastro = new EntendidadeCadastro;

    $objCadastro->nome = $dadosPost['nome'];
    $objCadastro->email = $dadosPost['email'];
    $objCadastro->cpf = $dadosPost['cpf'];
    $objCadastro->senha = password_hash($dadosPost['senha'], PASSWORD_DEFAULT);
    $objCadastro->celular = $dadosPost['celular'];
    $objCadastro->endereco = $dadosPost['endereco'];

    $objCadastro->setUsuario();

    return $requisicao->roteadorPegar()->redirecionar('/admin/login');
  }
}