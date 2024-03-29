<?php

use \App\Http\Resposta;
use \App\Controller\Admin;


// Rota admin base
$objetoRoteador->get('/admin', [
  'middlewares' => [
    'admin-login',
    'maintenance',
  ],
  function($requisicao){
    return new Resposta(200, Admin\Home::getHome($requisicao));
  }
]);

// Rota admin instituicao
$objetoRoteador->get('/admin/instituicao', [
  'middlewares' => [
    'admin-login',
    'maintenance',
  ],
  function($requisicao){
    return new Resposta(200, Admin\HomeInstituicao::getHome($requisicao));
  }
]);


// Rota admin login
$objetoRoteador->get('/admin/login', [
  'middlewares' => [
    'admin-deslogado',
    'maintenance',
  ],
  function($requisicao){
    return new Resposta(200, Admin\Login::loginPegar($requisicao));
  },
]);

$objetoRoteador->post('/admin/login', [
  'middlewares' => [
    'admin-deslogado',
    'maintenance',
  ],
  function($requisicao){
    return new Resposta(200, Admin\Login::loginDefinir($requisicao));
  }
]);


// Rota admin cadastro
$objetoRoteador->get('/admin/cadastro', [
  'middlewares' => [
    'admin-deslogado',
    'maintenance',
  ],
  function($requisicao){
    return new Resposta(200, Admin\Cadastro::getCadastro($requisicao));
  },
]);

$objetoRoteador->post('/admin/cadastro', [
  'middlewares' => [
    'admin-deslogado',
  ],
  function($requisicao){
    return new Resposta(200, Admin\Cadastro::setCadastro($requisicao));
  }
]);
// Rota admin cadastro instituicao
$objetoRoteador->get('/admin/cadastro-instituicao', [
  'middlewares' => [
    'admin-deslogado',
  ],
  function($requisicao){
    return new Resposta(200, Admin\Cadastro::getCadastroInstituicao($requisicao));
  },
]);

$objetoRoteador->post('/admin/cadastro-instituicao', [
  'middlewares' => [
    'admin-deslogado',
  ],
  function($requisicao){
    return new Resposta(200, Admin\Cadastro::setCadastroInstituicao($requisicao));
  }
]);


// Rota admin logout
$objetoRoteador->get('/admin/logout', [
  // 'middlewares'=> [
  //   'admin-login',
  // ],
  function($requisicao){
    return new Resposta(200, Admin\Login::setLogout($requisicao));
  }
]);


// Rota admin ecopontos
$objetoRoteador->get('/admin/ecopontos', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao){
    return new Resposta(200, Admin\Ecopontos::getEcopontos($requisicao));
  }
]);
// Criar
// $objetoRoteador->get('/admin/ecopontos/criar', [
//   'middlewares' => [
//     'admin-login',
//   ],
//   function($requisicao){
//     return new Resposta(200, Admin\Ecopontos::getNovoEcopontos($requisicao));
//   }
// ]);
// Editar
$objetoRoteador->get('/admin/ecopontos/{id}/editar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Ecopontos::getEcopontosEditar($requisicao, $id));
  }
]);
$objetoRoteador->post('/admin/ecopontos/{id}/editar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Ecopontos::setEcopontosEditar($requisicao, $id));
  }
]);

// Excluir
$objetoRoteador->get('/admin/ecopontos/{id}/excluir', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Ecopontos::getEcopontosExcluir($requisicao, $id));
  }
]);
$objetoRoteador->post('/admin/ecopontos/{id}/excluir', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Ecopontos::setEcopontosExcluir($requisicao, $id));
  }
]);


// Rota admin ecopontos instituicao
$objetoRoteador->get('/admin/ecopontos-instituicao', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao){
    return new Resposta(200, Admin\EcopontosInstituicao::getEcopontos($requisicao));
  }
]);
// Rota admin ecopontos instituicao
$objetoRoteador->post('/admin/ecopontos-instituicao', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao){
    return new Resposta(200, Admin\EcopontosInstituicao::setEcopontos($requisicao));
  }
]);

