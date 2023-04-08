<?php

namespace App\Http;

class Requisicao
{
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

  public function __construct()
  {
    $this->httpMetodo = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->uri = $_SERVER['REQUEST_URI'] ?? '';
    $this->urlParametros = $_GET ?? [];
    $this->urlParametrosPost = $_POST ?? [];
    $this->cabecalho = self::cabecalhoPegar();
  }

  public function httpMetodoPegar()
  {
    return $this->httpMetodo;
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