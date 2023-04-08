<?php

namespace App\Http;

class Resposta
{
  private $codigoStatus = 200;

  private $cabecalho = [];

  private $conteudo;

  private $tipoConteudo = 'text/html';

  public function __construct($codigoStatus, $conteudo, $tipoConteudo = 'text/html')
  {
    $this->codigoStatus = $codigoStatus;
    $this->conteudo = $conteudo;
    $this->tipoConteudoDefinir($tipoConteudo);
  }

  public function tipoConteudoDefinir($tipoConteudo)
  {
    $this->tipoConteudo = $tipoConteudo;
    $this->cabecalhoAdicionar('Content-Type', $tipoConteudo);
  }

  public function cabecalhoAdicionar($chave, $valor)
  {
    $this->cabecalho[$chave] = $valor;
  }

  private function cabecalhoEnviar()
  {
    http_response_code($this->codigoStatus);

    foreach($this->cabecalho as $chave=>$valor) {
      header($chave . ': ' . $valor);
    }
  }

  public function respostaEnviar()
  {
    $this->cabecalhoEnviar();
    
    switch($this->tipoConteudo) {
      case 'text/html':
        echo $this->conteudo;
        exit;
        break;
    }
  }
}