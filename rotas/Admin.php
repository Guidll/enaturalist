<?php

use \App\Http\Resposta;
use \App\Controller\Admin;


// Rota base admin
$objetoRoteador->get('/admin', [
  function(){
    return new Resposta(200, 'admin =)');
  }
]);


// Rota login admin
$objetoRoteador->get('/admin/login', [
  function($requisicao){
    return new Resposta(200, Admin\Login::loginPegar($requisicao));
  }
]);

$objetoRoteador->post('/admin/login', [
  function($requisicao){
    // password_hash('gui123', PASSWORD_DEFAULT);
    return new Resposta(200, Admin\Login::loginDefinir($requisicao));
  }
]);