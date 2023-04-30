<?php

namespace App\Http;

class Requisicao
{
  // Guarda a instancia do roteador
  private $roteador;

  // Guarda o metodo de acesso get/post
  private $httpMetodo;

  // Guarda a url completa
  private $uri;

  // Guarda os parametros da url
  private $urlParametros = [];

  // Guarda os parametros de post da url
  private $urlParametrosPost = [];

  // Guarda o cabecalho da requisicao
  private $cabecalho = [];

  public function __construct($roteador)
  {
    $this->roteador = $roteador;
    $this->urlParametros = $_GET ?? [];
    $this->urlParametrosPost = $_POST ?? [];
    $this->cabecalho = self::cabecalhoPegar();
    $this->httpMetodo = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->uriDefinir();
  }

  public function roteadorPegar()
  {
    return $this->roteador;
  }

  public function httpMetodoPegar()
  {
    return $this->httpMetodo;
  }

  public function uriDefinir()
  {
    // Uri completa
    $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    
    // Uri com gets separados por index
    $uriSeparada = explode('?', $this->uri);

    // Defini a uri
    $this->uri = $uriSeparada[0];
  }

  public function uriPegar()
  {
    return $this->uri;
  }

  public function cabecalhoPegar()
  {
    return $this->cabecalho;
  }

  public function urlParametrosPegar()
  {
    return $this->urlParametros;
  }

  public function urlParametrosPostPegar()
  {
    return $this->urlParametrosPost;
  }
}