// Editar
$objetoRoteador->get('/admin/ecopontos-instituicao/{id}/editar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\EcopontosInstituicao::getEcopontosEditar($requisicao, $id));
  }
]);
$objetoRoteador->post('/admin/ecopontos-instituicao/{id}/editar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\EcopontosInstituicao::setEcopontosEditar($requisicao, $id));
  }
]);

// Excluir
$objetoRoteador->get('/admin/ecopontos-instituicao/{id}/excluir', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\EcopontosInstituicao::getEcopontosExcluir($requisicao, $id));
  }
]);
$objetoRoteador->post('/admin/ecopontos-instituicao/{id}/excluir', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\EcopontosInstituicao::setEcopontosExcluir($requisicao, $id));
  }
]);



// Rota admin doacao
$objetoRoteador->get('/admin/doacao', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao){
    return new Resposta(200, Admin\Doacao::getDoacao($requisicao));
  }
]);
$objetoRoteador->post('/admin/doacao', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao){
    return new Resposta(200, Admin\Doacao::setDoacao($requisicao));
  }
]);

// Editar
$objetoRoteador->get('/admin/doacao/{id}/editar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Doacao::getDoacaoEditar($requisicao, $id));
  }
]);
$objetoRoteador->post('/admin/doacao/{id}/editar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Doacao::setDoacaoEditar($requisicao, $id));
  }
]);

// Excluir
$objetoRoteador->get('/admin/doacao/{id}/excluir', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Doacao::getDoacaoExcluir($requisicao, $id));
  }
]);
// Excluir
$objetoRoteador->post('/admin/doacao/{id}/excluir', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Doacao::setDoacaoExcluir($requisicao, $id));
  }
]);

// Aceitar doacao
$objetoRoteador->get('/admin/doacao/{id}/aceitar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Doacao::getDoacaoAceitar($requisicao, $id));
  }
]);
$objetoRoteador->post('/admin/doacao/{id}/aceitar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Doacao::setDoacaoAceitar($requisicao, $id));
  }
]);

// Recusar doacao
$objetoRoteador->get('/admin/doacao/{id}/recusar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Doacao::getDoacaoRecusar($requisicao, $id));
  }
]);
$objetoRoteador->post('/admin/doacao/{id}/recusar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\Doacao::setDoacaoRecusar($requisicao, $id));
  }
]);


// Rota admin doacao instituicao
$objetoRoteador->get('/admin/doacao-instituicao', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao){
    return new Resposta(200, Admin\DoacaoInstituicao::getDoacao($requisicao));
  }
]);
$objetoRoteador->post('/admin/doacao-instituicao', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao){
    return new Resposta(200, Admin\DoacaoInstituicao::setDoacao($requisicao));
  }
]);
// Editar
$objetoRoteador->get('/admin/doacao-instituicao/{id}/editar-instituicao', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\DoacaoInstituicao::getDoacaoEditar($requisicao, $id));
  }
]);

$objetoRoteador->post('/admin/doacao-instituicao/{id}/editar-instituicao', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\DoacaoInstituicao::setDoacaoEditar($requisicao, $id));
  }
]);
// Excluir
$objetoRoteador->get('/admin/doacao-instituicao/{id}/excluir-instituicao', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\DoacaoInstituicao::getDoacaoExcluir($requisicao, $id));
  }
]);

$objetoRoteador->post('/admin/doacao-instituicao/{id}/excluir-instituicao', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao, $id){
    return new Resposta(200, Admin\DoacaoInstituicao::setDoacaoExcluir($requisicao, $id));
  }
]);

$objetoRoteador->get('/admin/doacao-instituicao/{id}/requisitar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao){
    return new Resposta(200, Admin\DoacaoInstituicao::getDoacaoRequisitar($requisicao));
  }
]);

$objetoRoteador->post('/admin/doacao-instituicao/{id}/requisitar', [
  'middlewares' => [
    'admin-login',
  ],
  function($requisicao){
    return new Resposta(200, Admin\DoacaoInstituicao::setDoacaoRequisitar($requisicao));
  }
]);