<?php
// --- <Includes> ---
require __DIR__ . '/vendor/autoload.php';

use \App\Http\Roteador;
use \App\Controller\Utilidades\View;
use \App\Controller\Utilidades\Ambiente;
use \App\Controller\Utilidades\Banco;
use \App\Http\Middleware\Queue as MiddlewareFila;



// Carrega variaveis de ambiente
Ambiente::load(__DIR__);

define('URL', getenv('URL'));

View::iniciar([
  'URL' => URL
]);

Banco::config(
  getenv('DB_HOST'),
  getenv('DB_NAME'),
  getenv('DB_USER'),
  getenv('DB_PASS'),
  getenv('DB_PORT'),
);

MiddlewareFila::setMapa([
  'maintenance' => \App\Http\Middleware\Maintenance::class,
  'admin-deslogado' => \App\Http\Middleware\AdminDeslogado::class,
  'admin-login' => \App\Http\Middleware\AdminLogin::class,
]);

MiddlewareFila::setPadrao([
  'maintenance',
]);
// --- </Includes> ---



// --- <Execucao> ---
$objetoRoteador = new Roteador(URL);

// Inclui o gerenciamento de conteudo das rotas
include __DIR__ . '/rotas/Paginas.php';

// Inclui o gerenciamento do admin
include __DIR__ . '/rotas/Admin.php';

// Exibi o conteuda da rota acessada
$objetoRoteador->executar()->respostaEnviar();
// --- </Execucao> ---