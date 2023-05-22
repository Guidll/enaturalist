<?php

namespace App\Http\Middleware;

class Maintenance
{
  // Executa o middleware
  public function handle($requisicao, $proximo)
  {
    // Verifica o estado de manutenção da página
    if (getenv('MAINTENANCE') == 'true') {
      throw new \Exception('Página em manutenção.', 200);
    }

    // Executa o proximo nivel dos middlewares
    return $proximo($requisicao);
  }
}