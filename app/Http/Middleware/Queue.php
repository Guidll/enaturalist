<?php

namespace App\Http\Middleware;

use App\Http\Resposta;

class Queue
{
  // Mapeamento de middleswares
  private static $mapa = [];

  private $middlewares = [];

  // Middlewares padroes
  private static $padrao = [];

  private $controller;

  private $controllerParametros = [];


  public function __construct($middlewares, $controller, $controllerParametros)
  {
    $this->middlewares = array_merge(self::$padrao, $middlewares);
    $this->controller = $controller;
    $this->controllerParametros = $controllerParametros;
  }


  // Define mapeamento de middleswares
  public static function setMapa($mapa)
  {
    self::$mapa = $mapa;
  }

  // Define middleswares padroes
  public static function setPadrao($padrao)
  {
    self::$padrao = $padrao;
  }


  // Executa o proximo nivel da fila de middlewares
  public function proximo($requisicao)
  {
    // Verifcar se a fila está vazia
    if (empty($this->middlewares)) return call_user_func_array($this->controller,$this->controllerParametros);

    $middleware = array_shift($this->middlewares);

    // Verifica o mapa
    if (! isset(self::$mapa[$middleware])) {
      throw new \Exception('Problemas ao processar o middleware da requisição', 500);
    }

    // Proxima camada
    $fila = $this;
    $proximo = function($requisicao) use($fila) {
      return $fila->proximo($requisicao);
    };

    // Executa o middleware
    return (new self::$mapa[$middleware])->handle($requisicao, $proximo);
  }
}