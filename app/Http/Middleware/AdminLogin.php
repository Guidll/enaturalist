<?php

namespace App\Http\Middleware;

use \App\Sessao\Admin\Login as SessaoAdminLogin;

class AdminLogin
{
  // Executa o middleware
  public function handle($requisicao, $proximo)
  {
    // Verifica se usuario NAO esta logado
    if (! SessaoAdminLogin::logado()) {
      $requisicao->roteadorPegar()->redirecionar('/admin/login');
    }

    return $proximo($requisicao);
  }
}