<?php

use \App\Http\Resposta;
use \App\Controller\Paginas;


// Rota home
$objetoRoteador->get('/', [
  function(){
    return new Resposta(200, Paginas\Home::homePegar());
  }
]);

// Rota ecopontos
$objetoRoteador->get('/ecopontos', [
  function($requisicao){
    return new Resposta(200, Paginas\Ecopontos::ecopontosPegar($requisicao));
  }
]);

// Rota ecopontos (post - create)
$objetoRoteador->post('/ecopontos', [
  function($requisicao){
    return new Resposta(200, Paginas\Ecopontos::ecopontosCadastrar($requisicao));
  }
]);

// Rota dinamica
$objetoRoteador->get('/pagina/{id}/{acao}', [
  function($id, $acao){
    return new Resposta(200, 'Página ' . $id . ' - ' . $acao);
  }
]);