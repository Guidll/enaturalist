<?php

use \App\Http\Roteador;
use \App\Http\Resposta;
use \App\Controller\Paginas;

$objetoRoteador = new Roteador(URL);

// Rota home
$objetoRoteador->get('/', [
  function(){
    return new Resposta(200, Paginas\Home::homePegar());
  }
]);

// Rota ecopontos
$objetoRoteador->get('/ecopontos', [
  function(){
    return new Resposta(200, Paginas\Ecopontos::ecopontosPegar());
  }
]);

// Rota dinamica
$objetoRoteador->get('/pagina/{id}/{acao}', [
  function($id, $acao){
    return new Resposta(200, 'Página ' . $id . ' - ' . $acao);
  }
]);