<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

class Roteador
{
  // Url completa
  private $url = '';

  private $prefixo = '';

  // Indice de rotas
  private $rotas = [];

  // Instancia de request
  private $requisicao;

  public function __construct($url)
  {
    $this->requisicao = new Requisicao($this);
    $this->url = $url;
    $this->prefixoDefinir();
  }


  private function prefixoDefinir()
  {
    $parseUrl = parse_url($this->url);

    $this->prefixo = $parseUrl['path'] ?? '';
  }


  private function rotaAdicionar($metodo, $rota, $parametros = [])
  {
    foreach($parametros as $chave=>$valor) {

      if ($valor instanceof Closure) {
        $parametros['controller'] = $valor;
        unset($parametros[$chave]);
        continue;
      }
    }

    // Variaveis de rota
    $parametros['variaveis'] = [];

    $padraoVariaveis = '/{(.*?)}/';

    if (preg_match_all($padraoVariaveis, $rota, $validos)) {
      $rota = preg_replace($padraoVariaveis, '(.*?)', $rota);
      $parametros['variaveis'] = $validos[1];
    }

    // Regex para validar rota
    $padraoRota = '/^' . str_replace('/','\/',$rota) . '$/';

    $this->rotas[$padraoRota][$metodo] = $parametros;
  }


  public function get($rota, $parametros = [])
  {
    return $this->rotaAdicionar('GET', $rota, $parametros);
  }


  public function post($rota, $parametros = [])
  {
    return $this->rotaAdicionar('POST', $rota, $parametros);
  }


  public function put($rota, $parametros = [])
  {
    return $this->rotaAdicionar('PUT', $rota, $parametros);
  }


  public function delete($rota, $parametros = [])
  {
    return $this->rotaAdicionar('DELETE', $rota, $parametros);
  }


  public function executar()
  {
    try {
      $rota = $this->rotaPegar();

      if (! isset($rota['controller'])) {
        throw new Exception('A url não pode ser processadas', 500);
      }

      $argumentos = [];

      $reflection = new ReflectionFunction($rota['controller']);

      foreach($reflection->getParameters() as $parametro) {
        $nome = $parametro->getName();
        $argumentos[$nome] = $rota['variaveis'][$nome] ?? '';
      }

      return call_user_func_array($rota['controller'], $argumentos);
    }
    catch (Exception $e) {
      return new Resposta($e->getCode(), $e->getMessage());
    }
  }


  private function rotaPegar()
  {
    $uri = $this->uriRetornar();

    $metodoHttp = $this->requisicao->httpMetodoPegar();

    foreach($this->rotas as $padraoRota=>$metodos) {

      // Verifica se a uri bate com o padrão
      if (preg_match($padraoRota, $uri, $validos)) {

        if (isset($metodos[$metodoHttp])) {
          // Remove o primeiro item que é desnecessario
          unset($validos[0]);

          $chave = $metodos[$metodoHttp]['variaveis'];
          $metodos[$metodoHttp]['variaveis'] = array_combine($chave, $validos);
          $metodos[$metodoHttp]['variaveis']['requisicao'] = $this->requisicao;

          return $metodos[$metodoHttp];
        }

        throw new Exception('Método não permitido', 405);
      }
    }

    throw new Exception('Página não encontrada', 404);
  }


  private function uriRetornar()
  {
    $uri = $this->requisicao->uriPegar();
    $uriTratada = strlen($this->prefixo) ? explode($this->prefixo, $uri) : [uri];

    return end($uriTratada);
  }


  public function urlAtualPegar()
  {
    return $this->url . $this->uriRetornar();
  }

  public function redirecionar($rota)
  {
    $url = $this->url . $rota;

    header('location:' . $url);
    exit;
  }
}