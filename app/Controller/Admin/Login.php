<?php

namespace App\Controller\Admin;

use \App\Controller\Utilidades\View;
use \App\Model\Entidades\Usuario;
use \App\Sessao\Admin\Login as SessaoLogin;

class Login extends Pagina
{
  public static function loginPegar($requisicao, $mensagemErro = null)
  {
    $status = ! is_null($mensagemErro) ? Alerta::getErro($mensagemErro) : '';

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

    self::usuarioVerificar($requisicao);
  }


  // Verifica que tipo de usuário logou
  public static function usuarioVerificar($requisicao)
  {
    $usuarioCnpj = Usuario::getUsuarioCnpj();

    if (! $usuarioCnpj) {
      // Usuario pessoal fisica
      return $requisicao->roteadorPegar()->redirecionar('/admin');
    }
    else {
      // Usuario pessoal juridica 
      return $requisicao->roteadorPegar()->redirecionar('/admin/instituicao');
    }
  }


  // Desloga o usuario
  public static function setLogout($requisicao) {
    // Destroi sessao login
    SessaoLogin::logout();

    // Redireciona o usuario para o login
    $requisicao->roteadorPegar()->redirecionar('/admin/login');
  }
}