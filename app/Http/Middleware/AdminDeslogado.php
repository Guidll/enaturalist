<?php

namespace App\Http\Middleware;

use \App\Sessao\Admin\Login as SessaoAdminLogin;

class AdminDeslogado
{
  // Executa o middleware
  public function handle($requisicao, $proximo)
  {
    // Verifica se usuario esta logado
    if (SessaoAdminLogin::logado()) {
      $requisicao->roteadorPegar()->redirecionar('/admin');
    }

    return $proximo($requisicao);
  }
}