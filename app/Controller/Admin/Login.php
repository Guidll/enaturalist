<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Model\Entidades\Usuario;
use \App\Sessao\Admin\Login as SessaoLogin;

class Login extends Pagina
{
  public static function loginPegar($requisicao, $mensagemErro = null)
  {
    $status = ! is_null($mensagemErro) ? View::renderizar('admin/login-erro', ['mensagem' => $mensagemErro,]) : '';

    $conteudo = View::renderizar('admin/login', [
      'status' => $status,
    ]);

    return parent::paginaPegar('Login', $conteudo);
  }


  public static function loginDefinir($requisicao)
  {
    $parametrosPost = $requisicao->urlParametrosPostPegar();

    $email = $parametrosPost['email'] ?? '';
    $senha = $parametrosPost['senha'] ?? '';
    
    // Busca usuario por email
    $objUsuario = Usuario::usuarioPorEmailSelecionar($email);

    // Verifica email do usuario
    if (! $objUsuario instanceof Usuario) {
      return self::loginPegar($requisicao, 'E-mail ou senha inválidos, Por favor confira os dados.');
    }

    // Verifica senha do usuario
    if (! password_verify($senha, $objUsuario->senha)) {
      return self::loginPegar($requisicao, 'E-mail ou senha inválidos, Por favor confira os dados.');
    }

    // Sessao login
    SessaoLogin::login($objUsuario);

    $requisicao->roteadorPegar()->redirecionar('/admin');

    // $conteudo = View::renderizar('admin/login', []);

    // return parent::paginaPegar('Login', $conteudo);
  }
}